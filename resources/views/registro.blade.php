<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    @vite('resources/css/app.css')
</head>
<body class="relative flex min-h-screen items-center justify-center overflow-x-hidden bg-[#1E293B] bg-[url('/images/imagenFondoRegistro.png')] bg-cover bg-center bg-no-repeat p-4 font-sans text-[#334155] sm:p-6">
    <div class="absolute inset-0 bg-[#0F172A]/65 backdrop-blur-[2px]"></div>

    <main class="relative w-full max-w-md">
        <div class="overflow-hidden rounded-2xl border border-white/60 bg-white/95 shadow-[0_24px_70px_rgba(15,23,42,0.3)] backdrop-blur-sm">
            <div class="h-1.5 bg-gradient-to-r from-[#FF6A3B] via-[#FF8A5B] to-[#FFB088]"></div>
            <div class="p-6 sm:p-9">
                <div class="mb-7 flex justify-center">
                    <div>
                        <img src="{{ asset('images/logoPrincipal.png') }}" alt="Logo de mi aplicación" class="block h-auto w-[190px] max-w-full">
                    </div>
                </div>

                <div class="mb-7">
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-[#FF6A3B]">Bienvenido</p>
                    <h1 class="text-3xl font-bold tracking-tight text-[#0F172A]">Crear cuenta</h1>
                    <p class="mt-2 text-sm leading-6 text-[#64748B]">Empieza a organizar tus tareas de forma sencilla y eficiente.</p>
                </div>

                <form class="space-y-4">
            @csrf

                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-semibold text-[#334155]">Nombre</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="name" required class="w-full rounded-xl border border-[#CBD5E1] bg-white px-4 py-3 text-[15px] text-[#1F2937] shadow-sm outline-none transition placeholder:text-[#94A3B8] hover:border-[#94A3B8] focus:border-[#FF6A3B] focus:ring-4 focus:ring-[#FF6A3B]/15">
                        @error('name') <div class="mt-1.5 text-[13px] font-medium text-[#E53E3E]">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-[#334155]">Correo electrónico</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required class="w-full rounded-xl border border-[#CBD5E1] bg-white px-4 py-3 text-[15px] text-[#1F2937] shadow-sm outline-none transition placeholder:text-[#94A3B8] hover:border-[#94A3B8] focus:border-[#FF6A3B] focus:ring-4 focus:ring-[#FF6A3B]/15">
                        @error('email') <div class="mt-1.5 text-[13px] font-medium text-[#E53E3E]">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-semibold text-[#334155]">Contraseña</label>
                        <input type="password" id="password" name="password" autocomplete="new-password" required class="w-full rounded-xl border border-[#CBD5E1] bg-white px-4 py-3 text-[15px] text-[#1F2937] shadow-sm outline-none transition placeholder:text-[#94A3B8] hover:border-[#94A3B8] focus:border-[#FF6A3B] focus:ring-4 focus:ring-[#FF6A3B]/15">
                        @error('password') <div class="mt-1.5 text-[13px] font-medium text-[#E53E3E]">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-[#334155]">Repetir contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required class="w-full rounded-xl border border-[#CBD5E1] bg-white px-4 py-3 text-[15px] text-[#1F2937] shadow-sm outline-none transition placeholder:text-[#94A3B8] hover:border-[#94A3B8] focus:border-[#FF6A3B] focus:ring-4 focus:ring-[#FF6A3B]/15">
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-[#FF6A3B] px-4 py-3.5 text-base font-bold text-white shadow-[0_8px_20px_rgba(255,106,59,0.25)] transition duration-200 hover:-translate-y-0.5 hover:bg-[#F45B2D] hover:shadow-[0_12px_24px_rgba(255,106,59,0.3)] focus:outline-none focus:ring-4 focus:ring-[#FF6A3B]/25 active:translate-y-0">Crear mi cuenta</button>
                </form>
            </div>
        </div>
        <p class="mt-5 text-center text-xs text-white/75">Organiza tu día. Avanza con claridad.</p>
    </main>
</body>
</html>