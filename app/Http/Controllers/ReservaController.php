<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Mesa;
use App\Models\Reserva;

class ReservaController extends Controller
{
    // Mostrar la vista de reserva
    public function index()
    {
        $mesas = collect([]);
        
        try {
            if (Schema::hasTable('mesas')) {
                $fecha = request('fecha', date('Y-m-d'));
                $hora = request('hora', date('H:i'));
                
                $mesas = Mesa::with(['reservas' => function($query) use ($fecha, $hora) {
                    $query->where('estado', '!=', 'cancelada')
                          ->where('estado', '!=', 'completada')
                          ->whereDate('fecha', $fecha)
                          ->where('hora', $hora)
                          ->with('usuario');
                }])
                ->orderBy('numero')
                ->get();
            }
        } catch (\Exception $e) {
            // Si hay algún error, usar colección vacía
            $mesas = collect([]);
        }
        
        $fecha = request('fecha', date('Y-m-d'));
        $hora = request('hora', date('H:i'));

        return view('reserva', compact('mesas', 'fecha', 'hora'));
    }

    // Obtener mesas disponibles (AJAX)
    public function obtenerMesasDisponibles(Request $request)
    {
        try {
            $request->validate([
                'fecha' => 'required|date',
                'hora' => 'required|string',
                'personas' => 'required|integer|min:1',
            ]);

            $fecha = $request->fecha;
            $hora = $request->hora;
            $personas = $request->personas;

            $mesas = Mesa::where('capacidad', '>=', $personas)
                ->with(['reservas' => function($query) use ($fecha, $hora) {
                    $query->where('estado', '!=', 'cancelada')
                          ->where('estado', '!=', 'completada')
                          ->whereDate('fecha', $fecha)
                          ->where('hora', $hora)
                          ->with('usuario');
                }])
                ->get()
                ->map(function($mesa) use ($fecha, $hora) {
                    $disponible = false;
                    $reservaActiva = null;
                    
                    try {
                        $disponible = $mesa->estaDisponible($fecha, $hora);
                        $reservaActiva = $mesa->reservas->first();
                    } catch (\Exception $e) {
                        $disponible = false;
                    }
                    
                    return [
                        'id' => $mesa->id,
                        'numero' => $mesa->numero,
                        'capacidad' => $mesa->capacidad,
                        'ubicacion' => $mesa->ubicacion,
                        'estado' => $mesa->estado,
                        'disponible' => $disponible,
                        'reserva' => $reservaActiva ? [
                            'id' => $reservaActiva->id,
                            'nombre' => $reservaActiva->nombre,
                            'usuario_nombre' => $reservaActiva->usuario ? $reservaActiva->usuario->name : $reservaActiva->nombre,
                            'estado' => $reservaActiva->estado,
                            'fecha' => $reservaActiva->fecha->format('Y-m-d'),
                            'hora' => $reservaActiva->hora,
                        ] : null,
                    ];
                })
                ->filter(function($mesa) {
                    // Mostrar todas las mesas (disponibles y con reservas)
                    // El frontend se encargará de mostrar la información correcta
                    return true;
                })
                ->values();

            return response()->json($mesas);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener mesas disponibles'], 500);
        }
    }

