<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis proyectos</title>
    @fonts
    @vite('resources/css/app.css')
</head>
<body class="relative min-h-screen overflow-x-hidden bg-[#1E293B] bg-[url('/images/imagenFondoRegistro.png')] bg-cover bg-fixed bg-center bg-no-repeat p-4 font-sans text-[#334155] sm:p-6">
    <div class="fixed inset-0 bg-[#0F172A]/65 backdrop-blur-[2px]"></div>

    <main class="relative mx-auto w-full max-w-5xl space-y-6">
        <div class="overflow-hidden rounded-2xl border border-white/60 bg-white/95 shadow-[0_24px_70px_rgba(15,23,42,0.3)] backdrop-blur-sm">
            <div class="h-1.5 bg-gradient-to-r from-[#FF6A3B] via-[#FF8A5B] to-[#FFB088]"></div>
            <div class="flex flex-col gap-6 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-9">
                <div>
                    <img src="{{ asset('images/logoPrincipal.png') }}" alt="Logo de mi aplicación" class="mb-6 block h-auto w-[150px] max-w-full">
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-[#FF6A3B]">Tu espacio</p>
                    <h1 class="font-display text-3xl font-bold tracking-tight text-[#0F172A]">Mis proyectos</h1>
                    <p class="mt-2 text-sm leading-6 text-[#64748B]">Aquí están todos los proyectos en los que colaboras.</p>
                </div>

                <button type="button" class="w-full rounded-xl bg-[#FF6A3B] px-6 py-3.5 text-base font-bold text-white shadow-[0_8px_20px_rgba(255,106,59,0.25)] transition duration-200 hover:-translate-y-0.5 hover:bg-[#F45B2D] hover:shadow-[0_12px_24px_rgba(255,106,59,0.3)] focus:outline-none focus:ring-4 focus:ring-[#FF6A3B]/25 active:translate-y-0 sm:w-auto">Nuevo proyecto</button>
            </div>
        </div>

        @if (count($proyectos) > 0)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($proyectos as $proyecto)
                    @php
                        $porcentaje = $proyecto['tareas_totales'] > 0 ? round($proyecto['tareas_hechas'] / $proyecto['tareas_totales'] * 100) : 0;
                    @endphp
                    <article class="flex flex-col overflow-hidden rounded-2xl border border-white/60 bg-white/95 shadow-[0_24px_70px_rgba(15,23,42,0.3)] backdrop-blur-sm">
                        <div class="h-1.5 bg-gradient-to-r from-[#FF6A3B] via-[#FF8A5B] to-[#FFB088]"></div>
                        <div class="flex flex-1 flex-col p-6">
                            <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] {{ $proyecto['rol'] === 'Administrador' ? 'text-[#FF6A3B]' : 'text-[#64748B]' }}">{{ $proyecto['rol'] }}</p>
                            <h2 class="font-display text-xl font-bold tracking-tight text-[#0F172A]">{{ $proyecto['nombre'] }}</h2>
                            <p class="mt-2 flex-1 text-sm leading-6 text-[#64748B]">{{ $proyecto['descripcion'] }}</p>

                            <div class="mt-6">
                                <div class="mb-1.5 flex items-center justify-between text-sm font-semibold text-[#334155]">
                                    <span>Progreso</span>
                                    <span class="font-mono">{{ $porcentaje }}%</span>
                                </div>
                                <div class="h-2 overflow-hidden rounded-full bg-[#E2E8F0]" role="progressbar" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100" aria-label="Progreso de {{ $proyecto['nombre'] }}">
                                    <div class="h-full rounded-full bg-gradient-to-r from-[#FF6A3B] to-[#FFB088]" style="width: {{ $porcentaje }}%"></div>
                                </div>
                                <p class="mt-3 text-[13px] text-[#64748B]"><span class="font-mono">{{ $proyecto['tareas_hechas'] }}</span> de <span class="font-mono">{{ $proyecto['tareas_totales'] }}</span> tareas hechas · <span class="font-mono">{{ $proyecto['miembros'] }}</span> miembros</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="overflow-hidden rounded-2xl border border-white/60 bg-white/95 text-center shadow-[0_24px_70px_rgba(15,23,42,0.3)] backdrop-blur-sm">
                <div class="h-1.5 bg-gradient-to-r from-[#FF6A3B] via-[#FF8A5B] to-[#FFB088]"></div>
                <div class="p-9">
                    <h2 class="font-display text-xl font-bold tracking-tight text-[#0F172A]">Todavía no tienes proyectos</h2>
                    <p class="mt-2 text-sm leading-6 text-[#64748B]">Crea tu primer proyecto para empezar a organizar tus tareas.</p>
                </div>
            </div>
        @endif

        <p class="text-center text-xs text-white/75">Organiza tu día. Avanza con claridad.</p>
    </main>
</body>
</html>
