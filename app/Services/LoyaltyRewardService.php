<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RewardConfigurationStatus;
use App\Enums\TripStatus;
use App\Enums\VoucherStatus;
use App\Models\Reward;
use App\Models\RewardConfiguration;
use App\Models\Trip;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoyaltyRewardService
{
    /**
     * Generate reward and voucher after trip completion.
     */
    public function generate(Trip $trip): ?Reward
    {
        if ($trip->status !== TripStatus::COMPLETED) {
            return null;
        }

        return DB::transaction(function () use ($trip): ?Reward {

            $customer = $trip->booking->customer;

            $totalDistance = Trip::query()
                ->whereHas('booking', function ($query) use ($customer) {
                    $query->where('customer_id', $customer->id);
                })
                ->where('status', TripStatus::COMPLETED)
                ->get()
                ->sum(fn(Trip $completedTrip) => (float) $completedTrip->booking->distance);

            $rewardConfiguration = RewardConfiguration::query()
                ->where('status', RewardConfigurationStatus::ACTIVE)
                ->where('minimum_distance', '<=', $totalDistance)
                ->orderByDesc('minimum_distance')
                ->first();

            if ($rewardConfiguration === null) {
                return null;
            }

            $reward = Reward::create([
                'customer_id' => $customer->id,
                'trip_id' => $trip->id,
                'reward_configuration_id' => $rewardConfiguration->id,
                'total_distance' => $totalDistance,
                'generated_at' => now(),
            ]);

            Voucher::create([
                'reward_id' => $reward->id,
                'code' => strtoupper(Str::random(10)),
                'discount_percentage' => $rewardConfiguration->discount_percentage,
                'expired_at' => Carbon::now()->addDays(30),
                'status' => VoucherStatus::ACTIVE,
            ]);

            return $reward;
        });
    }
}
