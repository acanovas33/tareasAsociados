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
                    <img src="{{ asset('images/logoPrincipal.png') }}" alt="Logo de DevSprint"
                        class="mb-6 block h-auto w-[150px] max-w-full">

                    <p class="sobretitulo mb-2">Tu espacio</p>

                    <h1 class="titulo-pagina">Mis proyectos</h1>

                    <p class="texto-suave mt-2">
                        Aquí están todos los proyectos en los que colaboras.
                    </p>



                </div>

                <div class="flex flex-col items-end gap-4">

                    <details class="menu-usuario">
                        <summary class="menu-usuario-trigger">
                            {{ $usuario->nombre }}
                            <span aria-hidden="true">⌄</span>
                        </summary>

                        <div class="menu-usuario-opciones">
                            <a href="{{ route('perfil.edit') }}" class="menu-usuario-enlace">
                                Editar perfil
                            </a>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit" class="menu-usuario-enlace">
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </details>


                    <div class="flex flex-col items-end gap-4">

                        <button type="button" onclick="abrirPopup()" class="boton-principal w-full sm:w-auto">
                            Nuevo proyecto
                        </button>

                    </div>

                    <div id="popupProyecto"
                        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
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

                                    <input type="text" name="nombre" id="nombre" required maxlength="255"
                                        placeholder="Ej. DevSprint"
                                        class="w-full rounded-lg border border-slate-300 p-3">

                                    @error('nombre')
                                        <p class="mt-2 text-sm text-red-500">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <div class="mt-6 flex justify-end gap-3">

                                        <button type="button" onclick="cerrarPopup()"
                                            class="rounded-lg border border-slate-300 px-4 py-2">
                                            Cancelar
                                        </button>

                                        <button type="submit" class="boton-principal">
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

                        document.addEventListener('DOMContentLoaded', () => {
                            const avisoColaborador = document.getElementById('avisoColaborador');

                            if (avisoColaborador) {
                                window.setTimeout(() => avisoColaborador.remove(), 5000);
                            }
                        });
                    </script>


                </div>

            </div>
        </div>

        @if (session('status'))
            <div id="avisoColaborador" class="tarjeta" role="status" aria-live="polite">
                <div class="tarjeta-franja"></div>
                <div class="tarjeta-cuerpo font-semibold text-texto">{{ session('status') }}</div>
            </div>
        @endif

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
                                <a href="{{ route('tareas.proyecto', $usuarioProyecto->proyecto) }}"
                                    class="hover:underline">
                                    {{ $usuarioProyecto->proyecto->nombre }}
                                </a>
                            </h2>

                            <p class="texto-suave mt-2">
                                Proyecto en el que colaboras.
                            </p>

                            @if ((int) $usuarioProyecto->id_rol === 1)
                                @php($erroresColaborador = $errors->getBag('colaborador-' . $usuarioProyecto->id_proyecto))

                                <details class="mt-4" @if ($erroresColaborador->any()) open @endif>
                                    <summary class="cursor-pointer font-semibold text-destacado">
                                        Añadir colaborador
                                    </summary>

                                    <form
                                        action="{{ route('proyectos.colaboradores.store', $usuarioProyecto->proyecto) }}"
                                        method="POST" class="mt-4 space-y-4">
                                        @csrf

                                        <div>
                                            <label for="correo-colaborador-{{ $usuarioProyecto->id_proyecto }}"
                                                class="etiqueta">
                                                Correo electrónico
                                            </label>
                                            <input type="email"
                                                id="correo-colaborador-{{ $usuarioProyecto->id_proyecto }}"
                                                name="correo"
                                                value="{{ $erroresColaborador->any() ? old('correo') : '' }}"
                                                autocomplete="email" required class="campo">
                                            @if ($erroresColaborador->has('correo'))
                                                <p class="campo-error">{{ $erroresColaborador->first('correo') }}</p>
                                            @endif
                                        </div>

                                        <button type="submit" class="boton-secundario w-full">
                                            Añadir colaborador
                                        </button>
                                    </form>
                                </details>
                                <form action="{{ route('proyectos.destroy', $usuarioProyecto->proyecto) }}"
                                    method="POST" class="mt-4"
                                    onsubmit="return confirm('¿Seguro que quieres eliminar este proyecto? También se eliminarán sus tareas y asignaciones. Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="boton-secundario w-full">
                                        Eliminar proyecto
                                    </button>
                                </form>
                            @elseif ((int) $usuarioProyecto->id_rol === 2)
                                <form action="{{ route('proyectos.salir', $usuarioProyecto->proyecto) }}"
                                    method="POST" class="mt-4"
                                    onsubmit="return confirm('¿Seguro que quieres salir de este proyecto?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="boton-secundario w-full">
                                        Salir del proyecto
                                    </button>
                                </form>
                            @endif

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
