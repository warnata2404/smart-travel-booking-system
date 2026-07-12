<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Reward;
use Illuminate\Database\Eloquent\Collection;

class RewardService
{
    /**
     * Get all rewards.
     *
     * @return Collection<int, Reward>
     */
    public function getAll(): Collection
    {
        return Reward::query()
            ->with([
                'customer',
                'trip',
                'rewardConfiguration',
                'voucher',
            ])
            ->latest()
            ->get();
    }

    /**
     * Get reward by ID.
     */
    public function getById(int $id): Reward
    {
        return Reward::query()
            ->with([
                'customer',
                'trip',
                'rewardConfiguration',
                'voucher',
            ])
            ->findOrFail($id);
    }
}
