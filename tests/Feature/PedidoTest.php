<?php

namespace Tests\Feature;

use App\Models\Pedido;
use App\Models\Plato;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_autenticado_puede_ver_pantalla_de_pago(): void
    {
        $user = User::factory()->create();
        $plato = Plato::factory()->create(['precio' => 25.50]);

        session(['carrito' => [
            [
                'id' => $plato->id,
                'nombre' => $plato->nombre,
                'precio' => $plato->precio,
                'cantidad' => 2,
            ],
        ]]);

        $response = $this->actingAs($user)->get(route('pago'));

        $response->assertStatus(200);
        $response->assertViewIs('pago');
    }

    /** @test */
    public function redirige_al_carrito_si_esta_vacio(): void
    {
        $user = User::factory()->create();

        session()->forget('carrito');

        $response = $this->actingAs($user)->get(route('pago'));

        $response->assertRedirect(route('carrito'));
        $response->assertSessionHas('error', 'Tu carrito está vacío');
    }

    /** @test */
    public function usuario_puede_procesar_pago_con_tarjeta(): void
    {
        $user = User::factory()->create();
        $plato = Plato::factory()->create(['precio' => 25.50]);

        session(['carrito' => [
            [
                'id' => $plato->id,
                'nombre' => $plato->nombre,
                'precio' => $plato->precio,
                'cantidad' => 2,
            ],
        ]]);

        $response = $this->actingAs($user)->post(route('pago.procesar'), [
            'nombre' => 'Juan Pérez',
            'metodo_pago' => 'Tarjeta',
            'numero' => '4532015112830366',
            'vencimiento' => '12/30',
            'cvv' => '123',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pedidos', [
            'user_id' => $user->id,
            'nombre' => 'Juan Pérez',
            'metodo_pago' => 'Tarjeta',
        ]);
    }

    /** @test */
    public function usuario_puede_procesar_pago_con_yape(): void
    {
        $user = User::factory()->create();
        $plato = Plato::factory()->create(['precio' => 30.00]);

        session(['carrito' => [
            [
                'id' => $plato->id,
                'nombre' => $plato->nombre,
                'precio' => $plato->precio,
                'cantidad' => 1,
            ],
        ]]);

        $response = $this->actingAs($user)->post(route('pago.procesar'), [
            'nombre' => 'María García',
            'metodo_pago' => 'Yape',
            'yape_numero' => '987654321',
            'yape_codigo' => '123456',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pedidos', [
            'user_id' => $user->id,
            'nombre' => 'María García',
            'metodo_pago' => 'Yape',
        ]);
    }

    /** @test */
    public function validacion_falla_si_faltan_datos(): void
    {
        $user = User::factory()->create();

        session(['carrito' => [
            ['id' => 1, 'nombre' => 'Test', 'precio' => 10, 'cantidad' => 1],
        ]]);

        $response = $this->actingAs($user)->post(route('pago.procesar'), [
            'metodo_pago' => 'Tarjeta',
        ]);

        $response->assertSessionHasErrors(['nombre']);
    }

    /** @test */
    public function puede_obtener_estado_de_pedido(): void
    {
        $user = User::factory()->create();
        $pedido = Pedido::factory()->create([
            'user_id' => $user->id,
            'estado_seguimiento' => 'preparando',
        ]);

        $response = $this->get(route('pedidos.estado', $pedido->id));

        $response->assertStatus(200);
        $response->assertJson([
            'estado_seguimiento' => 'preparando',
        ]);
    }

    /** @test */
    public function puede_ver_seguimiento_por_codigo(): void
    {
        $pedido = Pedido::factory()->create([
            'codigo_seguimiento' => 'SAL12345678',
        ]);

        $response = $this->get(route('seguimiento', 'SAL12345678'));

        $response->assertStatus(200);
        $response->assertViewIs('seguimiento');
        $response->assertViewHas('pedido');
    }

    /** @test */
    public function retorna_error_si_pedido_no_existe(): void
    {
        $response = $this->get(route('seguimiento', 'CODIGO_INEXISTENTE'));

        $response->assertStatus(200);
        $response->assertViewIs('seguimiento');
        $error = $response->viewData('error');
        $pedido = $response->viewData('pedido');
        $this->assertTrue($error !== null || $pedido === null);
    }
}

