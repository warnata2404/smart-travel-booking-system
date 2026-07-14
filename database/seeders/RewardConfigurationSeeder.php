<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RewardConfigurationStatus;
use App\Models\RewardConfiguration;
use Illuminate\Database\Seeder;

class RewardConfigurationSeeder extends Seeder
{
    /**
     * Seed reward configurations.
     */
    public function run(): void
    {
        $rewardConfigurations = [
            [
                'minimum_distance' => 10,
                'reward_name' => 'Bronze Reward',
                'discount_percentage' => 5,
            ],
            [
                'minimum_distance' => 50,
                'reward_name' => 'Silver Reward',
                'discount_percentage' => 10,
            ],
            [
                'minimum_distance' => 100,
                'reward_name' => 'Gold Reward',
                'discount_percentage' => 15,
            ],
            [
                'minimum_distance' => 200,
                'reward_name' => 'Platinum Reward',
                'discount_percentage' => 20,
            ],
            [
                'minimum_distance' => 500,
                'reward_name' => 'Diamond Reward',
                'discount_percentage' => 25,
            ],
        ];

        foreach ($rewardConfigurations as $rewardConfiguration) {

            RewardConfiguration::query()->updateOrCreate(
                [
                    'minimum_distance' => $rewardConfiguration['minimum_distance'],
                ],
                [
                    'reward_name' => $rewardConfiguration['reward_name'],
                    'discount_percentage' => $rewardConfiguration['discount_percentage'],
                    'status' => RewardConfigurationStatus::ACTIVE,
                ],
            );
        }
    }
}
