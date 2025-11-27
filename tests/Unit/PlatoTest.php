<?php

namespace Tests\Unit;

use App\Models\Plato;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_un_plato(): void
    {
        $plato = Plato::factory()->create([
            'nombre' => 'Ceviche',
            'precio' => 25.50,
            'categoria' => 'Plato Principal',
        ]);

        $this->assertDatabaseHas('platos', [
            'nombre' => 'Ceviche',
            'precio' => 25.50,
            'categoria' => 'Plato Principal',
        ]);
    }

    /** @test */
    public function plato_tiene_todos_los_campos_requeridos(): void
    {
        $plato = Plato::factory()->create();

        $this->assertNotNull($plato->nombre);
        $this->assertNotNull($plato->descripcion);
        $this->assertNotNull($plato->precio);
        $this->assertNotNull($plato->categoria);
    }

    /** @test */
    public function precio_es_un_numero_positivo(): void
    {
        $plato = Plato::factory()->create([
            'precio' => 15.99,
        ]);

        $this->assertGreaterThan(0, $plato->precio);
        $this->assertIsFloat($plato->precio);
    }
}

