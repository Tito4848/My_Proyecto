<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], 
            [
                'name' => 'is_admin',
                'password' => Hash::make('admin123'),
                'is_admin' => true, // Asegúrate de que este campo existe en la tabla users
            ]
        );
    }
}
