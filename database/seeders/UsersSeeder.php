<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
            ['username' => 'editor'],
            [
                'role' => 'editor',
                'password' => '$2y$12$MU7MKyguKy07OUR0.Y3UZ.TF3jNIlukKge6hZ8pNymyyHAMAUds9e',
            ],
        );
    }
}
