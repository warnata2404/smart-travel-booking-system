<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\WeatherConfiguration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class WeatherConfigurationService
{
    /**
     * Get all weather configurations.
     *
     * @return Collection<int, WeatherConfiguration>
     */
    public function getAll(): Collection
    {
        return WeatherConfiguration::query()
            ->orderByRaw("
                CASE rule_type
                    WHEN 'SUNNY' THEN 1
                    WHEN 'CLOUDY' THEN 2
                    WHEN 'RAIN' THEN 3
                END
            ")
            ->get();
    }

    /**
     * Get weather configuration by ID.
     */
    public function getById(int $id): WeatherConfiguration
    {
        return WeatherConfiguration::query()
            ->findOrFail($id);
    }

    /**
     * Create weather configuration.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): WeatherConfiguration
    {
        return DB::transaction(
            fn(): WeatherConfiguration => WeatherConfiguration::query()->create($data)
        );
    }

    /**
     * Update weather configuration.
     *
     * @param array<string, mixed> $data
     */
    public function update(
        WeatherConfiguration $weatherConfiguration,
        array $data,
    ): WeatherConfiguration {
        return DB::transaction(function () use (
            $weatherConfiguration,
            $data
        ): WeatherConfiguration {

            $weatherConfiguration->update($data);

            return $weatherConfiguration->fresh();
        });
    }

    /**
     * Delete weather configuration.
     */
    public function delete(
        WeatherConfiguration $weatherConfiguration,
    ): void {
        DB::transaction(function () use (
            $weatherConfiguration
        ): void {

            $weatherConfiguration->delete();
        });
    }
}
