<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mesa_id',
        'nombre',
        'email',
        'telefono',
        'personas',
        'fecha',
        'hora',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha' => 'date',
        'personas' => 'integer',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
}

