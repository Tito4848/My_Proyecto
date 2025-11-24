<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Crear usuario admin
        $this->call(AdminUserSeeder::class);

        // Crear platos
        $this->call(PlatoSeeder::class);
        
        // Crear mesas
        $this->call(MesaSeeder::class);
    }
}
