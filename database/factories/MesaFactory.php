<?php

namespace Database\Factories;

use App\Models\Mesa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\EloquentFactories\Factory<\App\Models\Mesa>
 */
class MesaFactory extends Factory
{
    protected $model = Mesa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ubicaciones = ['interior', 'exterior', 'ventana', 'bar'];
        $estados = ['libre', 'ocupada', 'reservada'];

        return [
            'numero' => (string) $this->faker->unique()->numberBetween(1, 50),
            'capacidad' => $this->faker->numberBetween(2, 10),
            'estado' => $this->faker->randomElement($estados),
            'ubicacion' => $this->faker->randomElement($ubicaciones),
            'descripcion' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the mesa is available.
     */
    public function disponible(): static
    {
        return $this->state(fn () => [
            'estado' => 'libre',
        ]);
    }

    /**
     * Indicate that the mesa is reserved.
     */
    public function reservada(): static
    {
        return $this->state(fn () => [
            'estado' => 'reservada',
        ]);
    }
}

