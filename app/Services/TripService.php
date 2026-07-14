<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\TripStatus;
use App\Enums\UserRole;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TripService
{
    public function __construct(
        private readonly RewardService $rewardService,
        private readonly VoucherService $voucherService,
    ) {}

    /**
     * Get all trips.
     *
     * Admin:
     * - View all trips.
     *
     * Customer:
     * - View own trips only.
     *
     * @return Collection<int, Trip>
     */
    public function getAll(): Collection
    {
        $query = Trip::query()
            ->with([
                'booking.customer',
                'booking.originCity',
                'booking.destination',
                'reward.voucher',
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
     * Get trip by ID.
     */
    public function getById(int $id): Trip
    {
        $query = Trip::query()
            ->with([
                'booking.customer',
                'booking.originCity',
                'booking.destination',
                'reward.voucher',
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
     * Start trip.
     */
    public function start(Trip $trip): Trip
    {
        return DB::transaction(function () use ($trip): Trip {

            if ($trip->status !== TripStatus::NOT_STARTED) {
                return $trip->fresh([
                    'booking.customer',
                    'booking.originCity',
                    'booking.destination',
                    'reward.voucher',
                ]);
            }

            if ($trip->booking->status !== BookingStatus::CONFIRMED) {
                abort(422, 'Booking is not ready to start.');
            }

            $trip->update([
                'status' => TripStatus::ON_GOING,
                'started_at' => now(),
            ]);

            return $trip->fresh([
                'booking.customer',
                'booking.originCity',
                'booking.destination',
                'reward.voucher',
            ]);
        });
    }

    /**
     * Complete trip.
     */
    public function complete(Trip $trip): Trip
    {
        return DB::transaction(function () use ($trip): Trip {

            if ($trip->status !== TripStatus::ON_GOING) {
                return $trip->fresh([
                    'booking.customer',
                    'booking.originCity',
                    'booking.destination',
                    'reward.voucher',
                ]);
            }

            $trip->update([
                'status' => TripStatus::COMPLETED,
                'completed_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Generate Reward
            |--------------------------------------------------------------------------
            */

            $reward = $this->rewardService->generate($trip);

            /*
            |--------------------------------------------------------------------------
            | Generate Voucher
            |--------------------------------------------------------------------------
            */

            $this->voucherService->generate($reward);

            return $trip->fresh([
                'booking.customer',
                'booking.originCity',
                'booking.destination',
                'reward.voucher',
            ]);
        });
    }
}
