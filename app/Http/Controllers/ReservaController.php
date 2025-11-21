<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservaController extends Controller
{
    // Mostrar la vista de reserva
    public function index()
    {
        return view('reserva');
    }

    // Procesar el formulario de reserva
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'personas' => 'required|string|in:1,2,3,4,5',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'personas.required' => 'Debes seleccionar la cantidad de personas.',
            'personas.in' => 'La cantidad de personas seleccionada no es válida.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser una fecha válida.',
            'fecha.after_or_equal' => 'La fecha debe ser hoy o una fecha futura.',
            'hora.required' => 'La hora es obligatoria.',
            'hora.date_format' => 'La hora debe tener un formato válido (HH:MM).',
        ]);

        // Aquí podrías agregar lógica para guardar la reserva en BD, enviar email, etc.
        // Por ahora solo redirigimos con un mensaje de éxito

        return redirect()->route('reserva')->with('success', '¡Reserva realizada correctamente! Te esperamos en la fecha y hora indicada.');
    }
}

