
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevSprint - Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #eeeeef;
            font-family: 'Inter', sans-serif;
            padding: 20px;
            color: #151d30;
        }

        .contenedor {
            width: 100%;
            max-width: 450px;
        }

        .login {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0,0,0,0.08);
        }

        .linea {
            height: 7px;
            background: #ff693d;
        }

        .contenido {
            padding: 45px 38px;
        }

        .logo {
            text-align: center;
            color: #ff693d;
            font-size: 25px;
            font-weight: 800;
            margin-bottom: 65px;
        }

        .bienvenida {
            color: #ff693d;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        h1 {
            font-size: 29px;
            margin-bottom: 12px;
        }

        .descripcion {
            color: #718096;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .campo {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 9px;
            color: #344054;
        }

        input {
            width: 100%;
            height: 49px;
            padding: 0 14px;
            border: 1px solid #cbd5e1;
            border-radius: 11px;
            outline: none;
            font-size: 15px;
        }

        input:focus {
            border-color: #ff693d;
            box-shadow: 0 0 0 3px rgba(255,105,61,0.12);
        }

        .errores {
            color: #dc2626;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .exito {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 9px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .boton {
            width: 100%;
            height: 52px;
            background: #ff693d;
            border: none;
            border-radius: 11px;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.2s;
        }

        .boton:hover {
            background: #ed572e;
            transform: translateY(-2px);
        }

        .registro {
            text-align: center;
            margin-top: 30px;
            font-size: 13px;
            color: #718096;
        }

        .registro a {
            color: #ff693d;
            text-decoration: none;
            font-weight: 700;
        }

        .registro a:hover {
            text-decoration: underline;
        }

        .pie {
            text-align: center;
            color: #7b8493;
            font-size: 12px;
            margin-top: 20px;
        }

        @media (max-width: 480px) {
            .contenido {
                padding: 35px 25px;
            }
        }
    </style>
</head>

<body>

    <div class="contenedor">

        <div class="login">

            <div class="linea"></div>

            <div class="contenido">

                <div class="logo">➤ DevSprint</div>

                <p class="bienvenida">BIENVENIDO DE NUEVO</p>

                <h1>Iniciar sesión</h1>

                <p class="descripcion">
                    Accede a tu cuenta y continúa organizando tus tareas de forma sencilla y eficiente.
                </p>

                @if(session('success'))
                    <div class="exito">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="errores">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST">
                    @csrf

                    <div class="campo">
                        <label for="usuario">Usuario o correo electrónico</label>
                        <input
                            type="text"
                            id="usuario"
                            name="usuario"
                            value="{{ old('usuario') }}"
                            placeholder="Introduce tu usuario o correo"
                            required
                            autofocus
                        >
                    </div>

                    <div class="campo">
                        <label for="password">Contraseña</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Introduce tu contraseña"
                            required
                        >
                    </div>

                    <button type="submit" class="boton">
                        Iniciar sesión
                    </button>

                </form>

                <div class="registro">
                    ¿No tienes cuenta?
                    <a href="{{ url('/registro') }}">Regístrate aquí</a>
                </div>

            </div>

        </div>

        <p class="pie">Organiza tu día. Avanza con claridad.</p>

    </div>

</body>
</html>
