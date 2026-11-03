<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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

        // Cuando se integre la autenticación, comprobará que haya sesión.
        abort_unless($usuario, 401);

        $datos = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('usuario', 'correo')->ignore($usuario->id),
            ],

            'current_password' => ['required', 'current_password'],
        ]);

        $usuario->nombre = $datos['name'];
        $usuario->correo = $datos['email'];

        $usuario->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
}