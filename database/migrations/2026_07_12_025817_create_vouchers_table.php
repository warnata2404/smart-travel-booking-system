<?php

use App\Enums\VoucherStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reward_id')
                ->unique()
                ->constrained('rewards')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('code', 50)
                ->unique();

            $table->decimal('discount_percentage', 5, 2);

            $table->timestamp('expired_at')
                ->index();

            $table->string('status', 20)
                ->default(VoucherStatus::ACTIVE->value)
                ->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
