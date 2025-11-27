<?php

namespace Database\Factories;

use App\Models\Mesa;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\EloquentFactories.Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    protected $model = Reserva::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estados = ['pendiente', 'confirmada', 'cancelada', 'completada'];
        $horas = ['12:00', '13:00', '14:00', '19:00', '20:00', '21:00', '22:00'];

        return [
            'user_id' => User::factory(),
            'mesa_id' => Mesa::factory(),
            'nombre' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'personas' => $this->faker->numberBetween(1, 10),
            'fecha' => $this->faker->dateTimeBetween('now', '+30 days'),
            'hora' => $this->faker->randomElement($horas),
            'estado' => $this->faker->randomElement($estados),
            'notas' => $this->faker->optional()->sentence(),
        ];
    }

    public function pendiente(): static
    {
        return $this->state(fn () => [
            'estado' => 'pendiente',
        ]);
    }

    public function confirmada(): static
    {
        return $this->state(fn () => [
            'estado' => 'confirmada',
        ]);
    }
}

