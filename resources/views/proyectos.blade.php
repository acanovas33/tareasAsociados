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
            <div class="tarjeta-cuerpo flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <img src="{{ asset('images/logoPrincipal.png') }}" alt="Logo de DevSprint" class="mb-6 block h-auto w-[150px] max-w-full">
                    <p class="sobretitulo mb-2">Tu espacio</p>
                    <h1 class="titulo-pagina">Mis proyectos</h1>
                    <p class="texto-suave mt-2">Aquí están todos los proyectos en los que colaboras.</p>
                </div>

                <button type="button" class="boton-principal w-full sm:w-auto">Nuevo proyecto</button>
            </div>
        </div>

        @if (count($proyectos) > 0)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($proyectos as $proyecto)
                    @php
                        $porcentaje = $proyecto['tareas_totales'] > 0 ? round($proyecto['tareas_hechas'] / $proyecto['tareas_totales'] * 100) : 0;
                    @endphp
                    <article class="tarjeta flex flex-col">
                        <div class="tarjeta-franja"></div>
                        <div class="flex flex-1 flex-col p-6">
                            <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] {{ $proyecto['rol'] === 'Administrador' ? 'text-principal' : 'text-slate-500' }}">{{ $proyecto['rol'] }}</p>
                            <h2 class="titulo-seccion">{{ $proyecto['nombre'] }}</h2>
                            <p class="texto-suave mt-2 flex-1">{{ $proyecto['descripcion'] }}</p>

                            <div class="mt-6">
                                <div class="mb-1.5 flex items-center justify-between text-sm font-semibold text-slate-700">
                                    <span>Progreso</span>
                                    <span class="font-mono">{{ $porcentaje }}%</span>
                                </div>
                                <div class="progreso" role="progressbar" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100" aria-label="Progreso de {{ $proyecto['nombre'] }}">
                                    <div class="progreso-barra" style="width: {{ $porcentaje }}%"></div>
                                </div>
                                <p class="mt-3 text-[13px] text-slate-500"><span class="font-mono">{{ $proyecto['tareas_hechas'] }}</span> de <span class="font-mono">{{ $proyecto['tareas_totales'] }}</span> tareas hechas · <span class="font-mono">{{ $proyecto['miembros'] }}</span> miembros</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="tarjeta text-center">
                <div class="tarjeta-franja"></div>
                <div class="p-9">
                    <h2 class="titulo-seccion">Todavía no tienes proyectos</h2>
                    <p class="texto-suave mt-2">Crea tu primer proyecto para empezar a organizar tus tareas.</p>
                </div>
            </div>
        @endif

        <p class="text-center text-xs text-white/75">Organiza tu día. Avanza con claridad.</p>
    </main>
</body>
</html>
