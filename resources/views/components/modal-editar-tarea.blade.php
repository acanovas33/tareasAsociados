@props(['tarea', 'estados' => [], 'usuarios' => []])

{{--
    Pop-up «Editar tarea». Hay uno por tarea y se abre con <button data-abrir-modal="modal-editar-tarea-{id}">.
    $tarea: la tarea (con sus usuarios cargados) · $estados y $usuarios: arrays [id => nombre].
    Viene relleno con los datos actuales. Si el servidor devuelve errores, se vuelve a abrir solo el de
    esta tarea (el campo oculto tarea_editada dice cuál era) con lo que se había escrito.
--}}
@php
    $errores = isset($errors) ? $errors->getBag('editarTarea') : new \Illuminate\Support\MessageBag;
    // ¿Los errores son de esta tarea? Solo entonces se usa lo escrito (old) en lugar de los datos guardados
    $conErrores = $errores->any() && (string) old('tarea_editada') === (string) $tarea->id;
    $valor = fn (string $campo, $guardado) => $conErrores ? old($campo) : $guardado;
    $fecha = fn ($fecha) => $fecha ? \Illuminate\Support\Carbon::parse($fecha)->format('Y-m-d') : null;
    $asignados = $conErrores
        ? array_map('strval', (array) old('usuarios', []))
        : $tarea->usuarios->pluck('id')->map(fn ($id) => (string) $id)->all();
    $id = 'modal-editar-tarea-'.$tarea->id;
@endphp
<dialog id="{{ $id }}" class="modal" aria-labelledby="{{ $id }}-titulo" @if ($conErrores) data-abrir-al-cargar @endif>
    <div class="tarjeta">
        <div class="tarjeta-franja"></div>
        <form method="POST" action="{{ route('tareas.update', $tarea) }}" class="tarjeta-cuerpo space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="tarea_editada" value="{{ $tarea->id }}">

            <div>
                <p class="sobretitulo mb-2">Editar tarea</p>
                <h2 id="{{ $id }}-titulo" class="titulo-seccion">{{ $tarea->nombre }}</h2>
                <p class="texto-suave mt-2">Cambia los datos de la tarea y quién la tiene asignada.</p>
            </div>

            <div>
                <label for="{{ $id }}-nombre" class="etiqueta">Título</label>
                <input type="text" id="{{ $id }}-nombre" name="nombre" value="{{ $valor('nombre', $tarea->nombre) }}" maxlength="255" required class="campo">
                @if ($conErrores && $errores->has('nombre')) <div class="campo-error">{{ $errores->first('nombre') }}</div> @endif
            </div>

            <div>
                <label for="{{ $id }}-descripcion" class="etiqueta">Descripción</label>
                <textarea id="{{ $id }}-descripcion" name="descripcion" rows="3" maxlength="1000" class="campo">{{ $valor('descripcion', $tarea->descripcion) }}</textarea>
                @if ($conErrores && $errores->has('descripcion')) <div class="campo-error">{{ $errores->first('descripcion') }}</div> @endif
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label for="{{ $id }}-estado" class="etiqueta">Estado</label>
                    <select id="{{ $id }}-estado" name="id_estado" required class="campo">
                        @foreach ($estados as $idEstado => $nombreEstado)
                            <option value="{{ $idEstado }}" @selected((string) $valor('id_estado', $tarea->id_estado) === (string) $idEstado)>{{ $nombreEstado }}</option>
                        @endforeach
                    </select>
                    @if ($conErrores && $errores->has('id_estado')) <div class="campo-error">{{ $errores->first('id_estado') }}</div> @endif
                </div>

                <div>
                    <label for="{{ $id }}-fecha-inicio" class="etiqueta">Fecha de inicio</label>
                    <input type="date" id="{{ $id }}-fecha-inicio" name="fecha_inicio" value="{{ $valor('fecha_inicio', $fecha($tarea->fecha_inicio)) }}" class="campo font-mono">
                    @if ($conErrores && $errores->has('fecha_inicio')) <div class="campo-error">{{ $errores->first('fecha_inicio') }}</div> @endif
                </div>

                <div>
                    <label for="{{ $id }}-fecha-limite" class="etiqueta">Fecha límite</label>
                    <input type="date" id="{{ $id }}-fecha-limite" name="fecha_limite" value="{{ $valor('fecha_limite', $fecha($tarea->fecha_limite)) }}" class="campo font-mono">
                    @if ($conErrores && $errores->has('fecha_limite')) <div class="campo-error">{{ $errores->first('fecha_limite') }}</div> @endif
                </div>
            </div>

            <fieldset>
                <legend class="etiqueta">Asignada a</legend>
                @if (count($usuarios) === 0)
                    <p class="texto-suave">El proyecto todavía no tiene miembros.</p>
                @else
                    <div class="grid gap-2 sm:grid-cols-2">
                        @foreach ($usuarios as $idUsuario => $nombreUsuario)
                            <label class="flex min-h-11 cursor-pointer items-center gap-3 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-texto hover:border-slate-400">
                                <input type="checkbox" name="usuarios[]" value="{{ $idUsuario }}" class="h-4 w-4 accent-principal" @checked(in_array((string) $idUsuario, $asignados, true))>
                                {{ $nombreUsuario }}
                            </label>
                        @endforeach
                    </div>
                @endif
                @if ($conErrores && $errores->has('usuarios.*')) <div class="campo-error">{{ $errores->first('usuarios.*') }}</div> @endif
            </fieldset>

            {{-- Eliminar a la izquierda; Cancelar y Guardar juntos a la derecha (bajan de fila si no caben) --}}
            <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:flex-wrap sm:items-center">
                {{-- Abre el pop-up de confirmación (x-modal-eliminar-tarea) encima de este --}}
                <button type="button" class="boton-secundario whitespace-nowrap text-alerta" data-abrir-modal="modal-eliminar-tarea-{{ $tarea->id }}">Eliminar tarea</button>
                <div class="flex flex-col-reverse gap-3 sm:ml-auto sm:flex-row">
                    <button type="button" class="boton-secundario whitespace-nowrap" data-cerrar-modal>Cancelar</button>
                    <button type="submit" class="boton-principal whitespace-nowrap">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>
</dialog>
