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


        // Datos del pop-up «Crear tarea»: [id => nombre] de los estados y de los miembros del proyecto
        $estadosPopup = $estados->pluck('nombre', 'id')->all();
        $usuariosPopup = $proyecto->usuarios()->orderBy('usuario.nombre')->pluck('usuario.nombre', 'usuario.id')->all();

        return view ('tareasProyecto', compact('proyecto', 'tareas', 'estados', 'estadosPopup', 'usuariosPopup'));
    }

    public function cambiarEstado(Request $request, Tarea $tarea)
{
    $request->validate([
        'id_estado' => 'required|exists:estado,id',
    ]);

    $tarea->id_estado = $request->id_estado;
    $tarea->save();

    return response()->json(['ok' => true]);
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
     * Columnas de la tabla `tarea` que usa: nombre, descripcion, fecha_inicio, fecha_limite, id_proyecto
     * e id_estado; la asignación va en `usuario_asignado` (`fecha_inicio` y `usuario_asignado` las lee ya
     * la vista de tareas del proyecto; el resto de columnas está pendiente de confirmar con el modelo de BD).
     * Pendiente: comprobar que el usuario con sesión es miembro del proyecto y, si no es administrador,
     * que solo pueda asignarse la tarea a sí mismo.
     */
    public function store(Request $request, Proyecto $proyecto): RedirectResponse
    {
        $datos = $request->validateWithBag('crearTarea', $this->reglasTarea() + [
            'id_usuario' => ['nullable', 'integer', 'exists:usuario,id'],
        ], $this->mensajesTarea() + [
            'id_usuario.exists' => 'La persona elegida no existe.',
        ]);

        $tarea = new Tarea;
        $tarea->nombre = $datos['nombre'];
        $tarea->descripcion = $datos['descripcion'] ?? null;
        $tarea->fecha_inicio = $datos['fecha_inicio'] ?? null;
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
     * Guarda los cambios del pop-up «Editar tarea»: título, descripción, estado, fechas y personas asignadas.
     *
     * Las personas se guardan con sync(): quedan asignadas exactamente las marcadas (las demás se quitan).
     * Si hay errores, el campo oculto `tarea_editada` sirve para volver a abrir el pop-up de esta tarea.
     * Pendiente (igual que al crear): comprobar que quien edita es miembro del proyecto.
     */
    public function update(Request $request, Tarea $tarea): RedirectResponse
    {
        $datos = $request->validateWithBag('editarTarea', $this->reglasTarea() + [
            'usuarios' => ['nullable', 'array'],
            'usuarios.*' => ['integer', 'exists:usuario,id'],
        ], $this->mensajesTarea() + [
            'usuarios.*.exists' => 'Alguna de las personas elegidas no existe.',
        ]);

        $tarea->nombre = $datos['nombre'];
        $tarea->descripcion = $datos['descripcion'] ?? null;
        $tarea->fecha_inicio = $datos['fecha_inicio'] ?? null;
        $tarea->fecha_limite = $datos['fecha_limite'] ?? null;
        $tarea->id_estado = $datos['id_estado'];
        $tarea->save();

        $tarea->usuarios()->sync($datos['usuarios'] ?? []);

        return back()->with('success', 'Tarea actualizada correctamente.');
    }

    /**
     * Elimina la tarea desde el pop-up de confirmación «Eliminar tarea».
     *
     * Primero quita sus asignaciones (usuario_asignado) para no dejar filas sueltas.
     * Pendiente (igual que al crear y editar): comprobar que quien elimina es miembro del proyecto.
     */
    public function destroy(Tarea $tarea): RedirectResponse
    {
        $tarea->usuarios()->detach();
        $tarea->delete();

        return back()->with('success', 'Tarea eliminada correctamente.');
    }

    /**
     * Reglas comunes a crear y editar una tarea.
     *
     * @return array<string, array<int, string>>
     */
    private function reglasTarea(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
            'id_estado' => ['required', 'integer', 'exists:estado,id'],
            'fecha_inicio' => ['nullable', 'date'],
            'fecha_limite' => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
        ];
    }

    /**
     * Mensajes de error en castellano comunes a crear y editar una tarea.
     *
     * @return array<string, string>
     */
    private function mensajesTarea(): array
    {
        return [
            'nombre.required' => 'El título de la tarea es obligatorio.',
            'nombre.max' => 'El título no puede superar los 255 caracteres.',
            'descripcion.max' => 'La descripción no puede superar los 1000 caracteres.',
            'id_estado.required' => 'Elige un estado.',
            'id_estado.exists' => 'El estado elegido no existe.',
            'fecha_inicio.date' => 'La fecha de inicio no es una fecha válida.',
            'fecha_limite.date' => 'La fecha límite no es una fecha válida.',
            'fecha_limite.after_or_equal' => 'La fecha límite no puede ser anterior a la de inicio.',
        ];
    }
}
