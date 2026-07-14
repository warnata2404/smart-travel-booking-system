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
                'price' => 150000,
                'distance' => 15.50,
                'estimated_duration' => 45,
                'description' => 'Family tourism destination.',
            ],
            [
                'city' => 'Bandung',
                'name' => 'Floating Market',
                'category' => DestinationCategory::OUTDOOR,
                'price' => 175000,
                'distance' => 18.20,
                'estimated_duration' => 50,
                'description' => 'Floating culinary destination.',
            ],
            [
                'city' => 'Jakarta',
                'name' => 'Monumen Nasional',
                'category' => DestinationCategory::INDOOR,
                'price' => 120000,
                'distance' => 8.00,
                'estimated_duration' => 30,
                'description' => 'National monument.',
            ],
            [
                'city' => 'Yogyakarta',
                'name' => 'Malioboro',
                'category' => DestinationCategory::OUTDOOR,
                'price' => 100000,
                'distance' => 5.30,
                'estimated_duration' => 20,
                'description' => 'Shopping and culinary area.',
            ],
            [
                'city' => 'Denpasar',
                'name' => 'Pantai Sanur',
                'category' => DestinationCategory::OUTDOOR,
                'price' => 200000,
                'distance' => 12.00,
                'estimated_duration' => 35,
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
                    'price' => $destination['price'],
                    'distance' => $destination['distance'],
                    'estimated_duration' => $destination['estimated_duration'],
                    'description' => $destination['description'],
                    'status' => DestinationStatus::ACTIVE,
                ],
            );
        }
    }
}
