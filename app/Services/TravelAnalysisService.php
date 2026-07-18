<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RewardConfigurationStatus;
use App\Enums\TravelRouteStatus;
use App\Enums\WeatherConfigurationStatus;
use App\Models\City;
use App\Models\RewardConfiguration;
use App\Models\TravelRoute;
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

        /*
        |--------------------------------------------------------------------------
        | Travel Route
        |--------------------------------------------------------------------------
        */

        $travelRoute = TravelRoute::query()
            ->with([
                'originCity',
                'destination',
                'destination.city',
            ])
            ->where(
                'origin_city_id',
                $data['origin_city_id'],
            )
            ->where(
                'destination_id',
                $data['destination_id'],
            )
            ->where(
                'status',
                TravelRouteStatus::ACTIVE,
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Weather Configuration
        |--------------------------------------------------------------------------
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
        |
        | Reward thresholds are stored as integers (kilometers), while travel
        | routes store distance as decimal values. Convert the travel distance
        | to an integer before comparing it with the reward configuration.
        |
        */

        $travelDistance = (int) floor((float) $travelRoute->distance);

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
            ->first();

        return [

            'travel_route_id' => $travelRoute->id,

            'origin_city_id' => $travelRoute->origin_city_id,

            'origin_city' => $travelRoute->originCity->name,

            'destination_id' => $travelRoute->destination_id,

            'destination' => $travelRoute->destination->name,

            'destination_city' => $travelRoute->destination->city->name,

            'destination_category' => $travelRoute->destination->category,

            'departure_date' => $data['departure_date'],

            'departure_time' => $data['departure_time'],

            'distance' => $travelRoute->distance,

            'estimated_duration' => $travelRoute->estimated_duration,

            'price' => $travelRoute->base_price,

            'weather' => $weatherConfiguration?->weather,

            'recommendation' => $weatherConfiguration?->recommendation,

            'reward' => $rewardConfiguration?->reward_name,

            'discount_percentage' => $rewardConfiguration?->discount_percentage,

        ];
    }
}
