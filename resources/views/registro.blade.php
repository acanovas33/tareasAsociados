<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    @vite('resources/css/app.css')
</head>
<body class="flex min-h-screen items-center justify-center bg-[#E6E1DA] bg-[url('/images/imagenFondoRegistro.png')] bg-cover bg-center bg-no-repeat p-4 font-sans text-[#1F2937]">
    <div class="w-full max-w-md rounded-xl border-t-[6px] border-[#FF6A3B] bg-white p-8 shadow-[0_4px_20px_rgba(17,24,39,0.1)]">
        <img src="{{ asset('images/logoPrincipal.png') }}" alt="Logo de mi aplicación" class="mx-auto mb-6 block h-auto w-[220px] max-w-full">
        <h1 class="mb-1 text-2xl font-bold text-[#111827]">Crear cuenta</h1>
        <p class="mb-6 text-sm">Empieza a organizar tus tareas</p>

        <form>
            @csrf

            <label for="name" class="mb-1 mt-4 block text-sm font-bold">Nombre</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-[#E6E1DA] px-3 py-2.5 text-[15px] text-[#1F2937] outline-none focus:border-[#FF6A3B]">
            @error('name') <div class="mt-1 text-[13px] text-[#E53E3E]">{{ $message }}</div> @enderror

            <label for="email" class="mb-1 mt-4 block text-sm font-bold">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border border-[#E6E1DA] px-3 py-2.5 text-[15px] text-[#1F2937] outline-none focus:border-[#FF6A3B]">
            @error('email') <div class="mt-1 text-[13px] text-[#E53E3E]">{{ $message }}</div> @enderror

            <label for="password" class="mb-1 mt-4 block text-sm font-bold">Contraseña</label>
            <input type="password" id="password" name="password" class="w-full rounded-lg border border-[#E6E1DA] px-3 py-2.5 text-[15px] text-[#1F2937] outline-none focus:border-[#FF6A3B]">
            @error('password') <div class="mt-1 text-[13px] text-[#E53E3E]">{{ $message }}</div> @enderror

            <label for="password_confirmation" class="mb-1 mt-4 block text-sm font-bold">Repetir contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full rounded-lg border border-[#E6E1DA] px-3 py-2.5 text-[15px] text-[#1F2937] outline-none focus:border-[#FF6A3B]">

            <button type="submit" class="mt-6 w-full rounded-lg bg-[#FF6A3B] px-3 py-3 text-base font-bold text-white transition-opacity hover:opacity-90">Registrarme</button>
        </form>
    </div>
</body>
</html>