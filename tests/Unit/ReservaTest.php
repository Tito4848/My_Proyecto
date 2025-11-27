<?php

namespace Tests\Unit;

use App\Models\Mesa;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_crear_una_reserva(): void
    {
        $user = User::factory()->create();
        $mesa = Mesa::factory()->create();

        $reserva = Reserva::factory()->create([
            'user_id' => $user->id,
            'mesa_id' => $mesa->id,
        ]);

        $this->assertDatabaseHas('reservas', [
            'id' => $reserva->id,
            'user_id' => $user->id,
            'mesa_id' => $mesa->id,
        ]);
    }

    /** @test */
    public function reserva_tiene_relacion_con_usuario(): void
    {
        $user = User::factory()->create();
        $reserva = Reserva::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $reserva->usuario->id);
    }

    /** @test */
    public function reserva_tiene_relacion_con_mesa(): void
    {
        $mesa = Mesa::factory()->create();
        $reserva = Reserva::factory()->create(['mesa_id' => $mesa->id]);

        $this->assertEquals($mesa->id, $reserva->mesa->id);
    }

    /** @test */
    public function fecha_se_cast_a_date(): void
    {
        $reserva = Reserva::factory()->create([
            'fecha' => '2024-12-25',
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $reserva->fecha);
    }

    /** @test */
    public function personas_se_cast_a_integer(): void
    {
        $reserva = Reserva::factory()->create([
            'personas' => 4,
        ]);

        $this->assertIsInt($reserva->personas);
        $this->assertEquals(4, $reserva->personas);
    }
}