    // Obtener información de reserva de una mesa
    public function obtenerReservaMesa(Request $request)
    {
        try {
            $request->validate([
                'mesa_id' => 'required|exists:mesas,id',
                'fecha' => 'required|date',
                'hora' => 'required|string',
            ]);

            $mesa = Mesa::findOrFail($request->mesa_id);
            
            $reserva = $mesa->reservas()
                ->where('estado', '!=', 'cancelada')
                ->where('estado', '!=', 'completada')
                ->whereDate('fecha', $request->fecha)
                ->where('hora', $request->hora)
                ->with('usuario')
                ->first();

            if ($reserva) {
                return response()->json([
                    'existe' => true,
                    'reserva' => [
                        'id' => $reserva->id,
                        'nombre' => $reserva->nombre,
                        'usuario_nombre' => $reserva->usuario ? $reserva->usuario->name : $reserva->nombre,
                        'email' => $reserva->email,
                        'telefono' => $reserva->telefono,
                        'personas' => $reserva->personas,
                        'estado' => $reserva->estado,
                        'fecha' => $reserva->fecha->format('Y-m-d'),
                        'hora' => $reserva->hora,
                        'notas' => $reserva->notas,
                        'puede_cancelar' => auth()->check() && ($reserva->user_id == auth()->id() || (auth()->user()->is_admin ?? false)),
                    ],
                ]);
            }

            return response()->json(['existe' => false]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener información de la reserva'], 500);
        }
    }

    // Cancelar una reserva
    public function cancelar(Request $request, $id)
    {
        try {
            $reserva = Reserva::findOrFail($id);

            // Verificar permisos: solo el dueño de la reserva o admin puede cancelar
            if (!auth()->check()) {
                return back()->withErrors(['error' => 'Debes estar autenticado para cancelar una reserva.']);
            }

            $user = auth()->user();
            $isAdmin = $user->is_admin ?? false;
            if ($reserva->user_id != auth()->id() && !$isAdmin) {
                return back()->withErrors(['error' => 'No tienes permisos para cancelar esta reserva.']);
            }

            // Validar que la reserva no esté ya cancelada o completada
            if (in_array($reserva->estado, ['cancelada', 'completada'])) {
                return back()->withErrors(['error' => 'Esta reserva ya está ' . $reserva->estado . '.']);
            }

            // Actualizar estado de la reserva
            $reserva->estado = 'cancelada';
            $reserva->save();

            // Actualizar estado de la mesa si estaba reservada
            if ($reserva->mesa_id) {
                $mesa = Mesa::find($reserva->mesa_id);
                if ($mesa && $mesa->estado === 'reservada') {
                    // Verificar si hay otras reservas activas para esta mesa
                    $otrasReservas = Reserva::where('mesa_id', $mesa->id)
                        ->where('id', '!=', $reserva->id)
                        ->where('estado', '!=', 'cancelada')
                        ->where('estado', '!=', 'completada')
                        ->where('fecha', '>=', now()->toDateString())
                        ->exists();
                    
                    if (!$otrasReservas) {
                        $mesa->estado = 'libre';
                        $mesa->save();
                    }
                }
            }

            return redirect()->route('reserva')
                ->with('success', 'Reserva cancelada correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cancelar la reserva. Por favor, intenta nuevamente.']);
        }
    }

