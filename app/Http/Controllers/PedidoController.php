<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;

class PedidoController extends Controller
{
    // ================================
    //  Mostrar pantalla de pago
    // ================================
    public function pago()
    {
        // Validar carrito vacío
        if (!session('carrito') || count(session('carrito')) === 0) {
            return redirect()->route('carrito')->with('error', 'Tu carrito está vacío');
        }

        // Calcular total
        $total = 0;
        foreach (session('carrito') as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        return view('pago', compact('total'));
    }

    // ================================
    //  Procesar pago y guardar pedido
    // ================================
    public function procesarPago(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'metodo_pago' => 'required|in:Tarjeta,Yape',
        ]);

        $metodoPago = $request->metodo_pago;

        // Validación específica según método de pago
        if ($metodoPago === 'Tarjeta') {
            $request->validate([
                'numero' => ['required', 'string', function ($attribute, $value, $fail) {
                    if (!$this->validarTarjeta($value)) {
                        $fail('El número de tarjeta no es válido.');
                    }
                }],
                'vencimiento' => ['required', 'string', 'regex:/^\d{2}\/\d{2}$/', function ($attribute, $value, $fail) {
                    if (!$this->validarVencimiento($value)) {
                        $fail('La fecha de vencimiento no es válida o la tarjeta ha expirado.');
                    }
                }],
                'cvv' => 'required|string|min:3|max:4|regex:/^\d+$/',
            ]);
        } elseif ($metodoPago === 'Yape') {
            $request->validate([
                'yape_numero' => 'required|string|regex:/^\d{9}$/',
                'yape_codigo' => 'required|string|regex:/^\d{6}$/',
            ]);
        }

        // Calcular total
        $total = $this->calcularTotal();

        // Solo generamos tracking si hay entrega a domicilio
        $codigoSeguimiento = null;
        $coordenadas = ['lat' => null, 'lng' => null];
        if ($request->filled('direccion_entrega')) {
            $codigoSeguimiento = 'SAL' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
            $coordenadas = $this->obtenerCoordenadasEntrega($request->direccion_entrega);
        }

        // Datos base del pedido
        $datosPedido = [
            'user_id' => auth()->id(),
            'nombre' => $request->nombre,
            // Para compras desde el carrito no hay dirección de entrega,
            // almacenamos un valor genérico y evitamos mezclarlo con el método de pago.
            'direccion' => $request->direccion_entrega ?? 'Recoger en restaurante',
            'telefono' => $request->yape_numero ?? '000',
            'metodo_pago' => $metodoPago,
            'carrito' => json_encode(session('carrito')),
            'total' => $total,
            'estado' => 'pendiente',
        ];

        // Agregar campos de seguimiento solo cuando hay entrega
        if ($codigoSeguimiento) {
            $datosPedido['estado_seguimiento'] = 'recibido';
            $datosPedido['fecha_recibido'] = now();
            $datosPedido['codigo_seguimiento'] = $codigoSeguimiento;
            $datosPedido['latitud'] = $coordenadas['lat'];
            $datosPedido['longitud'] = $coordenadas['lng'];
            $datosPedido['ultima_actualizacion_ubicacion'] = now();
        }

        // Crear el pedido
        try {
            $pedido = Pedido::create($datosPedido);
        } catch (\Illuminate\Database\QueryException $e) {
            // Si falla por columnas que no existen, crear sin campos de seguimiento
            unset($datosPedido['estado_seguimiento']);
            unset($datosPedido['fecha_recibido']);
            unset($datosPedido['codigo_seguimiento']);
            $pedido = Pedido::create($datosPedido);
        }

        // Guardar información adicional según método de pago
        if ($metodoPago === 'Yape') {
            // Aquí podrías guardar el código de operación en una tabla separada
            // Por ahora lo guardamos en una sesión para referencia
            session([
                'yape_numero' => $request->yape_numero,
                'yape_codigo' => $request->yape_codigo,
                'pedido_id' => $pedido->id,
            ]);
        }

        // Limpiar carrito
        session()->forget('carrito');

        // Redirigir al perfil
        $mensaje = $metodoPago === 'Yape' 
            ? 'Pedido registrado correctamente. Verificaremos tu pago con Yape y te notificaremos.'
            : 'Pago realizado y pedido registrado correctamente.';

