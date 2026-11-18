@props(['proyecto', 'estados' => [], 'usuarios' => []])

{{--
    Pop-up «Crear tarea». Se abre con un botón <button data-abrir-modal="modal-crear-tarea">.
    $proyecto: id del proyecto · $estados y $usuarios: arrays [id => nombre].
    Si el servidor devuelve errores de validación, el pop-up se vuelve a abrir solo.
--}}
@php
    $errores = isset($errors) ? $errors->getBag('crearTarea') : new \Illuminate\Support\MessageBag;
@endphp
<dialog id="modal-crear-tarea" class="modal" aria-labelledby="modal-crear-tarea-titulo" @if ($errores->any()) data-abrir-al-cargar @endif>
    <div class="tarjeta">
        <div class="tarjeta-franja"></div>
        <form method="POST" action="{{ route('tareas.store', $proyecto) }}" class="tarjeta-cuerpo space-y-4">
            @csrf

            <div>
                <p class="sobretitulo mb-2">Nueva tarea</p>
                <h2 id="modal-crear-tarea-titulo" class="titulo-seccion">Crear tarea</h2>
                <p class="texto-suave mt-2">Añade una tarea al proyecto. Podrás cambiarla más tarde.</p>
            </div>

            <div>
                <label for="tarea-nombre" class="etiqueta">Título</label>
                <input type="text" id="tarea-nombre" name="nombre" value="{{ old('nombre') }}" maxlength="255" required class="campo">
                @if ($errores->has('nombre')) <div class="campo-error">{{ $errores->first('nombre') }}</div> @endif
            </div>

            <div>
                <label for="tarea-descripcion" class="etiqueta">Descripción</label>
                <textarea id="tarea-descripcion" name="descripcion" rows="3" maxlength="1000" class="campo">{{ old('descripcion') }}</textarea>
                @if ($errores->has('descripcion')) <div class="campo-error">{{ $errores->first('descripcion') }}</div> @endif
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="tarea-estado" class="etiqueta">Estado</label>
                    <select id="tarea-estado" name="id_estado" required class="campo">
                        @foreach ($estados as $idEstado => $nombreEstado)
                            <option value="{{ $idEstado }}" @selected((string) old('id_estado', array_key_first($estados)) === (string) $idEstado)>{{ $nombreEstado }}</option>
                        @endforeach
                    </select>
                    @if ($errores->has('id_estado')) <div class="campo-error">{{ $errores->first('id_estado') }}</div> @endif
                </div>

                <div>
                    <label for="tarea-fecha-limite" class="etiqueta">Fecha límite</label>
                    <input type="date" id="tarea-fecha-limite" name="fecha_limite" value="{{ old('fecha_limite') }}" class="campo font-mono">
                    @if ($errores->has('fecha_limite')) <div class="campo-error">{{ $errores->first('fecha_limite') }}</div> @endif
                </div>
            </div>

            <div>
                <label for="tarea-usuario" class="etiqueta">Asignar a</label>
                <select id="tarea-usuario" name="id_usuario" class="campo">
                    <option value="">Sin asignar</option>
                    @foreach ($usuarios as $idUsuario => $nombreUsuario)
                        <option value="{{ $idUsuario }}" @selected((string) old('id_usuario') === (string) $idUsuario)>{{ $nombreUsuario }}</option>
                    @endforeach
                </select>
                @if ($errores->has('id_usuario')) <div class="campo-error">{{ $errores->first('id_usuario') }}</div> @endif
            </div>

            <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                <button type="button" class="boton-secundario" data-cerrar-modal>Cancelar</button>
                <button type="submit" class="boton-principal">Crear tarea</button>
            </div>
        </form>
    </div>
</dialog>
