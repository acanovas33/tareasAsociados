<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DevSprint - Login</title>
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
                        <img src="{{ asset('images/logoPrincipal.png') }}"
                             alt="Logo de mi aplicación"
                             class="block h-auto w-[190px] max-w-full">
                    </div>
                </div>

                <div class="mb-7">
                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.2em] text-[#FF6A3B]">
                        Bienvenido de nuevo
                    </p>

                    <h1 class="text-3xl font-bold tracking-tight text-[#0F172A]">
                        Iniciar sesión
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-[#64748B]">
                        Accede a tu cuenta y continúa organizando tus tareas de forma sencilla y eficiente.
                    </p>
                </div>

                @if(session('success'))
                    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[13px] font-medium text-red-600">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="usuario" class="mb-1.5 block text-sm font-semibold text-[#334155]">
                            Usuario o correo electrónico
                        </label>

                        <input
                            type="text"
                            id="usuario"
                            name="usuario"
                            value="{{ old('usuario') }}"
                            placeholder="Introduce tu usuario o correo"
                            autocomplete="username"
                            required
                            autofocus
                            class="w-full rounded-xl border border-[#CBD5E1] bg-white px-4 py-3 text-[15px] text-[#1F2937] shadow-sm outline-none transition placeholder:text-[#94A3B8] hover:border-[#94A3B8] focus:border-[#FF6A3B] focus:ring-4 focus:ring-[#FF6A3B]/15"
                        >
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-semibold text-[#334155]">
                            Contraseña
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Introduce tu contraseña"
                            autocomplete="current-password"
                            required
                            class="w-full rounded-xl border border-[#CBD5E1] bg-white px-4 py-3 text-[15px] text-[#1F2937] shadow-sm outline-none transition placeholder:text-[#94A3B8] hover:border-[#94A3B8] focus:border-[#FF6A3B] focus:ring-4 focus:ring-[#FF6A3B]/15"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-[#FF6A3B] px-4 py-3.5 text-base font-bold text-white shadow-[0_8px_20px_rgba(255,106,59,0.25)] transition duration-200 hover:-translate-y-0.5 hover:bg-[#F45B2D] hover:shadow-[0_12px_24px_rgba(255,106,59,0.3)] focus:outline-none focus:ring-4 focus:ring-[#FF6A3B]/25 active:translate-y-0"
                    >
                        Iniciar sesión
                    </button>

                </form>

                <div class="mt-7 text-center text-sm text-[#64748B]">
                    ¿No tienes cuenta?
                    <a href="{{ url('/registro') }}"
                       class="font-bold text-[#FF6A3B] transition hover:text-[#F45B2D] hover:underline">
                        Regístrate aquí
                    </a>
                </div>

            </div>
        </div>

        <p class="mt-5 text-center text-xs text-white/75">
            Organiza tu día. Avanza con claridad.
        </p>

    </main>

</body>
</html>