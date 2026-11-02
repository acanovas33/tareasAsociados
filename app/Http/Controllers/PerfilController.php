<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    public function edit(): View
    {
        return view('editar-perfil');
    }

    public function update(Request $request): RedirectResponse
    {
        $usuario = $request->user();
        abort_unless($usuario, 401);

        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($usuario->id),
            ],
        ]);

        $usuario->update($datos);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $usuario = $request->user();
        abort_unless($usuario, 401);

        $datos = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $usuario->update([
            'password' => Hash::make($datos['password']),
        ]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}
