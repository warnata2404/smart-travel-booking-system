<?php

use App\Enums\CityStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100)->unique();

            $table->text('description')->nullable();

            $table->string('status', 20)
                ->default(CityStatus::ACTIVE->value)
                ->index();

            $table->timestamps();

            $table->softDeletes()->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
