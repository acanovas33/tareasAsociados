<?php
namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function mostrarLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('nombre', $request->usuario)
            ->orWhere('correo', $request->usuario)
            ->first();

        if ($usuario && Hash::check($request->password, $usuario->contrasena)) {
            $request->session()->regenerate();

            return redirect()->route('proyectos.index');
        }

        return back()
            ->withErrors([
                'usuario' => 'El usuario o la contraseña son incorrectos.'
            ])
            ->withInput($request->only('usuario'));
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
