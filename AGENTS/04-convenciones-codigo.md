# 04 · Convenciones de código

Reglas para que todo el código parezca escrito por la misma persona. Complementan las *Laravel Boost guidelines* de `CLAUDE.md` y `AGENTS.md` (raíz) y las skills de `.claude/skills/` (`laravel-best-practices`, `testing-best-practices`, `tailwindcss-development`). **Ante la duda, copia `ProyectosController`, `proyectos.blade.php` y `tests/Feature/ProyectosTest.php`.**

## Pila
Laravel 13 · PHP 8.5 · Blade · Tailwind CSS 4 (plugin de Vite) · Vite 8 · Pest · Pint · SQLite en local (`.env.example`; la BD de producción `[PENDENT]`).

## Nombres
- **Todo en castellano**, sin acentos ni eñes en nombres de archivos, clases y rutas (`proyectos`, no `projectes`/`projects`; `fecha_limite`, no `fechaLímite`). Los textos visibles al usuario sí llevan acentos.
- Controladores: `<Recurso en plural>Controller` (`ProyectosController`, `TareasController`); excepción ya existente: `RegistroController`.
- Vistas: `resources/views/<recurso>.blade.php` en minúsculas (`registro`, `proyectos`). Si un recurso necesita varias vistas, carpeta propia: `resources/views/proyectos/index.blade.php`, `.../crear.blade.php`.
- Rutas: URL en minúsculas y plural (`/proyectos`), **siempre con nombre** `recurso.accion` (`->name('proyectos.index')`) y enlaces con `route('proyectos.index')`.
- Modelos y migraciones: por la tarea «BD» de Albert y Arnaldo; nombres en singular en castellano (`Proyecto`, `Tarea`) y tablas en plural. `[PENDENT]` confirmar cuando exista el modelo relacional.
- Clases CSS propias: castellano, minúsculas con guiones (`.boton-principal`).

## Controladores
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class ProyectosController extends Controller
{
    public function index(): View
    {
        return view('proyectos', ['proyectos' => $proyectos]);
    }
}
```
- Créalos con `php artisan make:controller NombreController --no-interaction`.
- Un recurso, un controlador; métodos estándar (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`).
- Tipos de retorno y de parámetros explícitos; llaves siempre en los bloques de control.
- Sin lógica de negocio compleja en el controlador: cuando crezca, pasar a clases de acción/servicios.
- Los datos de ejemplo se marcan con un comentario y se sustituyen por Eloquent cuando exista la BD.

## Rutas (`routes/web.php`)
```php
Route::get('/proyectos', [ProyectosController::class, 'index'])->name('proyectos.index');
```
Una línea por ruta, con `use` del controlador arriba. No añadir rutas de prueba (`/saludos/{nombre?}` es una que sobra).

## Vistas Blade
- Esqueleto y fragmentos en `03-componentes.md`. `@fonts` y `@vite('resources/css/app.css')` siempre en el `<head>`.
- **Sin `<style>` ni hexadecimales**; clases del sistema de diseño (`devsprint.css`) y utilidades de Tailwind solo para maquetación (`flex`, `grid`, `gap-*`, `max-w-*`, `w-full`, márgenes).
- Escapado por defecto `{{ }}`; nunca `{!! !!}` con datos del usuario.
- Formularios: `@csrf`, `method`/`action` con `route()`, `old()` y `@error`.
- Estructura repetida → `@foreach`/`@forelse`; estado vacío siempre contemplado.
- Cuando se repita la misma estructura de `<html>` en 3 vistas, extraer un layout (`[PENDENT]`, ver `08`).

## Tests (Pest)
- Fichero por recurso: `tests/Feature/<Recurso>Test.php` (`ProyectosTest.php`). Crear con `php artisan make:test --pest NombreTest`.
- Títulos en castellano, en frase («la pagina de proyectos muestra un mensaje cuando no hay proyectos»).
- En pruebas de vistas: `$this->withoutVite();` para no depender del build.
- Cubrir como mínimo: la ruta responde, se ve el contenido con datos, se ve el estado vacío, y (cuando exista) permisos y validación.
- Ejecutar solo lo tuyo: `php artisan test --compact --filter=Proyectos`; antes de abrir un PR, `php artisan test --compact`.

## Formato
- `vendor/bin/pint --dirty --format agent` formatea **solo los archivos modificados**.
- ⚠ Pint reformatea el archivo entero. Si cambia líneas **que no has escrito tú** (p. ej. en `routes/web.php`), deshaz esos cambios y deja solo los tuyos: el código ajeno se toca únicamente cuando su dueño lo pide.
- Sangría de 4 espacios, UTF-8, fin de línea LF (`.editorconfig`).

## Compilar y probar en local
```bash
composer install && npm ci
cp .env.example .env && php artisan key:generate
touch database/database.sqlite && php artisan migrate
npm run build          # o npm run dev en otra terminal
php artisan serve      # http://127.0.0.1:8000
```
Si cambia el aspecto y no lo ves: `npm run build`. Si falla con *Unable to locate file in Vite manifest*: `npm run build`.

## Comentarios y documentación
- Comentarios solo cuando el motivo no es obvio (decisiones, datos de ejemplo pendientes de la BD).
- Documentación de equipo en esta carpeta; no crear otros `.md` sueltos sin acordarlo.

## Dependencias y estructura
- No instalar paquetes ni crear carpetas base nuevas sin avisar al equipo (lo pide `CLAUDE.md`).
- No tocar `composer.lock`/`package-lock.json` salvo que la tarea lo exija.
- No subir `.env`, `vendor/`, `node_modules/`, `public/build/` ni `database/database.sqlite` (ya están en `.gitignore`).
