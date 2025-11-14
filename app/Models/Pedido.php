<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'metodo_pago',
        'carrito',
    ];

    // Si tu columna carrito es json, puedes usar:
    protected $casts = [
        'carrito' => 'array',
    ];
}
