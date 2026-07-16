<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RewardConfigurationStatus;
use App\Enums\WeatherConfigurationStatus;
use App\Models\City;
use App\Models\Destination;
use App\Models\RewardConfiguration;
use App\Models\WeatherConfiguration;

class TravelAnalysisService
{
    /**
     * Analyze travel information.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public function analyze(array $data): array
    {
        $originCity = City::query()
            ->findOrFail($data['origin_city_id']);

        $destination = Destination::query()
            ->with('city')
            ->findOrFail($data['destination_id']);

        /*
        |--------------------------------------------------------------------------
        | Weather Configuration
        |--------------------------------------------------------------------------
        |
        | The application is not yet integrated with a Weather API.
        | Therefore, the active weather configuration is used as the
        | recommendation source. This query can be replaced later with
        | actual weather analysis.
        |
        */

        $weatherConfiguration = WeatherConfiguration::query()
            ->where(
                'status',
                WeatherConfigurationStatus::ACTIVE,
            )
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Reward Configuration
        |--------------------------------------------------------------------------
        */

        $rewardConfiguration = RewardConfiguration::query()
            ->where(
                'status',
                RewardConfigurationStatus::ACTIVE,
            )
            ->where(
                'minimum_distance',
                '<=',
                $destination->distance,
            )
            ->orderByDesc('minimum_distance')
            ->first();

        return [
            'origin_city_id' => $originCity->id,

            'origin_city' => $originCity->name,

            'destination_id' => $destination->id,

            'destination' => $destination->name,

            'destination_city' => $destination->city->name,

            'departure_date' => $data['departure_date'],

            'departure_time' => $data['departure_time'],

            'distance' => $destination->distance,

            'estimated_duration' => $destination->estimated_duration,

            'price' => $destination->price,

            'weather' => $weatherConfiguration?->weather,

            'recommendation' => $weatherConfiguration?->recommendation,

            'reward' => $rewardConfiguration?->reward_name,

            'discount_percentage' => $rewardConfiguration?->discount_percentage,
        ];
    }
}
