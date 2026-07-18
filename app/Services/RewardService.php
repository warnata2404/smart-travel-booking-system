<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RewardConfigurationStatus;
use App\Enums\UserRole;
use App\Models\Reward;
use App\Models\RewardConfiguration;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RewardService
{
    /**
     * Get all rewards.
     *
     * Admin:
     * - View all rewards.
     *
     * Customer:
     * - View own rewards only.
     *
     * @return Collection<int, Reward>
     */
    public function getAll(): Collection
    {
        $query = Reward::query()
            ->with([
                'customer',
                'trip.booking.destination',
                'rewardConfiguration',
                'voucher',
            ])
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
     * Get reward by ID.
     */
    public function getById(int $id): Reward
    {
        $query = Reward::query()
            ->with([
                'customer',
                'trip.booking.destination',
                'rewardConfiguration',
                'voucher',
            ])
            ->whereKey($id);

        if (Auth::user()?->role === UserRole::CUSTOMER) {
            $query->where(
                'customer_id',
                Auth::id(),
            );
        }

        return $query->firstOrFail();
    }

    /**
     * Generate reward after trip completed.
     */
    public function generate(Trip $trip): Reward
    {
        return DB::transaction(function () use ($trip): Reward {

            $trip->loadMissing('booking');

            /*
            |--------------------------------------------------------------------------
            | Prevent duplicate reward
            |--------------------------------------------------------------------------
            */

            $existingReward = Reward::query()
                ->where('trip_id', $trip->id)
                ->first();

            if ($existingReward !== null) {
                return $existingReward;
            }

            /*
            |--------------------------------------------------------------------------
            | Find active reward configuration
            |--------------------------------------------------------------------------
            */

            $travelDistance = (int) floor((float) $trip->booking->distance);

            $rewardConfiguration = RewardConfiguration::query()
                ->where(
                    'status',
                    RewardConfigurationStatus::ACTIVE,
                )
                ->where(
                    'minimum_distance',
                    '<=',
                    $travelDistance,
                )
                ->orderByDesc('minimum_distance')
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Create reward
            |--------------------------------------------------------------------------
            */

            $reward = Reward::query()->create([
                'customer_id' => $trip->booking->customer_id,

                'trip_id' => $trip->id,

                'reward_configuration_id' => $rewardConfiguration->id,

                'total_distance' => $trip->booking->distance,

                'generated_at' => now(),
            ]);

            return $reward->fresh([
                'customer',
                'trip.booking.destination',
                'rewardConfiguration',
                'voucher',
            ]);
        });
    }
}
