@props(['tarea'])

{{--
    Pop-up de confirmación «Eliminar tarea». Hay uno por tarea y se abre desde el pop-up «Editar tarea»
    con <button data-abrir-modal="modal-eliminar-tarea-{id}">. Se pide confirmación porque no se puede deshacer.
--}}
@php
    $id = 'modal-eliminar-tarea-'.$tarea->id;
@endphp
<dialog id="{{ $id }}" class="modal" aria-labelledby="{{ $id }}-titulo" aria-describedby="{{ $id }}-texto">
    <div class="tarjeta">
        <div class="tarjeta-franja"></div>
        <form method="POST" action="{{ route('tareas.destroy', $tarea) }}" class="tarjeta-cuerpo space-y-4">
            @csrf
            @method('DELETE')

            <div>
                <p class="sobretitulo mb-2">Eliminar tarea</p>
                <h2 id="{{ $id }}-titulo" class="titulo-seccion">¿Eliminar «{{ $tarea->nombre }}»?</h2>
                <p id="{{ $id }}-texto" class="texto-suave mt-2">Se borrará la tarea y sus asignaciones. No se puede deshacer.</p>
            </div>

            <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                <button type="button" class="boton-secundario" data-cerrar-modal>Cancelar</button>
                <button type="submit" class="boton-peligro">Eliminar tarea</button>
            </div>
        </form>
    </div>
</dialog>
