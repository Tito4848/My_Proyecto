<?php

namespace Tests\Unit;

use App\Models\Pedido;
use App\Models\Plato;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_un_pedido(): void
    {
        $user = User::factory()->create();
        $pedido = Pedido::factory()->create(['user_id' => $user->id]);

        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function pedido_tiene_relacion_con_usuario(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);
        $pedido = Pedido::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $pedido->usuario->id);
    }

    /** @test */
    public function pedido_puede_tener_platos(): void
    {
        $pedido = Pedido::factory()->create();
        $plato1 = Plato::factory()->create();
        $plato2 = Plato::factory()->create();

        $pedido->platos()->attach($plato1->id, [
            'cantidad' => 2,
            'precio' => 25.50,
        ]);

        $pedido->platos()->attach($plato2->id, [
            'cantidad' => 1,
            'precio' => 15.00,
        ]);

        $this->assertCount(2, $pedido->platos);
    }

    /** @test */
    public function carrito_se_guarda_como_array(): void
    {
        $carrito = [
            ['id' => 1, 'nombre' => 'Ceviche', 'precio' => 25.50, 'cantidad' => 2],
            ['id' => 2, 'nombre' => 'Lomo Saltado', 'precio' => 30.00, 'cantidad' => 1],
        ];

        $pedido = Pedido::factory()->create(['carrito' => $carrito]);

        $this->assertIsArray($pedido->carrito);
        $this->assertEquals('Ceviche', $pedido->carrito[0]['nombre']);
    }

    /** @test */
    public function total_se_calcula_correctamente(): void
    {
        $carrito = [
            ['id' => 1, 'precio' => 25.50, 'cantidad' => 2],
            ['id' => 2, 'precio' => 30.00, 'cantidad' => 1],
        ];

        $totalEsperado = (25.50 * 2) + 30.00;

        $pedido = Pedido::factory()->create([
            'carrito' => $carrito,
            'total' => $totalEsperado,
        ]);

        $this->assertEquals($totalEsperado, $pedido->total);
    }
}