        return redirect()->route('profile.edit')
                         ->with('success', $mensaje);
    }

    // ================================
    //  Validar tarjeta con algoritmo de Luhn
    // ================================
    private function validarTarjeta($numero)
    {
        // Remover espacios
        $numero = preg_replace('/\s+/', '', $numero);
        
        // Verificar que solo contenga dígitos
        if (!preg_match('/^\d+$/', $numero)) {
            return false;
        }
        
        // Verificar longitud mínima
        if (strlen($numero) < 13 || strlen($numero) > 19) {
            return false;
        }
        
        // Algoritmo de Luhn
        $sum = 0;
        $isEven = false;
        
        // Recorrer de derecha a izquierda
        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $digit = (int)$numero[$i];
            
            if ($isEven) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            
            $sum += $digit;
            $isEven = !$isEven;
        }
        
        return ($sum % 10) === 0;
    }

    // ================================
    //  Validar fecha de vencimiento
    // ================================
    private function validarVencimiento($vencimiento)
    {
        // Formato MM/AA
        if (!preg_match('/^\d{2}\/\d{2}$/', $vencimiento)) {
            return false;
        }
        
        list($mes, $ano) = explode('/', $vencimiento);
        $mes = (int)$mes;
        $ano = (int)('20' . $ano);
        
        // Validar mes
        if ($mes < 1 || $mes > 12) {
            return false;
        }
        
        // Validar que no esté expirada
        $fechaActual = new \DateTime();
        $fechaVencimiento = new \DateTime("$ano-$mes-01");
        $fechaVencimiento->modify('last day of this month');
        
        return $fechaVencimiento >= $fechaActual;
    }

    // ================================
    //  Calcular total interno
    // ================================
    private function calcularTotal()
    {
        $total = 0;

        if (session('carrito')) {
            foreach (session('carrito') as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }
        }

        return $total;
    }

    // ================================
    //  Mostrar un pedido (AJAX)
    // ================================
    public function show($id)
    {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }

        // Convertir JSON del carrito a array
        $pedido->carrito = json_decode($pedido->carrito, true);

        return response()->json($pedido);
    }

    // ================================
    //  Seguimiento de pedido en tiempo real
    // ================================
    public function seguimiento($codigo)
    {
        $pedido = Pedido::where('codigo_seguimiento', $codigo)
            ->orWhere('id', $codigo)
            ->first();

        if (!$pedido) {
            return view('seguimiento', [
                'pedido' => null,
                'error' => 'Pedido no encontrado',
            ]);
        }

        return view('seguimiento', compact('pedido'));
    }

    // ================================
    //  API para actualizar estado de seguimiento (AJAX)
    // ================================
    public function actualizarEstado(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        $request->validate([
            'estado_seguimiento' => 'required|in:recibido,preparando,listo,en_camino,entregado',
        ]);

        $estado = $request->estado_seguimiento;
        $pedido->estado_seguimiento = $estado;

        // Actualizar fecha correspondiente
        switch ($estado) {
            case 'recibido':
                $pedido->fecha_recibido = now();
                break;
            case 'preparando':
                $pedido->fecha_preparando = now();
                break;
            case 'listo':
                $pedido->fecha_listo = now();
                break;
            case 'en_camino':
                $pedido->fecha_en_camino = now();
                break;
            case 'entregado':
                $pedido->fecha_entregado = now();
                $pedido->estado = 'entregado';
                break;
        }

        $pedido->save();

        return response()->json([
            'success' => true,
            'estado' => $estado,
            'mensaje' => 'Estado actualizado correctamente'
        ]);
    }

    // ================================
    //  Obtener estado actual del pedido (AJAX)
    // ================================
    public function obtenerEstado($id)
    {
        try {
            $pedido = Pedido::findOrFail($id);

            return response()->json([
                'estado_seguimiento' => $pedido->estado_seguimiento ?? 'recibido',
                'fecha_recibido' => $pedido->fecha_recibido ? $pedido->fecha_recibido->format('Y-m-d H:i:s') : null,
                'fecha_preparando' => $pedido->fecha_preparando ? $pedido->fecha_preparando->format('Y-m-d H:i:s') : null,
                'fecha_listo' => $pedido->fecha_listo ? $pedido->fecha_listo->format('Y-m-d H:i:s') : null,
                'fecha_en_camino' => $pedido->fecha_en_camino ? $pedido->fecha_en_camino->format('Y-m-d H:i:s') : null,
                'fecha_entregado' => $pedido->fecha_entregado ? $pedido->fecha_entregado->format('Y-m-d H:i:s') : null,
                'latitud' => $pedido->latitud,
                'longitud' => $pedido->longitud,
                'direccion_entrega' => $pedido->direccion_entrega ?? $pedido->direccion,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener el estado del pedido',
                'estado_seguimiento' => 'recibido'
            ], 500);
        }
    }

    // ================================
    //  Actualizar ubicación del pedido (AJAX - para el repartidor)
    // ================================
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
            $pedido->save();

            return response()->json([
                'success' => true,
                'mensaje' => 'Ubicación actualizada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar la ubicación'
            ], 500);
        }
    }

    // ================================
    //  Obtener coordenadas de entrega (simulado)
    // ================================
    private function obtenerCoordenadasEntrega($direccion)
    {
        // Coordenadas de Arequipa como base
        $baseLat = -16.4090;
        $baseLng = -71.5350;
        
        // Generar coordenadas aleatorias cerca de Arequipa (simulado)
        // En producción, usarías Google Geocoding API
        $lat = $baseLat + (rand(-100, 100) / 10000);
        $lng = $baseLng + (rand(-100, 100) / 10000);
        
        return [
            'lat' => $lat,
            'lng' => $lng
        ];
    }
}
