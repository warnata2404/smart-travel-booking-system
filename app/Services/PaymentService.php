<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Enums\TripStatus;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Create a payment and complete the payment workflow.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Payment
    {
        return DB::transaction(function () use ($data): Payment {

            $payment = Payment::create([
                'payment_number' => $data['payment_number'],
                'booking_id' => $data['booking_id'],
                'voucher_id' => $data['voucher_id'] ?? null,
                'subtotal' => $data['subtotal'],
                'discount' => $data['discount'],
                'grand_total' => $data['grand_total'],
                'payment_proof' => $data['payment_proof'],
                'status' => PaymentStatus::PAID,
                'paid_at' => now(),
            ]);

            $booking = Booking::findOrFail($data['booking_id']);

            $booking->update([
                'status' => BookingStatus::CONFIRMED,
            ]);

            Trip::create([
                'booking_id' => $booking->id,
                'status' => TripStatus::NOT_STARTED,
            ]);

            return $payment;
        });
    }
}