    // Cambiar de mesa
    public function cambiarMesa(Request $request, $id)
    {
        try {
            $request->validate([
                'nueva_mesa_id' => 'required|exists:mesas,id',
                'fecha' => 'required|date',
                'hora' => 'required|string',
            ]);

            $reserva = Reserva::findOrFail($id);

            // Verificar permisos
            if (!auth()->check()) {
                return back()->withErrors(['error' => 'Debes estar autenticado para cambiar de mesa.']);
            }

            $user = auth()->user();
            $isAdmin = $user->is_admin ?? false;
            if ($reserva->user_id != auth()->id() && !$isAdmin) {
                return back()->withErrors(['error' => 'No tienes permisos para cambiar esta reserva.']);
            }

            // Validar que la reserva no esté cancelada o completada
            if (in_array($reserva->estado, ['cancelada', 'completada'])) {
                return back()->withErrors(['error' => 'No se puede cambiar la mesa de una reserva ' . $reserva->estado . '.']);
            }

            $nuevaMesa = Mesa::findOrFail($request->nueva_mesa_id);

            // Verificar disponibilidad de la nueva mesa
            if (!$nuevaMesa->estaDisponible($request->fecha, $request->hora)) {
                return back()->withErrors(['nueva_mesa_id' => 'La nueva mesa no está disponible para esa fecha y hora.']);
            }

            // Verificar capacidad
            if ($nuevaMesa->capacidad < $reserva->personas) {
                return back()->withErrors(['nueva_mesa_id' => 'La nueva mesa no tiene capacidad suficiente.']);
            }

            // Liberar la mesa anterior si estaba reservada
            if ($reserva->mesa_id) {
                $mesaAnterior = Mesa::find($reserva->mesa_id);
                if ($mesaAnterior && $mesaAnterior->estado === 'reservada') {
                    $otrasReservas = Reserva::where('mesa_id', $mesaAnterior->id)
                        ->where('id', '!=', $reserva->id)
                        ->where('estado', '!=', 'cancelada')
                        ->where('estado', '!=', 'completada')
                        ->where('fecha', '>=', now()->toDateString())
                        ->exists();
                    
                    if (!$otrasReservas) {
                        $mesaAnterior->estado = 'libre';
                        $mesaAnterior->save();
                    }
                }
            }

            // Asignar la nueva mesa
            $reserva->mesa_id = $request->nueva_mesa_id;
            $reserva->fecha = $request->fecha;
            $reserva->hora = $request->hora;
            $reserva->save();

            // Actualizar estado de la nueva mesa
            if ($nuevaMesa->estado === 'libre') {
                $nuevaMesa->estado = 'reservada';
                $nuevaMesa->save();
            }

            return redirect()->route('reserva')
                ->with('success', 'Mesa cambiada correctamente.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cambiar de mesa. Por favor, intenta nuevamente.']);
        }
    }

    // Procesar el formulario de reserva
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'required|string|max:20',
            'personas' => 'required|integer|min:1|max:20',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'mesa_id' => 'nullable|exists:mesas,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'email.email' => 'El email debe ser válido.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'personas.required' => 'Debes seleccionar la cantidad de personas.',
            'personas.integer' => 'La cantidad de personas debe ser un número.',
            'personas.min' => 'Debe haber al menos 1 persona.',
            'personas.max' => 'Máximo 20 personas por reserva.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'fecha.after_or_equal' => 'La fecha debe ser hoy o una fecha futura.',
            'hora.required' => 'La hora es obligatoria.',
            'hora.date_format' => 'La hora debe tener un formato válido (HH:MM).',
            'mesa_id.exists' => 'La mesa seleccionada no existe.',
        ]);

        // Verificar disponibilidad de la mesa si se seleccionó
        if ($request->mesa_id) {
            try {
                $mesa = Mesa::findOrFail($request->mesa_id);
                
                if (!$mesa->estaDisponible($request->fecha, $request->hora)) {
                    return back()
                        ->withInput()
                        ->withErrors(['mesa_id' => 'La mesa seleccionada no está disponible para esa fecha y hora.']);
                }

                if ($mesa->capacidad < $request->personas) {
                    return back()
                        ->withInput()
                        ->withErrors(['mesa_id' => 'La mesa seleccionada no tiene capacidad suficiente.']);
                }
            } catch (\Exception $e) {
                return back()
                    ->withInput()
                    ->withErrors(['mesa_id' => 'Error al verificar la disponibilidad de la mesa.']);
            }
        }

        // Crear la reserva
        try {
            $reserva = Reserva::create([
                'user_id' => auth()->id(),
                'mesa_id' => $request->mesa_id,
                'nombre' => $request->nombre,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'personas' => $request->personas,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'estado' => 'confirmada',
                'notas' => $request->notas,
            ]);

            // Actualizar estado de la mesa si se seleccionó
            if ($request->mesa_id && isset($mesa)) {
                try {
                    $mesa->estado = 'reservada';
                    $mesa->save();
                } catch (\Exception $e) {
                    // Continuar aunque falle la actualización del estado
                }
            }
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al crear la reserva. Por favor, intenta nuevamente.']);
        }

        return redirect()->route('reserva')
            ->with('success', '¡Reserva realizada correctamente! Te esperamos en la fecha y hora indicada.');
    }
}

