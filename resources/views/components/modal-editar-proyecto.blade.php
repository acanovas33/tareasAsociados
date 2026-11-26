@props(['proyecto'])

{{--
    Pop-up «Editar proyecto». Hay uno por proyecto y se abre con <button data-abrir-modal="modal-editar-proyecto-{id}">.
    Solo se muestra a quien administra el proyecto. Viene relleno con el nombre actual; si el servidor
    devuelve errores (bolsa editarProyecto-{id}), se vuelve a abrir solo el de este proyecto con lo escrito.
--}}
@php
    $errores = isset($errors) ? $errors->getBag('editarProyecto-'.$proyecto->id) : new \Illuminate\Support\MessageBag;
    $id = 'modal-editar-proyecto-'.$proyecto->id;
@endphp
<dialog id="{{ $id }}" class="modal" aria-labelledby="{{ $id }}-titulo" @if ($errores->any()) data-abrir-al-cargar @endif>
    <div class="tarjeta">
        <div class="tarjeta-franja"></div>
        <form method="POST" action="{{ route('proyectos.update', $proyecto) }}" class="tarjeta-cuerpo space-y-4">
            @csrf
            @method('PUT')

            <div>
                <p class="sobretitulo mb-2">Editar proyecto</p>
                <h2 id="{{ $id }}-titulo" class="titulo-seccion">{{ $proyecto->nombre }}</h2>
                <p class="texto-suave mt-2">Cambia el nombre del proyecto. Lo verán todos sus miembros.</p>
            </div>

            <div>
                <label for="{{ $id }}-nombre" class="etiqueta">Nombre del proyecto</label>
                <input type="text" id="{{ $id }}-nombre" name="nombre" value="{{ $errores->any() ? old('nombre') : $proyecto->nombre }}" maxlength="255" required class="campo">
                @if ($errores->has('nombre')) <div class="campo-error">{{ $errores->first('nombre') }}</div> @endif
            </div>

            <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                <button type="button" class="boton-secundario whitespace-nowrap" data-cerrar-modal>Cancelar</button>
                <button type="submit" class="boton-principal whitespace-nowrap">Guardar cambios</button>
            </div>
        </form>
    </div>
</dialog>
