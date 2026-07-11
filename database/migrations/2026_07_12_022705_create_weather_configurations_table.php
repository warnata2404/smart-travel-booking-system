<?php

use App\Enums\WeatherConfigurationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_configurations', function (Blueprint $table) {
            $table->id();

            $table->string('rule_type', 100)->unique();

            $table->string('weather', 100);

            $table->text('recommendation');

            $table->string('status', 20)
                ->default(WeatherConfigurationStatus::ACTIVE->value);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_configurations');
    }
};
