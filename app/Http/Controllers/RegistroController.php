<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('registro');
    }

    public function correcto(): View
    {
        return view('registrocorrecto', [
            'usuarios' => Usuario::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = new Usuario;
        $usuario->nombre = $request->input('nombre');
        $usuario->correo = $request->input('correo');
        $usuario->contrasena = bcrypt($request->input('contrasena'));

        if ($request->input('contrasena') === $request->input('repetir_contrasena')) {
            $usuario->save();

            return redirect()->route('registrocorrecto')->with('success', 'Usuario registrado correctamente');
        } else {
            return back()->withErrors(['contrasena' => 'Las contraseñas no coinciden'])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
