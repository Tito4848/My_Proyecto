<?php

namespace Tests\Feature;

use App\Models\Plato;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_puede_ver_menu(): void
    {
        Plato::factory()->count(5)->create();

        $response = $this->get(route('menu'));

        $response->assertStatus(200);
        $response->assertViewIs('menu');
    }

    /** @test */
    public function usuario_puede_ver_detalle_de_plato(): void
    {
        $plato = Plato::factory()->create([
            'nombre' => 'Ceviche',
            'descripcion' => 'Plato tradicional peruano',
            'precio' => 25.50,
        ]);

        $response = $this->get(route('menu.show', $plato));

        $response->assertStatus(200);
        $response->assertViewIs('menu.show');
        $response->assertViewHas('plato', fn ($viewPlato) => $viewPlato->id === $plato->id);
    }

    /** @test */
    public function retorna_404_si_plato_no_existe(): void
    {
        $response = $this->get(route('menu.show', 999999));

        $response->assertStatus(404);
    }
}

