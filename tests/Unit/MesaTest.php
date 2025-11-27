<?php

namespace Tests\Unit;

use App\Models\Mesa;
use App\Models\Reserva;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MesaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_una_mesa(): void
    {
        Mesa::factory()->create([
            'numero' => '5',
            'capacidad' => 4,
            'estado' => 'libre',
        ]);

        $this->assertDatabaseHas('mesas', [
            'numero' => '5',
            'capacidad' => 4,
            'estado' => 'libre',
        ]);
    }

    /** @test */
    public function mesa_tiene_relacion_con_reservas(): void
    {
        $mesa = Mesa::factory()->create();
        $reserva = Reserva::factory()->create(['mesa_id' => $mesa->id]);

        $this->assertTrue($mesa->reservas->contains($reserva));
    }

    /** @test */
    public function mesa_esta_disponible_cuando_no_hay_reservas(): void
    {
        $mesa = Mesa::factory()->create(['estado' => 'libre']);
        $fecha = now()->addDay()->toDateString();
        $hora = '19:00';

        $this->assertTrue($mesa->estaDisponible($fecha, $hora));
    }

    /** @test */
    public function mesa_no_esta_disponible_cuando_esta_ocupada(): void
    {
        $mesa = Mesa::factory()->create(['estado' => 'ocupada']);
        $fecha = now()->addDay()->toDateString();
        $hora = '19:00';

        $this->assertFalse($mesa->estaDisponible($fecha, $hora));
    }

    /** @test */
    public function mesa_no_esta_disponible_cuando_tiene_reserva_activa(): void
    {
        $mesa = Mesa::factory()->create(['estado' => 'libre']);
        $fecha = now()->addDay()->toDateString();
        $hora = '19:00';

        Reserva::factory()->create([
            'mesa_id' => $mesa->id,
            'fecha' => $fecha,
            'hora' => $hora,
            'estado' => 'confirmada',
        ]);

        $this->assertFalse($mesa->estaDisponible($fecha, $hora));
    }

    /** @test */
    public function reservas_activas_excluye_canceladas_y_completadas(): void
    {
        $mesa = Mesa::factory()->create();

        Reserva::factory()->create([
            'mesa_id' => $mesa->id,
            'fecha' => now()->addDay(),
            'estado' => 'cancelada',
        ]);

        Reserva::factory()->create([
            'mesa_id' => $mesa->id,
            'fecha' => now()->addDay(),
            'estado' => 'completada',
        ]);

        Reserva::factory()->create([
            'mesa_id' => $mesa->id,
            'fecha' => now()->addDay(),
            'estado' => 'confirmada',
        ]);

        $this->assertEquals(1, $mesa->reservasActivas()->count());
    }
}

