<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'user_id',
        'nombre',
        'direccion',
        'telefono',
        'metodo_pago',
        'estado',
        'total',
    ];

    public function platos()
    {
        return $this->belongsToMany(Plato::class, 'pedido_plato')
                    ->withPivot('cantidad', 'precio')
                    ->withTimestamps();
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

