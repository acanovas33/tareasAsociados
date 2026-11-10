<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Tarea;
use App\Models\Estado;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Proyecto $proyecto)
    {
        $estados = Estado::orderBy('id')->get();
        $tareas  = Tarea::where('id_proyecto', $proyecto->id)
            ->with('usuarios')
            ->get()
            ->groupBy('id_estado');


        return view ('tareasProyecto', compact('proyecto', 'tareas', 'estados'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Crea una tarea en el proyecto desde el pop-up «Crear tarea».
     *
     * Columnas provisionales de la tabla `tarea` (pendiente de confirmar con el modelo de BD):
     * nombre, descripcion, fecha_limite, id_proyecto e id_estado; la asignación va en `usuario_asignado`.
     * Pendiente: comprobar que el usuario con sesión es miembro del proyecto y, si no es administrador,
     * que solo pueda asignarse la tarea a sí mismo.
     */
    public function store(Request $request, Proyecto $proyecto): RedirectResponse
    {
        $datos = $request->validateWithBag('crearTarea', [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'id_estado' => ['required', 'integer', 'exists:estado,id'],
            'fecha_limite' => ['nullable', 'date'],
            'id_usuario' => ['nullable', 'integer', 'exists:usuario,id'],
        ], [
            'nombre.required' => 'El título de la tarea es obligatorio.',
            'nombre.max' => 'El título no puede superar los 255 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 1000 caracteres.',
            'id_estado.required' => 'Elige un estado.',
            'id_estado.exists' => 'El estado elegido no existe.',
            'fecha_limite.date' => 'La fecha límite no es una fecha válida.',
            'id_usuario.exists' => 'La persona elegida no existe.',
        ]);

        $tarea = new Tarea;
        $tarea->nombre = $datos['nombre'];
        $tarea->descripcion = $datos['descripcion'] ?? null;
        $tarea->fecha_limite = $datos['fecha_limite'] ?? null;
        $tarea->id_estado = $datos['id_estado'];
        $tarea->id_proyecto = $proyecto->id;
        $tarea->save();

        if (! empty($datos['id_usuario'])) {
            $tarea->usuarios()->attach($datos['id_usuario']);
        }

        return back()->with('success', 'Tarea creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        //
    }
}
