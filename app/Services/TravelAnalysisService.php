<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Destination;
use App\Models\RewardConfiguration;
use App\Models\WeatherConfiguration;

class TravelAnalysisService
{
    /**
     * Analyze travel information.
     *
     * @return array<string, mixed>
     */
    public function analyze(
        int $originCityId,
        int $destinationCityId,
        int $destinationId,
        string $departureDate,
        string $departureTime,
    ): array {
        $destination = Destination::findOrFail($destinationId);

        $weatherConfiguration = WeatherConfiguration::query()
            ->first();

        $rewardConfiguration = RewardConfiguration::query()
            ->where('minimum_distance', '<=', $destination->distance)
            ->orderByDesc('minimum_distance')
            ->first();

        return [
            'weather' => $weatherConfiguration?->weather,
            'distance' => $destination->distance,
            'estimated_duration' => $destination->estimated_duration,
            'estimated_reward' => $rewardConfiguration?->reward_name,
            'recommendation' => $weatherConfiguration?->recommendation,
        ];
    }
}
