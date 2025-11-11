<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'nombre', 'direccion', 'telefono', 'metodo_pago', 'carrito',
    ];

    protected $casts = [
        'carrito' => 'array', 
    ];
}
