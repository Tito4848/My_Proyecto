<?php

namespace Tests\Feature;

use App\Models\Plato;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarritoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_autenticado_puede_ver_carrito(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);

        $response = $this->actingAs($user)->get(route('carrito'));

        $response->assertStatus(200);
        $response->assertViewIs('carrito');
    }

    /** @test */
    public function usuario_no_autenticado_no_puede_ver_carrito(): void
    {
        $response = $this->get(route('carrito'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function usuario_puede_agregar_plato_al_carrito(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);

        $plato = Plato::factory()->create([
            'nombre' => 'Ceviche',
            'precio' => 25.50,
        ]);

        $response = $this->actingAs($user)->post(route('carrito.agregar'), [
            'id' => $plato->id,
            'cantidad' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $carrito = session('carrito');
        $this->assertNotNull($carrito);
        $this->assertArrayHasKey($plato->id, $carrito);
        $this->assertEquals(2, $carrito[$plato->id]['cantidad']);
    }

    /** @test */
    public function usuario_puede_eliminar_item_del_carrito(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);

        $plato = Plato::factory()->create();

        session(['carrito' => [
            $plato->id => [
                'id' => $plato->id,
                'nombre' => $plato->nombre,
                'precio' => $plato->precio,
                'cantidad' => 1,
            ],
        ]]);

        $response = $this->actingAs($user)->delete(route('carrito.eliminar', $plato->id));

        $response->assertRedirect();
        $this->assertEmpty(session('carrito'));
    }

    /** @test */
    public function usuario_puede_vaciar_carrito(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);

        $plato1 = Plato::factory()->create();
        $plato2 = Plato::factory()->create();

        session(['carrito' => [
            $plato1->id => ['id' => $plato1->id, 'nombre' => 'Plato 1', 'precio' => 10, 'cantidad' => 1],
            $plato2->id => ['id' => $plato2->id, 'nombre' => 'Plato 2', 'precio' => 20, 'cantidad' => 1],
        ]]);

        $response = $this->actingAs($user)->delete(route('vaciar'));

        $response->assertRedirect();
        $this->assertNull(session('carrito'));
    }
}

