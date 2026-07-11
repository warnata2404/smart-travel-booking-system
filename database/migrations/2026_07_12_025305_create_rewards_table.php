<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('trip_id')
                ->unique()
                ->constrained('trips')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('reward_configuration_id')
                ->constrained('reward_configurations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal('total_distance', 10, 2);

            $table->timestamp('generated_at');

            $table->timestamps();

            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rewards');
    }
};
