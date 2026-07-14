<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\WeatherConfigurationStatus;
use App\Models\WeatherConfiguration;
use Illuminate\Database\Seeder;

class WeatherConfigurationSeeder extends Seeder
{
    /**
     * Seed weather configurations.
     */
    public function run(): void
    {
        $weatherConfigurations = [

            [
                'rule_type' => 'SUNNY',
                'weather' => 'Cerah',
                'recommendation' => 'Perjalanan sangat direkomendasikan karena cuaca cerah.',
            ],

            [
                'rule_type' => 'CLOUDY',
                'weather' => 'Mendung',
                'recommendation' => 'Perjalanan tetap dapat dilakukan, namun disarankan mempersiapkan perlengkapan jika cuaca berubah.',
            ],

            [
                'rule_type' => 'RAIN',
                'weather' => 'Hujan',
                'recommendation' => 'Perjalanan dapat dilakukan dengan hati-hati. Disarankan membawa payung atau jas hujan.',
            ],

        ];

        foreach ($weatherConfigurations as $weatherConfiguration) {

            WeatherConfiguration::query()->updateOrCreate(
                [
                    'rule_type' => $weatherConfiguration['rule_type'],
                ],
                [
                    'weather' => $weatherConfiguration['weather'],
                    'recommendation' => $weatherConfiguration['recommendation'],
                    'status' => WeatherConfigurationStatus::ACTIVE,
                ],
            );
        }
    }
}
