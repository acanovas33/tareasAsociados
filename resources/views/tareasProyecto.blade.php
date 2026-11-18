@php
    // Columnas fijas: siempre se muestran, haya datos o no
    $columnas = $estados->values();
    $colores = [
        ['bg' => 'bg-[#7fe5dc]', 'task' => 'bg-[#7fe5dc] border-2 border-[#2f9bec]'],
        ['bg' => 'bg-[#fbb14e]', 'task' => 'bg-[#fbb14e]'],
        ['bg' => 'bg-[#a5e96a]', 'task' => 'bg-[#a5e96a]'],
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

<body class="min-h-screen bg-[#ddd] font-sans">

    {{-- Cabecera --}}
    <header class="flex items-center gap-5 rounded-b-lg bg-[#ff6b3a] px-8 py-5">
        <h1 class="text-4xl italic text-neutral-800">Dev<strong class="font-extrabold">Sprint</strong></h1>
        <span class="text-lg font-semibold">{{ $proyecto->nombre }}</span>
        <button type="button" class="boton-secundario ml-auto py-2" data-abrir-modal="modal-crear-tarea">+ Nueva tarea</button>
    </header>

    @if (session('success'))
        <p role="status" class="mx-2 mt-4 rounded-xl bg-white px-4 py-3 text-sm font-semibold text-slate-800 shadow-sm">
            {{ session('success') }}
        </p>
    @endif

    {{-- Tablero --}}
    <main class="flex flex-col items-stretch gap-2 px-2 py-5 md:flex-row md:items-start">
        @foreach ($columnas as $i => $estado)
            @php
                $c = $colores[$i];
                $tareasColumna = $tareas[$estado->id] ?? [];
            @endphp

            <section class="min-w-0 flex-1">
                <h2
                    class="{{ $c['bg'] }} mb-4 rounded-t-2xl border-[3px] border-black pb-10 pt-6 text-center text-xl font-bold">
                    {{ $estado->nombre }}
                </h2>

                @foreach ($tareasColumna as $tarea)
                    <div class="{{ $c['task'] }} mb-6 break-words rounded-2xl px-4 py-3 text-white">
                        <p class="text-center font-semibold">{{ $tarea->nombre }}</p>

                        <div class="mt-2 flex items-end justify-between gap-2">
                            <p class="text-sm">{{ $tarea->descripcion }}</p>

                            @if ($tarea->usuarios->isNotEmpty())
                                <p class="text-xs font-semibold">
                                    Asignado a: {{ $tarea->usuarios->pluck('nombre')->join(', ') }}
                                </p>
                            @endif
                        </div>

                        <div
                            class="mt-3 flex justify-between gap-2 border-t border-white/50 pt-2 text-xs font-semibold">
                            <span>
                                Inicio:
                                {{ $tarea->fecha_inicio ? \Carbon\Carbon::parse($tarea->fecha_inicio)->format('d/m/Y') : '—' }}
                            </span>
                            <span>
                                Fin:
                                {{ $tarea->fecha_limite ? \Carbon\Carbon::parse($tarea->fecha_limite)->format('d/m/Y') : '—' }}
                            </span>
                        </div>
                    </div>
                @endforeach
                </div>
            </section>
        @endforeach
    </main>

    {{-- Pop-up «Crear tarea» (componente x-modal-crear-tarea, ver AGENTS/03-componentes.md) --}}
    <x-modal-crear-tarea :proyecto="$proyecto->id" :estados="$estadosPopup" :usuarios="$usuariosPopup" />
</body>

</html>
