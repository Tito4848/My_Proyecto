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
                $mesas = Mesa::orderBy('numero')->get();
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
                ->get()
                ->filter(function($mesa) use ($fecha, $hora) {
                    try {
                        return $mesa->estaDisponible($fecha, $hora);
                    } catch (\Exception $e) {
                        return false;
                    }
                })
                ->map(function($mesa) {
                    return [
                        'id' => $mesa->id,
                        'numero' => $mesa->numero,
                        'capacidad' => $mesa->capacidad,
                        'ubicacion' => $mesa->ubicacion,
                        'estado' => $mesa->estado,
                    ];
                })
                ->values();

            return response()->json($mesas);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener mesas disponibles'], 500);
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
                'estado' => 'pendiente',
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

