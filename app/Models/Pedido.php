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
        'estado_seguimiento',
        'fecha_recibido',
        'fecha_preparando',
        'fecha_listo',
        'fecha_en_camino',
        'fecha_entregado',
        'codigo_seguimiento',
        'latitud',
        'longitud',
        'direccion_entrega',
        'ultima_actualizacion_ubicacion',
    ];

    // Si tu columna carrito es json, puedes usar:
    protected $casts = [
        'carrito' => 'array',
        'fecha_recibido' => 'datetime',
        'fecha_preparando' => 'datetime',
        'fecha_listo' => 'datetime',
        'fecha_en_camino' => 'datetime',
        'fecha_entregado' => 'datetime',
        'ultima_actualizacion_ubicacion' => 'datetime',
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
    ];
    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function platos()
    {
        return $this->belongsToMany(Plato::class, 'pedido_plato')
                    ->withPivot('cantidad', 'precio')
                    ->withTimestamps();
    }
}
