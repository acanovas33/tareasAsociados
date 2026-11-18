@php
    // Columnas fijas: siempre se muestran, haya datos o no
    $columnas = $estados->values();

    // Colores de cada columna: línea del encabezado, fondo y borde de la tarea, y contador
    $colores = [
        // Rojo
        ['linea' => 'border-red-500', 'tarjeta' => 'bg-red-300', 'contador' => 'bg-red-500 text-white'],
        // Naranja
        ['linea' => 'border-orange-500', 'tarjeta' => 'bg-orange-300', 'contador' => 'bg-orange-500 text-white'],
        // Verde boscoso
        ['linea' => 'border-[#228B22]', 'tarjeta' => 'bg-[#86C386]', 'contador' => 'bg-[#228B22] text-white'],
    ];
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $proyecto->nombre }} - DevSprint</title>
    {{-- Tailwind y sistema de diseño por Vite (el CDN de Tailwind pisaba los estilos de devsprint.css) --}}
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 font-sans text-slate-800">

    {{-- Cabecera --}}
    <header class="flex items-center justify-between bg-slate-900 px-8 py-4 shadow-md">
        <div class="flex items-center gap-4">
            <h1 class="text-3xl italic text-white">Dev<strong class="font-extrabold text-orange-500">Sprint</strong></h1>
            <span class="rounded-full bg-slate-700 px-4 py-1 text-sm font-semibold text-slate-100">
                {{ $proyecto->nombre }}
            </span>
        </div>

        <button type="button" data-abrir-modal="modal-crear-tarea"
            class="rounded-full bg-orange-500 px-5 py-2 text-sm font-semibold text-white hover:bg-orange-600">
            + Nueva tarea
        </button>
    </header>

    @if (session('success'))
        <p role="status" class="mx-2 mt-4 rounded-xl bg-white px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm">
            {{ session('success') }}
        </p>
    @endif

    {{-- Tablero --}}
    <main class="flex flex-col items-stretch gap-4 p-4 md:flex-row md:items-start">
        @foreach ($columnas as $i => $estado)
            @php
                $c = $colores[$i];
                $tareasColumna = $tareas[$estado->id] ?? [];
            @endphp

            <section class="min-w-0 flex-1">
                {{-- Título de la columna con el número de tareas y una línea de color debajo --}}
                <h2 class="mb-4 flex items-center justify-between border-b-4 {{ $c['linea'] }} px-1 pb-2 text-lg font-bold">
                    {{ $estado->nombre }}
                    <span class="rounded-full px-3 py-0.5 text-sm {{ $c['contador'] }}">
                        {{ count($tareasColumna) }}
                    </span>
                </h2>

                @foreach ($tareasColumna as $tarea)
                    <div class="mb-4 break-words rounded-2xl {{ $c['tarjeta'] }} p-4 shadow-sm hover:shadow-md">
                        {{-- Título --}}
                        <p class="text-base font-bold text-slate-900">{{ $tarea->nombre }}</p>

                        {{-- Descripción --}}
                        @if ($tarea->descripcion)
                            <p class="mt-1 text-sm text-slate-700">{{ $tarea->descripcion }}</p>
                        @endif

                        {{-- Usuarios asignados --}}
                        @if ($tarea->usuarios->isNotEmpty())
                            <div class="mt-3 flex flex-wrap items-center gap-1">
                                <span class="text-xs text-slate-700">Asignado a:</span>
                                @foreach ($tarea->usuarios as $usuario)
                                    <span class="rounded-full bg-white px-2 py-0.5 text-xs font-semibold text-slate-700">
                                        {{ $usuario->nombre }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Fechas --}}
                        <div class="mt-3 flex justify-between gap-2 border-t border-black/20 pt-2 text-xs text-slate-700">
                            <span>
                                Inicio:
                                <strong class="text-slate-900">
                                    {{ $tarea->fecha_inicio ? \Carbon\Carbon::parse($tarea->fecha_inicio)->format('d/m/Y') : '—' }}
                                </strong>
                            </span>
                            <span>
                                Fin:
                                <strong class="text-slate-900">
                                    {{ $tarea->fecha_limite ? \Carbon\Carbon::parse($tarea->fecha_limite)->format('d/m/Y') : '—' }}
                                </strong>
                            </span>
                        </div>
                    </div>
                @endforeach

                {{-- Mensaje si la columna no tiene tareas --}}
                @if (count($tareasColumna) == 0)
                    <p class="rounded-xl border-2 border-dashed border-slate-300 p-4 text-center text-sm text-slate-400">
                        No hay tareas
                    </p>
                @endif
            </section>
        @endforeach
    </main>

    {{-- Pop-up «Crear tarea» (componente x-modal-crear-tarea, ver AGENTS/03-componentes.md) --}}
    <x-modal-crear-tarea :proyecto="$proyecto->id" :estados="$estadosPopup" :usuarios="$usuariosPopup" />
</body>

</html>