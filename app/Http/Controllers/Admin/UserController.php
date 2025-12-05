<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('admin.usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'rol' => 'required|in:cliente,empleado,admin',
        ]);

        $isAdmin = $request->rol === 'admin';
        $isEmployee = $request->rol === 'empleado';

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'is_admin'  => $isAdmin ? 1 : 0,
            'is_employee' => $isEmployee ? 1 : 0,
        ]);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $usuario)
    {
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required',
            'email' => "required|email|unique:users,email,$usuario->id",
            'password' => 'nullable|min:6',
            'rol' => 'required|in:cliente,empleado,admin',
        ]);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->is_admin = $request->rol === 'admin' ? 1 : 0;
        $usuario->is_employee = $request->rol === 'empleado' ? 1 : 0;

        if ($request->password) {
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
