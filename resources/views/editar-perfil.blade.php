<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar perfil | DevSprint</title>

    @fonts
    @vite('resources/css/app.css')
</head>

<body class="app-fondo min-h-screen">

    <main class="mx-auto w-full max-w-3xl space-y-6 px-4 py-8 sm:px-6">

        {{-- Cabecera --}}
        <div class="tarjeta">
            <div class="tarjeta-franja"></div>

            <div class="tarjeta-cuerpo p-6 sm:p-8">

                <a href="{{ url()->previous() }}" class="mb-6 inline-block text-sm font-semibold text-slate-600 hover:text-slate-900">
                    ← Volver
                </a>

                <img
                    src="{{ asset('images/logoPrincipal.png') }}"
                    alt="Logo de DevSprint"
                    class="mb-6 block h-auto w-[150px] max-w-full"
                >

                <p class="sobretitulo mb-2">Configuración de cuenta</p>

                <h1 class="titulo-pagina">Editar perfil</h1>

                <p class="texto-suave mt-2">
                    Actualiza tus datos personales y mantén tu cuenta al día.
                </p>

            </div>
        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div role="status" class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Errores generales --}}
        @if ($errors->any())
            <div role="alert" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-bold">No se han podido guardar los cambios.</p>
                <p class="mt-1">Revisa los campos marcados y vuelve a intentarlo.</p>
            </div>
        @endif

        {{-- Formulario de perfil --}}
        <section class="tarjeta">

            <div class="tarjeta-franja"></div>

            <div class="p-6 sm:p-8">

                <div class="mb-6">
                    <h2 class="titulo-seccion">Información personal</h2>
                    <p class="texto-suave mt-1">
                        Modifica tu nombre y tu correo electrónico.
                    </p>
                </div>

                <form action="{{ route('perfil.update') }}" method="POST" class="space-y-5">

                    @csrf
                    @method('PUT')

                    {{-- Nombre --}}
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                            Nombre completo
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', auth()->user()?->name ?? 'Usuario de prueba') }}"
                            autocomplete="name"
                            required
                            maxlength="255"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                        >

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Correo --}}
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                            Correo electrónico
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', auth()->user()?->email ?? 'usuario@devsprint.com') }}"
                            autocomplete="email"
                            required
                            maxlength="255"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                        >

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                        <a
                            href="{{ url()->previous() }}"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-100"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="boton-principal w-full sm:w-auto"
                        >
                            Guardar cambios
                        </button>

                    </div>

                </form>

            </div>
        </section>

        {{-- Formulario de contraseña --}}
        <section class="tarjeta">

            <div class="tarjeta-franja"></div>

            <div class="p-6 sm:p-8">

                <div class="mb-6">
                    <h2 class="titulo-seccion">Cambiar contraseña</h2>
                    <p class="texto-suave mt-1">
                        Utiliza una contraseña segura para proteger tu cuenta.
                    </p>
                </div>

                <form action="{{ route('perfil.password.update') }}" method="POST" class="space-y-5">

                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="mb-2 block text-sm font-semibold text-slate-700">
                            Contraseña actual
                        </label>

                        <input
                            type="password"
                            id="current_password"
                            name="current_password"
                            autocomplete="current-password"
                            required
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                        >

                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
                            Nueva contraseña
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="new-password"
                            required
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                        >

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">
                            Confirmar nueva contraseña
                        </label>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            autocomplete="new-password"
                            required
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-800 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                        >
                    </div>

                    <div class="flex justify-end border-t border-slate-200 pt-6">
                        <button
                            type="submit"
                            class="boton-principal w-full sm:w-auto"
                        >
                            Actualizar contraseña
                        </button>
                    </div>

                </form>

            </div>
        </section>

        <p class="text-center text-xs text-slate-500">
            DevSprint · Organiza tu día. Avanza con claridad.
        </p>

    </main>

</body>
</html>