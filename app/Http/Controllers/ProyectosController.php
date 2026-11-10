<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;
use App\Models\Usuario;
use App\Models\UsuarioProyectoRol;
use Illuminate\Http\Request;use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProyectosController extends Controller
{ 
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request) {

            $proyecto = Proyecto::create([
                'nombre' => $request->nombre,
            ]);

            UsuarioProyectoRol::create([
                'id_usuario' => Auth::id(),
                'id_proyecto' => $proyecto->id,
                'id_rol' => 1,
            ]);

        });

        return redirect()->back();
    }
    
    
    public function index(): View
    {
    $usuario = auth()->user();

    $proyectosUsuario = UsuarioProyectoRol::with([
        'proyecto',
        'rol'
    ])
        ->where('id_usuario', $usuario->id)
        ->get();

    return view('proyectos', [
        'usuario' => $usuario,
        'proyectosUsuario' => $proyectosUsuario,
    ]);
    }

}
