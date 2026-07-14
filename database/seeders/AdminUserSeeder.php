<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            [
                'email' => 'warnata@gmail.com',
            ],
            [
                'name' => 'Administrator',

                'password' => Hash::make('warnata2404'),

                'role' => UserRole::ADMIN,

                'status' => UserStatus::ACTIVE,
            ]
        );
    }
}
