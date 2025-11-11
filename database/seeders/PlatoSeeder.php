<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plato;

class PlatoSeeder extends Seeder
{
    public function run(): void
    {
        $platos = [
            [
                'nombre' => 'Pollo a la Brasa',
                'descripcion' => 'Clásico peruano acompañado con papas doradas y ensalada.',
                'precio' => 25.00,
                'categoria' => 'Platos principales',
                'imagen' => 'pollo.jpg', // renombrada sin caracteres especiales
            ],
            [
                'nombre' => 'Ceviche Mixto',
                'descripcion' => 'Delicioso ceviche de pescado y mariscos con ají y limón fresco.',
                'precio' => 28.50,
                'categoria' => 'Mariscos',
                'imagen' => 'ceviche_mixto.png',
            ],
            [
                'nombre' => 'Lomo Saltado',
                'descripcion' => 'Trozos de carne salteados con cebolla, tomate y papas fritas.',
                'precio' => 27.00,
                'categoria' => 'Platos principales',
                'imagen' => 'lomo_saltado.jpg',
            ],
        ];

        foreach ($platos as $plato) {
            Plato::create($plato);
        }
    }
}
