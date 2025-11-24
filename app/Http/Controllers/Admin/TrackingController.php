<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    // Actualizar ubicación del pedido (para repartidores/admin)
    public function actualizarUbicacion(Request $request, $id)
    {
        $request->validate([
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        try {
            $pedido = Pedido::findOrFail($id);
            
            $pedido->latitud = $request->latitud;
            $pedido->longitud = $request->longitud;
            $pedido->ultima_actualizacion_ubicacion = now();
            
            // Si está en camino, actualizar estado
            if ($pedido->estado_seguimiento !== 'en_camino') {
                $pedido->estado_seguimiento = 'en_camino';
                $pedido->fecha_en_camino = now();
            }
            
            $pedido->save();

            return response()->json([
                'success' => true,
                'mensaje' => 'Ubicación actualizada correctamente',
                'pedido' => [
                    'id' => $pedido->id,
                    'latitud' => $pedido->latitud,
                    'longitud' => $pedido->longitud,
                    'estado_seguimiento' => $pedido->estado_seguimiento,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar la ubicación: ' . $e->getMessage()
            ], 500);
        }
    }

    // Simular movimiento del pedido (para testing)
    public function simularMovimiento($id)
    {
        try {
            $pedido = Pedido::findOrFail($id);
            
            if (!$pedido->direccion_entrega) {
                return response()->json([
                    'error' => 'El pedido no tiene dirección de entrega'
                ], 400);
            }

            // Coordenadas base (restaurante)
            $baseLat = -16.4090;
            $baseLng = -71.5350;
            
            // Simular movimiento hacia la dirección de entrega
            // En producción, esto se haría con geocoding real
            $nuevaLat = $baseLat + (rand(-500, 500) / 10000);
            $nuevaLng = $baseLng + (rand(-500, 500) / 10000);
            
            $pedido->latitud = $nuevaLat;
            $pedido->longitud = $nuevaLng;
            $pedido->ultima_actualizacion_ubicacion = now();
            
            if ($pedido->estado_seguimiento !== 'en_camino') {
                $pedido->estado_seguimiento = 'en_camino';
                $pedido->fecha_en_camino = now();
            }
            
            $pedido->save();

            return response()->json([
                'success' => true,
                'latitud' => $nuevaLat,
                'longitud' => $nuevaLng,
                'mensaje' => 'Ubicación simulada actualizada'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al simular movimiento: ' . $e->getMessage()
            ], 500);
        }
    }
}

