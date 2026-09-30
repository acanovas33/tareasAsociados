<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <style>
        :root {
            --principal:  #FF6A3B;
            --secundario: #E6E1DA;
            --destacado:  #111827;
            --alerta:     #E53E3E;
            --texto:      #1F2937;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--secundario);
            background-image: linear-gradient(rgba(230, 225, 218, 0.35), rgba(230, 225, 218, 0.35)), url('{{ asset('images/imagenFondoRegistro.png') }}');
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            color: var(--texto);
        }

        .card {
            background: #fff;
            width: 100%;
            max-width: 400px;
            padding: 32px;
            border-radius: 12px;
            border-top: 6px solid var(--principal);
            box-shadow: 0 4px 20px rgba(17, 24, 39, 0.1);
        }

        h1 {
            margin: 0 0 4px;
            color: var(--destacado);
        }

        .logo {
            display: block;
            width: 220px;
            max-width: 100%;
            height: auto;
            margin: 0 auto 24px;
        }

        .subtitulo { margin: 0 0 24px; font-size: 14px; }

        label {
            display: block;
            margin: 16px 0 6px;
            font-size: 14px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--secundario);
            border-radius: 8px;
            font-size: 15px;
            color: var(--texto);
        }

        input:focus {
            outline: none;
            border-color: var(--principal);
        }

        .error {
            color: var(--alerta);
            font-size: 13px;
            margin-top: 4px;
        }

        button {
            width: 100%;
            margin-top: 24px;
            padding: 12px;
            background: var(--principal);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('images/logoPrincipal.png') }}" alt="Logo de mi aplicación" class="logo">
        <h1>Crear cuenta</h1>
        <p class="subtitulo">Empieza a organizar tus tareas</p>

        <form>
            @csrf

            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name') <div class="error">{{ $message }}</div> @enderror

            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password">
            @error('password') <div class="error">{{ $message }}</div> @enderror

            <label for="password_confirmation">Repetir contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation">

            <button type="submit">Registrarme</button>
        </form>
    </div>
</body>
</html>