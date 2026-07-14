<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\CityStatus;
use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Seed cities.
     */
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Jakarta',
                'description' => 'Special Capital Region of Jakarta.',
            ],
            [
                'name' => 'Bandung',
                'description' => 'Capital City of West Java.',
            ],
            [
                'name' => 'Yogyakarta',
                'description' => 'Special Region of Yogyakarta.',
            ],
            [
                'name' => 'Surabaya',
                'description' => 'Capital City of East Java.',
            ],
            [
                'name' => 'Denpasar',
                'description' => 'Capital City of Bali.',
            ],
        ];

        foreach ($cities as $city) {

            City::query()->updateOrCreate(
                [
                    'name' => $city['name'],
                ],
                [
                    'description' => $city['description'],
                    'status' => CityStatus::ACTIVE,
                ],
            );
        }
    }
}
