<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RewardConfigurationStatus;
use App\Enums\WeatherConfigurationStatus;
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
        $destination = Destination::query()
            ->with('city')
            ->findOrFail($data['destination_id']);

        /*
        |--------------------------------------------------------------------------
        | Weather Configuration
        |--------------------------------------------------------------------------
        |
        | Saat ini aplikasi belum terintegrasi dengan Weather API.
        | Oleh karena itu digunakan konfigurasi cuaca aktif sebagai sumber
        | rekomendasi. Di tahap berikutnya query ini dapat diganti berdasarkan
        | hasil analisis cuaca aktual.
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
            'origin_city_id' => $data['origin_city_id'],

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
