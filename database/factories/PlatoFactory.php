<?php

namespace Database\Factories;

use App\Models\Plato;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\EloquentFactories\Factory<\App\Models\Plato>
 */
class PlatoFactory extends Factory
{
    protected $model = Plato::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = ['Entrada', 'Plato Principal', 'Postre', 'Bebida', 'Especialidad'];

        return [
            'nombre' => $this->faker->words(2, true),
            'descripcion' => $this->faker->sentence(10),
            'precio' => $this->faker->randomFloat(2, 10, 100),
            'categoria' => $this->faker->randomElement($categorias),
            'imagen' => $this->faker->imageUrl(640, 480, 'food'),
        ];
    }
}

