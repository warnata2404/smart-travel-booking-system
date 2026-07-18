<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\TravelRouteStatus;
use App\Models\City;
use App\Models\Destination;
use App\Models\TravelRoute;
use Illuminate\Database\Seeder;
use RuntimeException;

class TravelRouteSeeder extends Seeder
{
    /**
     * Seed travel routes.
     */
    public function run(): void
    {
        $cities = City::query()
            ->pluck('id', 'name');

        $destinations = Destination::query()
            ->get()
            ->keyBy('name');

        $travelRoutes = [

            [
                'origin_city' => 'Jakarta',
                'destination' => 'Farm House Lembang',
                'distance' => 152.50,
                'estimated_duration' => 180,
                'base_price' => 250000,
            ],

            [
                'origin_city' => 'Jakarta',
                'destination' => 'Floating Market',
                'distance' => 154.80,
                'estimated_duration' => 185,
                'base_price' => 255000,
            ],

            [
                'origin_city' => 'Bandung',
                'destination' => 'Farm House Lembang',
                'distance' => 15.50,
                'estimated_duration' => 45,
                'base_price' => 150000,
            ],

            [
                'origin_city' => 'Bandung',
                'destination' => 'Floating Market',
                'distance' => 18.20,
                'estimated_duration' => 50,
                'base_price' => 175000,
            ],

            [
                'origin_city' => 'Yogyakarta',
                'destination' => 'Malioboro',
                'distance' => 5.30,
                'estimated_duration' => 20,
                'base_price' => 100000,
            ],

            [
                'origin_city' => 'Denpasar',
                'destination' => 'Pantai Sanur',
                'distance' => 12.00,
                'estimated_duration' => 35,
                'base_price' => 200000,
            ],

            [
                'origin_city' => 'Surabaya',
                'destination' => 'Monumen Nasional',
                'distance' => 780.00,
                'estimated_duration' => 600,
                'base_price' => 650000,
            ],

        ];

        foreach ($travelRoutes as $travelRoute) {

            $originCityId = $cities[$travelRoute['origin_city']] ?? null;

            if ($originCityId === null) {
                throw new RuntimeException(
                    "Origin city '{$travelRoute['origin_city']}' was not found."
                );
            }

            $destination = $destinations->get($travelRoute['destination']);

            if ($destination === null) {
                throw new RuntimeException(
                    "Destination '{$travelRoute['destination']}' was not found."
                );
            }

            TravelRoute::query()->updateOrCreate(
                [
                    'origin_city_id' => $originCityId,
                    'destination_id' => $destination->id,
                ],
                [
                    'distance' => $travelRoute['distance'],
                    'estimated_duration' => $travelRoute['estimated_duration'],
                    'base_price' => $travelRoute['base_price'],
                    'status' => TravelRouteStatus::ACTIVE,
                ],
            );
        }
    }
}
