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
    {{-- Tailwind por CDN: no necesita Vite ni npm --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#ddd] font-sans">

    {{-- Cabecera --}}
    <header class="flex items-center gap-5 rounded-b-lg bg-[#ff6b3a] px-8 py-5">
        <h1 class="text-4xl italic text-neutral-800">Dev<strong class="font-extrabold">Sprint</strong></h1>
        <span class="text-lg font-semibold">{{ $proyecto->nombre }}</span>
    </header>

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

    {{-- Modal crear tarea --}}
    <div id="modal" class="fixed inset-0 z-10 hidden items-center justify-center bg-black/45">
        <form method="POST" action="#"
            class="w-[min(400px,90%)] rounded-[20px] border-[3px] border-black bg-white p-6">
            @csrf
            <h3 class="mb-4 text-lg font-bold">Nueva tarea</h3>
            <input type="text" name="titulo" placeholder="Título de la tarea" required
                class="w-full rounded-xl border-2 border-neutral-400 px-3 py-2 text-base focus:border-[#2f80ed] focus:outline-none">
            <div class="mt-4 flex justify-end gap-2">
                <button type="button" id="close-modal"
                    class="rounded-full bg-neutral-200 px-5 py-2 font-semibold hover:bg-neutral-300">Cancelar</button>
                <button type="submit"
                    class="rounded-full bg-[#2f80ed] px-5 py-2 font-semibold text-white hover:bg-[#2468c4]">Crear</button>
            </div>
        </form>
    </div>

    <script>
        const modal = document.getElementById('modal');
        const openBtn = document.getElementById('open-modal');
        const toggle = (open) => {
            modal.classList.toggle('hidden', !open);
            modal.classList.toggle('flex', open);
            if (open) modal.querySelector('input').focus();
        };
        if (openBtn) openBtn.onclick = () => toggle(true);
        document.getElementById('close-modal').onclick = () => toggle(false);
        modal.onclick = (e) => {
            if (e.target === modal) toggle(false);
        };
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') toggle(false);
        });
    </script>
</body>

</html>
