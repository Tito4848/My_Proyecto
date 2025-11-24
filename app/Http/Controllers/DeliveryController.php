<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class DeliveryController extends Controller
{
    // Mostrar la vista de delivery con los productos del carrito
    public function index()
    {
        $carrito = session('carrito', []);
        return view('delivery', compact('carrito'));
    }

    // Guardar el pedido en la base de datos
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'metodo_pago' => 'required|string',
        ]);

        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('delivery')->with('error', 'El carrito está vacío.');
        }

        // Calcular total
        $total = 0;
        foreach ($carrito as $item) {
            $total += ($item['precio'] ?? 0) * ($item['cantidad'] ?? 1);
        }

        // Generar código de seguimiento
        $codigoSeguimiento = 'SAL' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));

        // Obtener coordenadas de la dirección (simulado - en producción usarías Google Geocoding API)
        $coordenadas = $this->obtenerCoordenadas($request->direccion);

        // Datos del pedido
        $datosPedido = [
            'user_id' => auth()->id(),
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'metodo_pago' => $request->metodo_pago,
            'carrito' => json_encode(array_values($carrito)),
            'total' => $total,
            'estado' => 'pendiente',
            'estado_seguimiento' => 'recibido',
            'fecha_recibido' => now(),
            'codigo_seguimiento' => $codigoSeguimiento,
            'direccion_entrega' => $request->direccion,
            'latitud' => $coordenadas['lat'],
            'longitud' => $coordenadas['lng'],
            'ultima_actualizacion_ubicacion' => now(),
        ];

        // Crear el pedido
        try {
            $pedido = Pedido::create($datosPedido);
        } catch (\Illuminate\Database\QueryException $e) {
            // Si falla por columnas que no existen, crear sin campos de seguimiento
            unset($datosPedido['estado_seguimiento']);
            unset($datosPedido['fecha_recibido']);
            unset($datosPedido['codigo_seguimiento']);
            unset($datosPedido['direccion_entrega']);
            unset($datosPedido['latitud']);
            unset($datosPedido['longitud']);
            unset($datosPedido['ultima_actualizacion_ubicacion']);
            $pedido = Pedido::create($datosPedido);
        }

        // Limpiamos el carrito
        session()->forget('carrito');

        return redirect()->route('seguimiento', $codigoSeguimiento)
            ->with('success', '¡Pedido recibido y guardado correctamente! Puedes rastrear tu pedido en tiempo real.');
    }

    // ================================
    //  Obtener coordenadas de una dirección (simulado)
    // ================================
    private function obtenerCoordenadas($direccion)
    {
        // Coordenadas de Arequipa como base
        $baseLat = -16.4090;
        $baseLng = -71.5350;
        
        // Generar coordenadas aleatorias cerca de Arequipa (simulado)
        // En producción, usarías Google Geocoding API
        $lat = $baseLat + (rand(-100, 100) / 10000); // Variación de ~1km
        $lng = $baseLng + (rand(-100, 100) / 10000);
        
        return [
            'lat' => $lat,
            'lng' => $lng
        ];
    }
}
