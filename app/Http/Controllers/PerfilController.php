<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PerfilController extends Controller
{
    public function edit(): View
    {
        $usuario = Auth::user();

        return view('editar-perfil', compact('usuario'));
    }

    public function update(Request $request): RedirectResponse
    {
        $usuario = Auth::user();

        abort_unless($usuario, 401);

        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('usuario', 'correo')->ignore($usuario->id),
            ],
        ]);

        $usuario->nombre = $datos['name'];
        $usuario->correo = $datos['email'];

        $usuario->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $usuario = Auth::user();

        abort_unless($usuario, 401);

        $datos = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $usuario->contrasena = Hash::make($datos['password']);
        $usuario->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}