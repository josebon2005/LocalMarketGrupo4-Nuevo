<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@localmarket.test'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'role' => Role::Admin,
            ]
        );

        User::updateOrCreate(
            ['email' => 'comerciante@localmarket.test'],
            [
                'name' => 'Comerciante',
                'password' => 'password',
                'role' => Role::Comerciante,
            ]
        );

        User::updateOrCreate(
            ['email' => 'comprador@localmarket.test'],
            [
                'name' => 'Comprador',
                'password' => 'password',
                'role' => Role::Comprador,
            ]
        );

        User::updateOrCreate(
            ['email' => 'repartidor@localmarket.test'],
            [
                'name' => 'Repartidor',
                'password' => 'password',
                'role' => Role::Repartidor,
            ]
        );
    }
}
