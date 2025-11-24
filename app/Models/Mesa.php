<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'capacidad',
        'estado',
        'ubicacion',
        'descripcion',
    ];

    protected $casts = [
        'capacidad' => 'integer',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function reservasActivas()
    {
        return $this->reservas()
            ->where('estado', '!=', 'cancelada')
            ->where('estado', '!=', 'completada')
            ->where('fecha', '>=', now()->toDateString());
    }

    public function estaDisponible($fecha, $hora)
    {
        // Verificar si la mesa está ocupada físicamente
        if ($this->estado === 'ocupada') {
            return false;
        }

        // Verificar si hay reservas activas para esa fecha y hora
        $reservaActiva = $this->reservas()
            ->where('estado', '!=', 'cancelada')
            ->where('estado', '!=', 'completada')
            ->whereDate('fecha', $fecha)
            ->where('hora', $hora)
            ->first();

        return $reservaActiva === null;
    }
}

