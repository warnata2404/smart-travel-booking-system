<?php

use App\Enums\BookingStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('booking_number', 50)->unique();

            $table->foreignId('customer_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('origin_city_id')
                ->constrained('cities')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('destination_id')
                ->constrained('destinations')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal('price', 15, 2);

            $table->decimal('distance', 10, 2);

            $table->unsignedInteger('estimated_duration');

            $table->date('departure_date')->index();

            $table->time('departure_time');

            $table->string('status', 20)
                ->default(BookingStatus::PENDING_PAYMENT->value)
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
