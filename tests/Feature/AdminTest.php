<?php

namespace Tests\Feature;

use App\Models\Pedido;
use App\Models\Plato;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // ensure admin middleware uses is_admin column
        if (!User::first()) {
            User::factory()->create();
        }
    }

    /** @test */
    public function usuario_no_admin_no_puede_acceder_al_panel(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    /** @test */
    public function admin_puede_acceder_al_panel(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_puede_ver_lista_de_pedidos(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Pedido::factory()->count(3)->create();

        $response = $this->actingAs($admin)->get(route('admin.pedidos.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_puede_ver_lista_de_platos(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Plato::factory()->count(5)->create();

        $response = $this->actingAs($admin)->get(route('admin.platos.index'));

        $response->assertStatus(200);
    }
}

