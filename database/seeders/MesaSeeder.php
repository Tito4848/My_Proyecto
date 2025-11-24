<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mesa;

class MesaSeeder extends Seeder
{
    public function run(): void
    {
        $mesas = [
            ['numero' => 'M1', 'capacidad' => 2, 'ubicacion' => 'interior', 'descripcion' => 'Mesa para 2 personas'],
            ['numero' => 'M2', 'capacidad' => 2, 'ubicacion' => 'interior', 'descripcion' => 'Mesa para 2 personas'],
            ['numero' => 'M3', 'capacidad' => 4, 'ubicacion' => 'interior', 'descripcion' => 'Mesa para 4 personas'],
            ['numero' => 'M4', 'capacidad' => 4, 'ubicacion' => 'interior', 'descripcion' => 'Mesa para 4 personas'],
            ['numero' => 'M5', 'capacidad' => 4, 'ubicacion' => 'ventana', 'descripcion' => 'Mesa junto a la ventana'],
            ['numero' => 'M6', 'capacidad' => 6, 'ubicacion' => 'interior', 'descripcion' => 'Mesa para 6 personas'],
            ['numero' => 'M7', 'capacidad' => 6, 'ubicacion' => 'interior', 'descripcion' => 'Mesa para 6 personas'],
            ['numero' => 'M8', 'capacidad' => 8, 'ubicacion' => 'exterior', 'descripcion' => 'Mesa para 8 personas'],
            ['numero' => 'M9', 'capacidad' => 2, 'ubicacion' => 'exterior', 'descripcion' => 'Mesa para 2 personas'],
            ['numero' => 'M10', 'capacidad' => 4, 'ubicacion' => 'exterior', 'descripcion' => 'Mesa para 4 personas'],
            ['numero' => 'M11', 'capacidad' => 10, 'ubicacion' => 'interior', 'descripcion' => 'Mesa grande para grupos'],
            ['numero' => 'M12', 'capacidad' => 2, 'ubicacion' => 'ventana', 'descripcion' => 'Mesa romántica junto a la ventana'],
        ];

        foreach ($mesas as $mesa) {
            Mesa::create($mesa);
        }
    }
}

