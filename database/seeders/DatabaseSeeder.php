<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

            /*
            |--------------------------------------------------------------------------
            | Users
            |--------------------------------------------------------------------------
            */

            AdminUserSeeder::class,

            CustomerUserSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Master Data
            |--------------------------------------------------------------------------
            */

            CitySeeder::class,

            DestinationSeeder::class,

            TravelRouteSeeder::class,

            /*
            |--------------------------------------------------------------------------
            | Configuration
            |--------------------------------------------------------------------------
            */

            RewardConfigurationSeeder::class,

            WeatherConfigurationSeeder::class,

        ]);
    }
}
