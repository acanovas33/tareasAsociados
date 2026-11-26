<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Usuario;
use App\Models\UsuarioProyectoRol;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProyectosController extends Controller
{
    public function store(Request $request): RedirectResponse
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

    public function agregarColaborador(Request $request, Proyecto $proyecto): RedirectResponse
    {
        abort_unless(
            UsuarioProyectoRol::query()
                ->where('id_usuario', Auth::id())
                ->where('id_proyecto', $proyecto->id)
                ->where('id_rol', 1)
                ->exists(),
            403
        );

        $bolsaErrores = 'colaborador-'.$proyecto->id;
        $validador = Validator::make($request->only('correo'), [
            'correo' => ['required', 'email', 'max:150', 'exists:usuario,correo'],
        ], [
            'correo.required' => 'Escribe el correo electrónico del usuario.',
            'correo.email' => 'Escribe un correo electrónico válido.',
            'correo.max' => 'El correo electrónico no puede superar :max caracteres.',
            'correo.exists' => 'No encontramos una cuenta con ese correo.',
        ], [
            'correo' => 'correo electrónico',
        ]);

        $datos = $validador->validateWithBag($bolsaErrores);
        $usuario = Usuario::query()->where('correo', $datos['correo'])->firstOrFail();

        if (UsuarioProyectoRol::query()
            ->where('id_usuario', $usuario->id)
            ->where('id_proyecto', $proyecto->id)
            ->exists()) {
            return back()
                ->withErrors([
                    'correo' => 'Ese usuario ya forma parte del proyecto.',
                ], $bolsaErrores)
                ->withInput();
        }

    

        UsuarioProyectoRol::query()->create([
            'id_usuario' => $usuario->id,
            'id_proyecto' => $proyecto->id,
            'id_rol' => 2,
        ]);

        return redirect()
            ->route('proyectos.index')
            ->with('status', 'Colaborador añadido correctamente.');
    }

    public function eliminar(Proyecto $proyecto): RedirectResponse
    {
        abort_unless(
            UsuarioProyectoRol::query()
                ->where('id_usuario', Auth::id())
                ->where('id_proyecto', $proyecto->id)
                ->where('id_rol', 1)
                ->exists(),
            403
        );

        $proyecto->delete();

        return redirect()
            ->route('proyectos.index')
            ->with('status', 'Proyecto eliminado correctamente.');
    }

    public function salir(Proyecto $proyecto): RedirectResponse
    {
        $filasEliminadas = UsuarioProyectoRol::query()
            ->where('id_usuario', Auth::id())
            ->where('id_proyecto', $proyecto->id)
            ->where('id_rol', 2)
            ->delete();

        abort_unless($filasEliminadas === 1, 403);

        return redirect()
            ->route('proyectos.index')
            ->with('status', 'Has salido del proyecto correctamente.');
    }

    public function index(): View
    {
        $usuario = auth()->user();

        $proyectosUsuario = UsuarioProyectoRol::with([
            'proyecto',
            'rol',
        ])
            ->where('id_usuario', $usuario->id)
            ->get();

        return view('proyectos', [
            'usuario' => $usuario,
            'proyectosUsuario' => $proyectosUsuario,
        ]);
    }
}
