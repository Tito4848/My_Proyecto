<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plato;

class PlatoSeeder extends Seeder
{
    public function run(): void
    {
        $platos = [
              
            //Entradas
            [
                'nombre' => 'Humitas',
                'descripcion' => 'Preparación de pasta de maíz dulce, envuelta en hojas de maíz y cocida al vapor.',
                'precio' => 15.00,
                'categoria' => 'Entradas',
                'imagen' => 'humitas.jpg',
            ],
                [
                'nombre' => 'Ceviche Mixto',
                'descripcion' => 'Delicioso ceviche de pescado y mariscos con ají y limón fresco.',
                'precio' => 28.50,
                'categoria' => 'Entradas',
                'imagen' => 'ceviche_mixto.png',
                
            ],
                [
                'nombre' => 'Anticuchos',
                'descripcion' => 'Brochetas de corazón de res marinadas en ají panca y especias, asadas a la parrilla.',
                'precio' => 20.00,
                'categoria' => 'Entradas',
                'imagen' => 'anticuchos.jpg',
            ],
                [
                'nombre' => 'Papa a la Huancaína',
                'descripcion' => 'Papas sancochadas cubiertas con una cremosa salsa de queso, ají amarillo y leche.',
                'precio' => 16.00,
                'categoria' => 'Entradas',
                'imagen' => 'papahuancaina.jpg',
            ],
            //Platos principales
            [
                'nombre' => 'Pollo a la Brasa',
                'descripcion' => 'Clásico peruano acompañado con papas doradas y ensalada.',
                'precio' => 25.00,
                'categoria' => 'Platos principales',
                'imagen' => 'pollo.jpg', // renombrada sin caracteres especiales
            ],
            [
                'nombre' => 'Lomo Saltado',
                'descripcion' => 'Trozos de carne salteados con cebolla, tomate y papas fritas.',
                'precio' => 27.00,
                'categoria' => 'Platos principales',
                'imagen' => 'lomo_saltado.jpg',
            ],
               [
                'nombre' => 'Patasca',
                'descripcion' => 'Tradicional sopa espesa hecha con maíz mote, carne de res, hierbas andinas y especias.',
                'precio' => 20.00,
                'categoria' => 'Platos principales',
                'imagen' => 'patasca.jpg',
            ],
                [
                'nombre' => 'Ají de Gallina',
                'descripcion' => 'Delicioso guiso de pollo deshilachado con salsa cremosa de ají amarillo y nueces, acompañado de arroz.',
                'precio' => 22.00,
                'categoria' => 'Platos principales',
                'imagen' => 'ajigallina.png',
            ],
                [
                'nombre' => 'Caldo Blanco',
                'descripcion' => 'Sopa ligera a base de pollo, huevo y fideos, típica del desayuno o almuerzo en Arequipa.',
                'precio' => 18.00,
                'categoria' => 'Plato Principal',
                'imagen' => 'caldoblanco.jpg',
            ],
            //Postres
                [
                'nombre' => 'Alfajores',
                'descripcion' => 'Galletas rellenas de manjar blanco, muy tradicionales en todo el Perú.',
                'precio' => 8.00,
                'categoria' => 'Postres',
                'imagen' => 'alfajores.jpg',
            ],
                [
                'nombre' => 'Mazamorra Morada',
                'descripcion' => 'Postre hecho con maíz morado, frutas secas y especias, servido frío.',
                'precio' => 10.00,
                'categoria' => 'Postres',
                'imagen' => 'mazamorra.jpg',
            ],
                [
                'nombre' => 'Suspiro a la Limeña',
                'descripcion' => 'Dulce de leche con merengue, típico de Lima, muy cremoso y dulce.',
                'precio' => 12.00,
                'categoria' => 'Postres',
                'imagen' => 'suspiro.png',
            ],
            //Bebidas
                [
                'nombre' => 'Ocopa Peruana',
                'descripcion' => 'Papas sancochadas acompañadas con salsa cremosa de huacatay, maní, queso y ají amarillo.',
                'precio' => 16.00,
                'categoria' => 'Bebida',
                'imagen' => 'ocopa.png',
            ],
                [
                'nombre' => 'Café Arequipeño',
                'descripcion' => 'Aromático café tostado de la región arequipeña, ideal para acompañar postres o desayunos.',
                'precio' => 10.00,
                'categoria' => 'Bebidas',
                'imagen' => 'cafe.jpg',
            ],
                [
                'nombre' => 'Emoliente',
                'descripcion' => 'Bebida caliente tradicional peruana a base de hierbas medicinales, linaza, cebada, cola de caballo y especias. Ideal para fortalecer y reconfortar el cuerpo.',
                'precio' => 10.00,
                'categoria' => 'Bebidas',
                'imagen' => 'emoliente.jpg',
            ],
        ];

        foreach ($platos as $plato) {
    Plato::firstOrCreate(
        ['nombre' => $plato['nombre']], // evita duplicados
        $plato
    );
}
}
}
