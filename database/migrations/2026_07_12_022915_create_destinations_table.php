<?php

use App\Enums\DestinationCategory;
use App\Enums\DestinationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('city_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name', 100);

            $table->string('category', 20)->index();

            $table->decimal('price', 15, 2);

            $table->decimal('distance', 10, 2);

            $table->unsignedInteger('estimated_duration');

            $table->text('description')->nullable();

            $table->string('status', 20)
                ->default(DestinationStatus::ACTIVE->value)
                ->index();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
