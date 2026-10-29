# 03 · Componentes

Catálogo de las clases de `resources/css/devsprint.css` con fragmentos de Blade listos para copiar. **Si una pieza no está aquí ni en el CSS y se va a repetir, créala en `devsprint.css`, documéntala en este archivo y úsala desde la vista.**

> **Verlos en pantalla:** con la aplicación en local, abre **`/guia-estilos`** (`php artisan serve` → http://127.0.0.1:8000/guia-estilos). Muestra todos estos componentes funcionando. Solo está disponible en entorno local. Al añadir un componente, añádelo también a `resources/views/guia-estilos.blade.php`.

## Plantilla base de una vista
```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Título de la página</title>
    @fonts
    @vite('resources/css/app.css')
</head>
<body class="app-fondo">
    <main class="mx-auto w-full max-w-5xl space-y-6">
        {{-- tarjetas --}}
    </main>
</body>
</html>
```
`@fonts` es imprescindible (carga Inter, Plus Jakarta Sans y JetBrains Mono). Para pantallas de formulario centradas, `<main class="mx-auto flex min-h-[calc(100vh-3rem)] w-full max-w-md items-center">`.
Referencia viva: `resources/views/proyectos.blade.php`. `[PENDENT]` extraer un layout común (ver `08`).

## Catálogo
| Clase | Qué es | Notas |
|---|---|---|
| `.app-fondo` | `<body>`: imagen de fondo + capa oscura + fuente base | Una vez por página |
| `.tarjeta` | Contenedor blanco translúcido con sombra | Primer hijo: `.tarjeta-franja` |
| `.tarjeta-franja` | Franja naranja superior de 6 px | Solo dentro de `.tarjeta` |
| `.tarjeta-cuerpo` | Relleno interior `p-6 sm:p-9` | Formularios y cabeceras |
| `.sobretitulo` | Etiqueta naranja en mayúsculas | Encima del título; añadir `mb-2` |
| `.titulo-pagina` | `<h1>` en Inter | Uno por página |
| `.titulo-seccion` | `<h2>` en Inter | Títulos de tarjeta |
| `.texto-suave` | Párrafo secundario gris | Añadir `mt-2` si va tras un título |
| `.etiqueta` | `<label>` de campo | |
| `.campo` | `<input>` de texto, correo, contraseña… | Foco naranja |
| `.campo-error` | Mensaje de error de campo (rojo) | |
| `.boton-principal` | Botón naranja de acción | Añadir `w-full` o `w-full sm:w-auto` |
| `.codigo` | Nombre de clase o código dentro de un texto | Solo guía de estilos y documentación en pantalla |
| `.progreso` + `.progreso-barra` | Barra de progreso | Ancho de la barra con `style="width: N%"` (valor dinámico) |

## Tarjeta de cabecera de página
```blade
<div class="tarjeta">
    <div class="tarjeta-franja"></div>
    <div class="tarjeta-cuerpo flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <img src="{{ asset('images/logoPrincipal.png') }}" alt="Logo de DevSprint" class="mb-6 block h-auto w-[150px] max-w-full">
            <p class="sobretitulo mb-2">Tu espacio</p>
            <h1 class="titulo-pagina">Mis proyectos</h1>
            <p class="texto-suave mt-2">Texto de apoyo breve.</p>
        </div>
        <button type="button" class="boton-principal w-full sm:w-auto">Nuevo proyecto</button>
    </div>
</div>
```

## Formulario (tarjeta de registro / login)
```blade
<main class="mx-auto flex min-h-[calc(100vh-3rem)] w-full max-w-md items-center">
    <div class="tarjeta w-full">
        <div class="tarjeta-franja"></div>
        <div class="tarjeta-cuerpo">
            <img src="{{ asset('images/logoPrincipal.png') }}" alt="Logo de DevSprint" class="mx-auto mb-7 block h-auto w-[190px] max-w-full">
            <p class="sobretitulo mb-2">Bienvenido</p>
            <h1 class="titulo-pagina">Crear cuenta</h1>
            <p class="texto-suave mt-2">Empieza a organizar tus tareas de forma sencilla.</p>

            <form method="POST" action="{{ route('registro.store') }}" class="mt-7 space-y-4">
                @csrf

                <div>
                    <label for="email" class="etiqueta">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required class="campo">
                    @error('email') <div class="campo-error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="boton-principal w-full">Crear mi cuenta</button>
            </form>
        </div>
    </div>
</main>
```
(La ruta `registro.store` es de ejemplo; la define quien haga el registro. Un campo = un `<div>` con `.etiqueta`, `.campo` y `@error`.)

## Rejilla de tarjetas con datos
```blade
<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($proyectos as $proyecto)
        <article class="tarjeta flex flex-col">
            <div class="tarjeta-franja"></div>
            <div class="flex flex-1 flex-col p-6">
                <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">{{ $proyecto['rol'] }}</p>
                <h2 class="titulo-seccion">{{ $proyecto['nombre'] }}</h2>
                <p class="texto-suave mt-2 flex-1">{{ $proyecto['descripcion'] }}</p>
                {{-- bloque inferior: progreso, fechas… --}}
            </div>
        </article>
    @endforeach
</div>
```

## Barra de progreso
```blade
<div class="mb-1.5 flex items-center justify-between text-sm font-semibold text-slate-700">
    <span>Progreso</span>
    <span class="font-mono">{{ $porcentaje }}%</span>
</div>
<div class="progreso" role="progressbar" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100" aria-label="Progreso de {{ $proyecto['nombre'] }}">
    <div class="progreso-barra" style="width: {{ $porcentaje }}%"></div>
</div>
```

## Datos variables (fuente monoespaciada)
```blade
<p class="text-[13px] text-slate-500">
    <span class="font-mono">{{ $hechas }}</span> de <span class="font-mono">{{ $total }}</span> tareas hechas ·
    entrega <span class="font-mono">{{ $tarea->fecha_limite->format('d/m/Y') }}</span>
</p>
```
Regla: fechas límite, contadores, estimación de horas y porcentajes en `font-mono`; el resto del texto no.

## Estado vacío
```blade
<div class="tarjeta text-center">
    <div class="tarjeta-franja"></div>
    <div class="p-9">
        <h2 class="titulo-seccion">Todavía no tienes proyectos</h2>
        <p class="texto-suave mt-2">Crea tu primer proyecto para empezar a organizar tus tareas.</p>
    </div>
</div>
```

## Alerta (bloqueo, plazo, error crítico)
Aún no hay componente propio (`[PENDENT]`, ver `08`). Mientras tanto, patrón provisional:
```blade
<p class="text-sm font-semibold text-alerta">⚠ Tarea bloqueada: falta aprobar el diseño.</p>
```
Siempre con texto o icono además del color.

## Cómo añadir un componente nuevo
1. Escribe la clase en `resources/css/devsprint.css`, dentro de `@layer components`, con `@apply` y **solo tokens del manual** (más `slate` para neutros).
2. Nombre en castellano, en minúsculas y con guiones (`.insignia-estado`, `.menu-lateral`).
3. Añádelo a la tabla de este archivo con su fragmento de ejemplo.
4. Úsalo en la vista, ejecuta `npm run build` (o deja `npm run dev` abierto: Tailwind solo genera las utilidades que encuentra al compilar) y comprueba escritorio y móvil.
5. Avisa al equipo en el PR/commit: `devsprint.css` es compartido.
