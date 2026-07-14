<?php

use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->string('payment_number', 50)
                ->unique();

            $table->foreignId('booking_id')
                ->unique()
                ->constrained('bookings')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('voucher_id')
                ->nullable()
                ->constrained('vouchers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal('subtotal', 15, 2);

            $table->decimal('discount', 15, 2)
                ->default(0.00);

            $table->decimal('grand_total', 15, 2);

            $table->string('payment_proof', 255);

            $table->string('status', 20)
                ->default(PaymentStatus::PENDING->value)
                ->index();

            $table->timestamp('paid_at')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
