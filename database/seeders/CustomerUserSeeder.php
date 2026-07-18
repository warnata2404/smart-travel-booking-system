<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            [
                'email' => 'costumer@gmail.com',
            ],
            [
                'name' => 'Costumer',

                'password' => Hash::make('12345678'),

                'role' => UserRole::CUSTOMER,

                'status' => UserStatus::ACTIVE,
            ]
        );
    }
}
