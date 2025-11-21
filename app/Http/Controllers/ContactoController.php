<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactoController extends Controller
{
    // Mostrar la vista de contacto
    public function index()
    {
        return view('contacto');
    }

    // Procesar el formulario de contacto
    public function enviar(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'mensaje' => 'required|string|min:10|max:1000',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Debe ser un correo electrónico válido.',
            'mensaje.required' => 'El mensaje es obligatorio.',
            'mensaje.min' => 'El mensaje debe tener al menos 10 caracteres.',
            'mensaje.max' => 'El mensaje no puede tener más de 1000 caracteres.',
        ]);

        // Aquí podrías agregar lógica para enviar un email, guardar en BD, etc.
        // Por ahora solo redirigimos con un mensaje de éxito

        return redirect()->route('contacto')->with('success', '¡Mensaje enviado correctamente! Nos pondremos en contacto contigo pronto.');
    }
}

