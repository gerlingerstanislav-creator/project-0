<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'role' => 'admin',
                'password' => '$2y$12$7kY8QSDBJkWH8vHe.SIbPuRl/FT0qkBVdcANwPxy9M8Kgrk9JHz46',
            ],
        );

        User::updateOrCreate(
            ['username' => 'moderator'],
            [
                'role' => 'moderator',
                'password' => '$2y$12$MU7MKyguKy07OUR0.Y3UZ.TF3jNIlukKge6hZ8pNymyyHAMAUds9e',
            ],
        );

        User::updateOrCreate(
            ['username' => 'user'],
            [
                'role' => 'user',
                'password' => Hash::make('12345678'),
            ],
        );

        User::where('username', 'editor')->update(['username' => 'moderator', 'role' => 'moderator']);
    }
}
