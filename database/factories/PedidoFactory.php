<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\EloquentFactories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estados = ['pendiente', 'en_proceso', 'listo', 'en_camino', 'entregado', 'cancelado'];
        $metodosPago = ['Tarjeta', 'Yape', 'Efectivo'];
        $estadosSeguimiento = ['recibido', 'preparando', 'listo', 'en_camino', 'entregado'];

        $carrito = [
            [
                'id' => 1,
                'nombre' => $this->faker->words(2, true),
                'precio' => $this->faker->randomFloat(2, 10, 50),
                'cantidad' => $this->faker->numberBetween(1, 5),
            ],
            [
                'id' => 2,
                'nombre' => $this->faker->words(2, true),
                'precio' => $this->faker->randomFloat(2, 10, 50),
                'cantidad' => $this->faker->numberBetween(1, 3),
            ],
        ];

        $total = array_sum(array_map(fn ($item) => $item['precio'] * $item['cantidad'], $carrito));

        return [
            'user_id' => User::factory(),
            'nombre' => $this->faker->name(),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'metodo_pago' => $this->faker->randomElement($metodosPago),
            'carrito' => $carrito,
            'total' => $total,
            'estado' => $this->faker->randomElement($estados),
            'estado_seguimiento' => $this->faker->randomElement($estadosSeguimiento),
            'fecha_recibido' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'codigo_seguimiento' => 'SAL' . strtoupper($this->faker->unique()->bothify('########')),
            'latitud' => $this->faker->latitude(-16.5, -16.3),
            'longitud' => $this->faker->longitude(-71.6, -71.4),
            'direccion_entrega' => $this->faker->address(),
            'ultima_actualizacion_ubicacion' => $this->faker->dateTimeBetween('-1 hour', 'now'),
        ];
    }

    public function pendiente(): static
    {
        return $this->state(fn () => [
            'estado' => 'pendiente',
            'estado_seguimiento' => 'recibido',
        ]);
    }

    public function entregado(): static
    {
        return $this->state(fn () => [
            'estado' => 'entregado',
            'estado_seguimiento' => 'entregado',
            'fecha_entregado' => now(),
        ]);
    }
}

