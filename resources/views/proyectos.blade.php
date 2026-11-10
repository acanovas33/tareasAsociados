<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis proyectos</title>
    @fonts
    @vite('resources/css/app.css')
</head>

<body class="app-fondo">
    <main class="mx-auto w-full max-w-5xl space-y-6">

        <div class="tarjeta">
            <div class="tarjeta-franja"></div>

            <div class="tarjeta-cuerpo flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">

                <div>
                    <img
                        src="{{ asset('images/logoPrincipal.png') }}"
                        alt="Logo de DevSprint"
                        class="mb-6 block h-auto w-[150px] max-w-full"
                    >

                    <p class="sobretitulo mb-2">Tu espacio</p>

                    <h1 class="titulo-pagina">Mis proyectos</h1>

                    <p class="texto-suave mt-2">
                        Aquí están todos los proyectos en los que colaboras.
                    </p>
<div class="mt-6 max-w-md">

    <label
        for="proyectoSeleccionado"
        class="mb-2 block font-semibold text-slate-700"
    >
        Selecciona un proyecto
    </label>

    <select
        id="proyectoSeleccionado"
        name="proyectoSeleccionado"
        class="w-full rounded-lg border border-slate-300
               bg-white p-3 text-slate-700 shadow-sm
               transition
               focus:border-principal focus:outline-none
               focus:ring-2 focus:ring-principal/20"
    >

        <option value="" disabled selected>
            Elige un proyecto...
        </option>

        @forelse ($proyectosUsuario as $usuarioProyecto)

            <option value="{{ $usuarioProyecto->proyecto->id }}">

                {{ $usuarioProyecto->proyecto->nombre }}
                ({{ $usuarioProyecto->rol->nombre }})

            </option>

        @empty

            <option value="" disabled>
                No tienes proyectos disponibles
            </option>

        @endforelse

    </select>

</div>
<div class="mt-6 max-w-md">

    <label
        for="proyectoSeleccionado"
        class="mb-2 block font-semibold text-slate-700"
    >
        Selecciona un proyecto
    </label>

    <select
        id="proyectoSeleccionado"
        name="proyectoSeleccionado"
        class="w-full rounded-lg border border-slate-300 bg-white p-3
               text-slate-700 shadow-sm transition
               focus:border-principal focus:outline-none
               focus:ring-2 focus:ring-principal/20"
    >

        <option value="" disabled selected>
            Elige un proyecto...
        </option>

        @forelse ($proyectosUsuario as $usuarioProyecto)

            <option value="{{ $usuarioProyecto->proyecto->id_proyecto }}">

                {{ $usuarioProyecto->proyecto->nombre }}
                ({{ $usuarioProyecto->rol->nombre }})

            </option>

        @empty

            <option value="" disabled>
                No tienes proyectos disponibles
            </option>

        @endforelse

    </select>

</div>
```
                </div>

                <div class="flex flex-col items-end gap-4">

                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-principal font-bold text-white">
                        </div>

                        <span class="font-semibold text-slate-700">
                            {{ $usuario->nombre }}
                        </span>
                    </div>

                    
<div class="flex flex-col items-end gap-4">

    <div class="flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-principal font-bold text-white">
        </div>

        <span class="font-semibold text-slate-700">
        </span>
    </div>

    <button
        type="button"
        onclick="abrirPopup()"
        class="boton-principal w-full sm:w-auto"
    >
        Nuevo proyecto
    </button>

</div>

<div
    id="popupProyecto"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4"
>
    <div class="tarjeta w-full max-w-md">

        <div class="tarjeta-franja"></div>

        <div class="p-6">

            <h2 class="titulo-seccion">
                Crear nuevo proyecto
            </h2>

            <p class="texto-suave mt-2">
                Introduce el nombre de tu nuevo proyecto.
            </p>

            <form action="{{ route('proyectos.store') }}" method="POST" class="mt-6">

                @csrf

                <label for="nombre" class="mb-2 block font-semibold text-slate-700">
                    Nombre del proyecto
                </label>

                <input
                    type="text"
                    name="nombre"
                    id="nombre"
                    required
                    maxlength="255"
                    placeholder="Ej. DevSprint"
                    class="w-full rounded-lg border border-slate-300 p-3"
                >

                @error('nombre')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror

                <div class="mt-6 flex justify-end gap-3">

                    <button
                        type="button"
                        onclick="cerrarPopup()"
                        class="rounded-lg border border-slate-300 px-4 py-2"
                    >
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="boton-principal"
                    >
                        Crear proyecto
                    </button>

                </div>

            </form>

        </div>

    </div>
</div>

<script>
    function abrirPopup() {
        const popup = document.getElementById('popupProyecto');

        popup.classList.remove('hidden');
        popup.classList.add('flex');

        document.getElementById('nombre').focus();
    }

    function cerrarPopup() {
        const popup = document.getElementById('popupProyecto');

        popup.classList.add('hidden');
        popup.classList.remove('flex');
    }

    document.getElementById('popupProyecto').addEventListener('click', function(event) {
        if (event.target === this) {
            cerrarPopup();
        }
    });

    @if ($errors->has('nombre'))
        abrirPopup();
    @endif
</script>


                </div>

            </div>
        </div>

@if ($proyectosUsuario->isNotEmpty())

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

        @foreach ($proyectosUsuario as $usuarioProyecto)

            <article class="tarjeta flex flex-col">

                <div class="tarjeta-franja"></div>

                <div class="flex flex-1 flex-col p-6">

                    <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-principal">
                        {{ $usuarioProyecto->rol->nombre }}
                    </p>

                    <h2 class="titulo-seccion">
                        {{ $usuarioProyecto->proyecto->nombre }}
                    </h2>

                    <p class="texto-suave mt-2">
                        Proyecto en el que colaboras.
                    </p>

                </div>

            </article>

        @endforeach

    </div>

@else

    <div class="tarjeta text-center">

        <div class="tarjeta-franja"></div>

        <div class="p-9">

            <h2 class="titulo-seccion">
                Todavía no tienes proyectos
            </h2>

            <p class="texto-suave mt-2">
                Crea tu primer proyecto para empezar a organizar tus tareas.
            </p>

        </div>

    </div>

@endif

        <p class="text-center text-xs text-white/75">
            Organiza tu día. Avanza con claridad.
        </p>

    </main>
</body>
</html>
