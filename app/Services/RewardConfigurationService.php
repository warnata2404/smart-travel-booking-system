<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\RewardConfiguration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class RewardConfigurationService
{
    /**
     * Get all reward configurations.
     *
     * @return Collection<int, RewardConfiguration>
     */
    public function getAll(): Collection
    {
        return RewardConfiguration::query()
            ->orderBy('minimum_distance')
            ->get();
    }

    /**
     * Get reward configuration by ID.
     */
    public function getById(int $id): RewardConfiguration
    {
        return RewardConfiguration::query()
            ->findOrFail($id);
    }

    /**
     * Create reward configuration.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): RewardConfiguration
    {
        return DB::transaction(
            fn(): RewardConfiguration => RewardConfiguration::query()->create($data)
        );
    }

    /**
     * Update reward configuration.
     *
     * @param array<string, mixed> $data
     */
    public function update(
        RewardConfiguration $rewardConfiguration,
        array $data,
    ): RewardConfiguration {
        return DB::transaction(function () use (
            $rewardConfiguration,
            $data
        ): RewardConfiguration {

            $rewardConfiguration->update($data);

            return $rewardConfiguration->fresh();
        });
    }

    /**
     * Delete reward configuration.
     */
    public function delete(
        RewardConfiguration $rewardConfiguration,
    ): void {
        DB::transaction(function () use (
            $rewardConfiguration
        ): void {

            $rewardConfiguration->delete();
        });
    }
}
