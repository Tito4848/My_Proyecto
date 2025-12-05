<?php

namespace Tests\Feature;

use App\Models\Mesa;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function usuario_autenticado_puede_ver_pagina_de_reserva(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);
        Mesa::factory()->count(3)->create(['estado' => 'libre']);

        $response = $this->actingAs($user)->get(route('reserva'));

        $response->assertStatus(200);
        $response->assertViewIs('reserva');
    }

    /** @test */
    public function puede_obtener_mesas_disponibles(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);
        $mesaLibre = Mesa::factory()->create(['estado' => 'libre', 'capacidad' => 4]);
        Mesa::factory()->create(['estado' => 'ocupada', 'capacidad' => 6]);

        $fecha = now()->addDay()->toDateString();
        $hora = '19:00';

        $response = $this->actingAs($user)->get(route('reserva.obtener-mesas', [
            'fecha' => $fecha,
            'hora' => $hora,
            'personas' => 4,
        ]));

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $mesaLibre->id]);
    }

    /** @test */
    public function usuario_autenticado_puede_crear_reserva(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);
        $mesa = Mesa::factory()->create(['estado' => 'libre', 'capacidad' => 4]);

        $fecha = now()->addDay()->toDateString();
        $hora = '19:00';

        $response = $this->actingAs($user)->post(route('reserva.store'), [
            'nombre' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'telefono' => '987654321',
            'personas' => 4,
            'fecha' => $fecha,
            'hora' => $hora,
            'mesa_id' => $mesa->id,
        ]);

        $response->assertRedirect(route('reserva'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('reservas', [
            'user_id' => $user->id,
            'mesa_id' => $mesa->id,
            'nombre' => 'Juan Pérez',
        ]);
    }

    /** @test */
    public function validacion_falla_si_faltan_datos(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);

        $response = $this->actingAs($user)->post(route('reserva.store'), [
            'nombre' => 'Juan Pérez',
        ]);

        $response->assertSessionHasErrors(['telefono', 'personas', 'fecha', 'hora']);
    }

    /** @test */
    public function no_puede_reservar_mesa_ocupada(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);
        $mesa = Mesa::factory()->create(['estado' => 'ocupada']);

        $response = $this->actingAs($user)->post(route('reserva.store'), [
            'nombre' => 'Juan Pérez',
            'telefono' => '987654321',
            'personas' => 4,
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '19:00',
            'mesa_id' => $mesa->id,
        ]);

        $response->assertSessionHasErrors(['mesa_id']);
    }

    /** @test */
    public function no_puede_reservar_mesa_con_capacidad_insuficiente(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);
        $mesa = Mesa::factory()->create(['estado' => 'libre', 'capacidad' => 2]);

        $response = $this->actingAs($user)->post(route('reserva.store'), [
            'nombre' => 'Juan Pérez',
            'telefono' => '987654321',
            'personas' => 5,
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '19:00',
            'mesa_id' => $mesa->id,
        ]);

        $response->assertSessionHasErrors(['mesa_id']);
    }

    /** @test */
    public function no_puede_reservar_mesa_ya_reservada_en_misma_fecha_hora(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);
        $mesa = Mesa::factory()->create(['estado' => 'libre', 'capacidad' => 4]);
        $fecha = now()->addDay()->toDateString();
        $hora = '19:00';

        Reserva::factory()->create([
            'mesa_id' => $mesa->id,
            'fecha' => $fecha,
            'hora' => $hora,
            'estado' => 'confirmada',
        ]);

        $response = $this->actingAs($user)->post(route('reserva.store'), [
            'nombre' => 'María García',
            'telefono' => '987654321',
            'personas' => 4,
            'fecha' => $fecha,
            'hora' => $hora,
            'mesa_id' => $mesa->id,
        ]);

        $response->assertSessionHasErrors(['mesa_id']);
    }

    /** @test */
    public function puede_reservar_sin_seleccionar_mesa(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);

        $response = $this->actingAs($user)->post(route('reserva.store'), [
            'nombre' => 'Juan Pérez',
            'telefono' => '987654321',
            'personas' => 4,
            'fecha' => now()->addDay()->toDateString(),
            'hora' => '19:00',
        ]);

        $response->assertRedirect(route('reserva'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('reservas', [
            'user_id' => $user->id,
            'nombre' => 'Juan Pérez',
            'mesa_id' => null,
        ]);
    }

    /** @test */
    public function fecha_debe_ser_futura(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
            'is_employee' => false,
        ]);

        $response = $this->actingAs($user)->post(route('reserva.store'), [
            'nombre' => 'Juan Pérez',
            'telefono' => '987654321',
            'personas' => 4,
            'fecha' => now()->subDay()->toDateString(),
            'hora' => '19:00',
        ]);

        $response->assertSessionHasErrors(['fecha']);
    }
}

