<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\DestinationCategory;
use App\Enums\DestinationStatus;
use App\Models\City;
use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationSeeder extends Seeder
{
    /**
     * Seed destinations.
     */
    public function run(): void
    {
        $cities = City::query()
            ->pluck('id', 'name');

        $destinations = [

            [
                'city' => 'Bandung',
                'name' => 'Farm House Lembang',
                'category' => DestinationCategory::OUTDOOR,
                'description' => 'Family tourism destination.',
            ],

            [
                'city' => 'Bandung',
                'name' => 'Floating Market',
                'category' => DestinationCategory::OUTDOOR,
                'description' => 'Floating culinary destination.',
            ],

            [
                'city' => 'Jakarta',
                'name' => 'Monumen Nasional',
                'category' => DestinationCategory::INDOOR,
                'description' => 'National monument.',
            ],

            [
                'city' => 'Yogyakarta',
                'name' => 'Malioboro',
                'category' => DestinationCategory::OUTDOOR,
                'description' => 'Shopping and culinary area.',
            ],

            [
                'city' => 'Denpasar',
                'name' => 'Pantai Sanur',
                'category' => DestinationCategory::OUTDOOR,
                'description' => 'Beach tourism destination.',
            ],

        ];

        foreach ($destinations as $destination) {

            Destination::query()->updateOrCreate(
                [
                    'city_id' => $cities[$destination['city']],
                    'name' => $destination['name'],
                ],
                [
                    'category' => $destination['category'],
                    'description' => $destination['description'],
                    'status' => DestinationStatus::ACTIVE,
                ],
            );
        }
    }
}
