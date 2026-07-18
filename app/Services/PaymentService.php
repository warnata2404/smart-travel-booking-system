<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Enums\TripStatus;
use App\Enums\UserRole;
use App\Enums\VoucherStatus;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Trip;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Get all payments.
     *
     * Admin:
     * - View all payments.
     *
     * Customer:
     * - View own payments only.
     *
     * @return Collection<int, Payment>
     */
    public function getAll(): Collection
    {
        $query = Payment::query()
            ->with([
                'booking.customer',
                'booking.originCity',
                'booking.destination',
                'voucher',
            ])
            ->latest();

        if (Auth::user()?->role === UserRole::CUSTOMER) {
            $query->whereHas('booking', function ($query): void {
                $query->where(
                    'customer_id',
                    Auth::id(),
                );
            });
        }

        return $query->get();
    }

    /**
     * Get payment by ID.
     *
     * Admin:
     * - View any payment.
     *
     * Customer:
     * - View own payment only.
     */
    public function getById(int $id): Payment
    {
        $query = Payment::query()
            ->with([
                'booking.customer',
                'booking.originCity',
                'booking.destination',
                'voucher',
            ])
            ->whereKey($id);

        if (Auth::user()?->role === UserRole::CUSTOMER) {
            $query->whereHas('booking', function ($query): void {
                $query->where(
                    'customer_id',
                    Auth::id(),
                );
            });
        }

        return $query->firstOrFail();
    }

    /**
     * Get bookings available for payment.
     *
     * @return Collection<int, Booking>
     */
    public function getAvailableBookings(): Collection
    {
        $query = Booking::query()
            ->with([
                'customer',
                'originCity',
                'destination',
            ])
            ->where(
                'status',
                BookingStatus::PENDING_PAYMENT,
            )
            ->latest();

        if (Auth::user()?->role === UserRole::CUSTOMER) {
            $query->where(
                'customer_id',
                Auth::id(),
            );
        }

        return $query->get();
    }

    /**
     * Get vouchers available for payment.
     *
     * @return Collection<int, Voucher>
     */
    public function getAvailableVouchers(): Collection
    {
        $query = Voucher::query()
            ->with([
                'reward.rewardConfiguration',
            ])
            ->where(
                'status',
                VoucherStatus::ACTIVE,
            )
            ->where(
                'expired_at',
                '>',
                now(),
            )
            ->orderBy('expired_at');

        if (Auth::user()?->role === UserRole::CUSTOMER) {
            $query->whereHas('reward', function ($query): void {
                $query->where(
                    'customer_id',
                    Auth::id(),
                );
            });
        }

        return $query->get();
    }

    /**
     * Create payment.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Payment
    {
        return DB::transaction(function () use ($data): Payment {

            /*
        |--------------------------------------------------------------------------
        | Booking
        |--------------------------------------------------------------------------
        */

            $booking = Booking::query()
                ->findOrFail($data['booking_id']);

            if ($booking->status !== BookingStatus::PENDING_PAYMENT) {
                abort(422, 'Booking is not eligible for payment.');
            }

            /*
        |--------------------------------------------------------------------------
        | Customer can only pay own booking
        |--------------------------------------------------------------------------
        */

            if (
                Auth::user()?->role === UserRole::CUSTOMER &&
                $booking->customer_id !== Auth::id()
            ) {
                abort(403);
            }

            /*
        |--------------------------------------------------------------------------
        | Voucher (Optional)
        |--------------------------------------------------------------------------
        */

            $voucher = null;
            $discount = 0;

            if (!empty($data['voucher_id'])) {

                $voucherQuery = Voucher::query()
                    ->with('reward')
                    ->whereKey($data['voucher_id'])
                    ->where(
                        'status',
                        VoucherStatus::ACTIVE,
                    )
                    ->where(
                        'expired_at',
                        '>',
                        now(),
                    );

                if (Auth::user()?->role === UserRole::CUSTOMER) {
                    $voucherQuery->whereHas(
                        'reward',
                        function ($query): void {
                            $query->where(
                                'customer_id',
                                Auth::id(),
                            );
                        },
                    );
                }

                $voucher = $voucherQuery->firstOrFail();

                $discount = round(
                    $booking->price * ($voucher->discount_percentage / 100),
                    2,
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Payment Calculation
        |--------------------------------------------------------------------------
        */

            $subtotal = $booking->price;

            $grandTotal = max(
                0,
                $subtotal - $discount,
            );

            /*
        |--------------------------------------------------------------------------
        | Upload Payment Proof
        |--------------------------------------------------------------------------
        */

            $paymentProof = $data['payment_proof']->store(
                'payments',
                'public',
            );

            $payment = Payment::query()->create([
                'payment_number' => $this->generatePaymentNumber(),

                'booking_id' => $booking->id,

                'voucher_id' => $voucher?->id,

                'subtotal' => $subtotal,

                'discount' => $discount,

                'grand_total' => $grandTotal,

                'payment_proof' => $paymentProof,

                'status' => PaymentStatus::PAID,

                'paid_at' => now(),
            ]);



            if ($voucher !== null) {
                $voucher->update([
                    'status' => VoucherStatus::USED,
                ]);
            }

            $booking->update([
                'status' => BookingStatus::CONFIRMED,
            ]);

            Trip::query()->firstOrCreate(
                [
                    'booking_id' => $booking->id,
                ],
                [
                    'status' => TripStatus::NOT_STARTED,
                ],
            );

            return $payment;
        });
    }

    /**
     * Generate unique payment number.
     */
    private function generatePaymentNumber(): string
    {
        do {
            $paymentNumber = sprintf(
                'PAY-%s-%04d',
                now()->format('YmdHis'),
                random_int(1, 9999),
            );
        } while (
            Payment::query()
            ->where(
                'payment_number',
                $paymentNumber,
            )
            ->exists()
        );

        return $paymentNumber;
    }
}
