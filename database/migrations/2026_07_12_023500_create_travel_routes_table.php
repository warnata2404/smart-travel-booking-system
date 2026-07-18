<?php

use App\Enums\TravelRouteStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travel_routes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('origin_city_id')
                ->constrained('cities')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('destination_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal(
                'distance',
                10,
                2,
            );

            $table->unsignedInteger(
                'estimated_duration',
            );

            $table->decimal(
                'base_price',
                15,
                2,
            );

            $table->string(
                'status',
                20,
            )
                ->default(
                    TravelRouteStatus::ACTIVE->value,
                )
                ->index();

            $table->unique([
                'origin_city_id',
                'destination_id',
            ]);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_routes');
    }
};
