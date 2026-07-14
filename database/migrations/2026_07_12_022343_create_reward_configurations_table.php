<?php

use App\Enums\RewardConfigurationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reward_configurations', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('minimum_distance')
                ->unique();

            $table->string('reward_name', 100)
                ->unique();

            $table->decimal('discount_percentage', 5, 2);

            $table->string('status', 20)
                ->default(RewardConfigurationStatus::ACTIVE->value)
                ->index();

            $table->timestamps();

            $table->softDeletes();
        });

        DB::statement(<<<'SQL'
            ALTER TABLE reward_configurations
            ADD CONSTRAINT chk_reward_configurations_discount_percentage
            CHECK (
                discount_percentage >= 0
                AND discount_percentage <= 100
            )
        SQL);
    }

    public function down(): void
    {
        Schema::dropIfExists('reward_configurations');
    }
};
