<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Mesa;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['usuario', 'mesa'])
            ->latest()
            ->get();
        
        return view('admin.reservas.index', compact('reservas'));
    }

    public function show(Reserva $reserva)
    {
        $reserva->load(['usuario', 'mesa']);
        $mesas = Mesa::orderBy('numero')->get();
        
        return view('admin.reservas.show', compact('reserva', 'mesas'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,confirmada,cancelada,completada',
            'mesa_id' => 'nullable|exists:mesas,id',
            'fecha' => 'sometimes|required|date|after_or_equal:today',
            'hora' => 'sometimes|required|date_format:H:i',
        ]);

        // Si se cambia la mesa, verificar disponibilidad
        if ($request->mesa_id && $request->mesa_id != $reserva->mesa_id) {
            $nuevaMesa = Mesa::findOrFail($request->mesa_id);
            $fecha = $request->fecha ?? $reserva->fecha->format('Y-m-d');
            $hora = $request->hora ?? $reserva->hora;
            
            if (!$nuevaMesa->estaDisponible($fecha, $hora)) {
                return back()
                    ->withErrors(['mesa_id' => 'La mesa seleccionada no está disponible para esa fecha y hora.'])
                    ->withInput();
            }
            
            // Liberar mesa anterior si estaba reservada
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
            
            // Actualizar estado de la nueva mesa
            if ($nuevaMesa->estado === 'libre' && in_array($request->estado, ['pendiente', 'confirmada'])) {
                $nuevaMesa->estado = 'reservada';
                $nuevaMesa->save();
            }
        }

        // Actualizar reserva
        $reserva->update($request->only([
            'estado',
            'mesa_id',
            'fecha',
            'hora',
        ]));

        // Actualizar estado de la mesa según el estado de la reserva
        if ($reserva->mesa_id) {
            $mesa = Mesa::find($reserva->mesa_id);
            if ($mesa) {
                if (in_array($reserva->estado, ['cancelada', 'completada'])) {
                    // Verificar si hay otras reservas activas
                    $otrasReservas = Reserva::where('mesa_id', $mesa->id)
                        ->where('id', '!=', $reserva->id)
                        ->where('estado', '!=', 'cancelada')
                        ->where('estado', '!=', 'completada')
                        ->where('fecha', '>=', now()->toDateString())
                        ->exists();
                    
                    if (!$otrasReservas && $mesa->estado === 'reservada') {
                        $mesa->estado = 'libre';
                        $mesa->save();
                    }
                } elseif (in_array($reserva->estado, ['pendiente', 'confirmada']) && $mesa->estado === 'libre') {
                    $mesa->estado = 'reservada';
                    $mesa->save();
                }
            }
        }

        return redirect()
            ->route('admin.reservas.show', $reserva)
            ->with('success', 'Reserva actualizada correctamente');
    }

    public function destroy(Reserva $reserva)
    {
        // Liberar mesa si estaba reservada
        if ($reserva->mesa_id) {
            $mesa = Mesa::find($reserva->mesa_id);
            if ($mesa && $mesa->estado === 'reservada') {
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

        $reserva->delete();

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva eliminada correctamente');
    }
}

