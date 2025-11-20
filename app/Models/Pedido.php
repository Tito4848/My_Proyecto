<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'direccion',
        'telefono',
        'metodo_pago',
        'carrito',
        'productos',
        'total',
        'estado',
    ];

    // Si tu columna carrito es json, puedes usar:
    protected $casts = [
        'carrito' => 'array',
    ];
    public function usuario()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

}
