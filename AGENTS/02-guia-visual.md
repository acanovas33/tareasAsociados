# 02 · Guía visual

Cómo se traduce la identidad (`01`) en pantallas. Todo el CSS vive en **`resources/css/devsprint.css`**; los fragmentos listos para copiar están en `03-componentes.md`.

## Principios
1. **Claridad ante todo:** una pantalla, una idea. Poco ruido visual; el contenido se agrupa en tarjetas.
2. **Coherencia:** si dos pantallas muestran lo mismo, se ven igual. Misma tarjeta, misma franja, mismos botones.
3. **Naranja con intención:** guía la mirada hacia la acción principal; no se reparte por toda la página.
4. **Mobile first:** se diseña primero para 375 px y se amplía.

## Estructura de una pantalla
```
<body class="app-fondo">                 ← fondo con imagen + capa oscura + tipografía base
  <main class="mx-auto w-full max-w-… ">  ← contenido centrado
     .tarjeta  (con .tarjeta-franja arriba)
```
- **Pantallas de formulario** (registro, login): una sola `.tarjeta` centrada, `max-w-md`, centrada en vertical con `flex min-h-screen items-center justify-center` en el `<main>` o en un contenedor.
- **Pantallas de listado o panel** (proyectos): `max-w-5xl`, bloques separados con `space-y-6`; rejilla de tarjetas con `grid gap-6 sm:grid-cols-2 lg:grid-cols-3`.
- **Cabecera de página:** dentro de una `.tarjeta`: logo (150 px) → `.sobretitulo` → `.titulo-pagina` → `.texto-suave`; el botón de acción principal a la derecha en escritorio y a todo el ancho en móvil (`w-full sm:w-auto`).
- **Pie:** el lema «Organiza tu día. Avanza con claridad.» en `text-center text-xs text-white/75`.

## Tokens
| Necesito… | Uso |
|---|---|
| Naranja | `bg-principal`, `text-principal`, `border-principal`, `ring-principal` |
| Fondo neutro | `bg-secundario` |
| Negro de cabecera | `bg-destacado`, `text-destacado` |
| Error o bloqueo | `text-alerta`, `border-alerta`, `bg-alerta` |
| Texto principal | `text-texto` |
| Texto secundario | `text-slate-500` (clase `.texto-suave` para párrafos) |
| Fuentes | `font-sans` (por defecto), `font-display`, `font-mono` |

Con opacidad se pueden usar así: `bg-principal/15`, `ring-principal/25`.

## Espaciado y forma
- Esquinas: tarjetas, botones y campos `rounded-2xl` / `rounded-xl` (ya incluido en las clases). Barras de progreso `rounded-full`.
- Relleno de tarjetas: `p-6` (tarjetas de listado) o `.tarjeta-cuerpo` = `p-6 sm:p-9` (formularios y cabeceras).
- Separación vertical: `space-y-4` entre campos de un formulario; `space-y-6` entre bloques de página; `gap-6` en rejillas.
- Sombras y transparencias vienen en `.tarjeta` (no añadir otras).
- Animación: solo transiciones suaves de hover/foco ya incluidas; nada que parpadee ni se mueva solo.

## Tipografía en la práctica
| Elemento | Clase |
|---|---|
| Título de página (una por pantalla, `<h1>`) | `.titulo-pagina` |
| Título de tarjeta o sección (`<h2>`) | `.titulo-seccion` |
| Sobretítulo (etiqueta encima del título) | `.sobretitulo` |
| Párrafo de apoyo | `.texto-suave` |
| Texto de cuerpo | (sin clase: hereda `font-sans text-slate-700` de `.app-fondo`) |
| Fechas, contadores, horas, porcentajes | `font-mono` |
| Etiqueta de campo | `.etiqueta` |

Jerarquía: un único `<h1>` por página, `<h2>` para bloques, sin saltarse niveles.

## Estados de interfaz
- **Vacío:** tarjeta con `.titulo-seccion` («Todavía no tienes proyectos») + `.texto-suave` que explica el siguiente paso. Nunca una pantalla en blanco.
- **Error de campo:** `.campo-error` debajo del campo, en castellano y diciendo cómo arreglarlo.
- **Cargando / éxito:** `[PENDENT]` (no definido todavía; ver `08`).
- **Bloqueado / a punto de vencer:** `alerta` + texto o icono; **nunca solo color** (ver accesibilidad).
- **Tareas por estado y tipo de tarea:** el brief exige que los tipos de tarea se distingan por color **o icono**; la paleta de estos colores `[PENDENT]` (ver `08`). Hasta entonces, usar los tokens existentes y añadir siempre texto o icono.

## Accesibilidad (requisito del proyecto)
- Contraste: texto `text-texto` sobre blanco o `secundario` cumple WCAG AA. **Atención al texto blanco sobre el naranja:** ronda 2,9:1 (por debajo de 3:1). Las vistas existentes lo usan en `.boton-principal`; `[PENDENT]` decidir si pasa a `text-destacado` (≈ 6:1) — ver `08`.
- **Nunca comunicar solo con color:** acompañar siempre con texto o icono.
- Todos los campos con `<label for>`; `autocomplete` adecuado (`email`, `name`, `new-password`, `current-password`).
- Foco visible en todo elemento interactivo (ya incluido en `.campo` y `.boton-principal`).
- Imágenes con `alt` descriptivo; decorativas con `alt=""`.
- Barras de progreso con `role="progressbar"`, `aria-valuenow/min/max` y `aria-label`.
- `<html lang="es">`.
- Objetivos táctiles de al menos 44 px de alto en móvil (los botones y campos ya lo cumplen con `py-3`/`py-3.5`).

## Responsive
- Breakpoints de Tailwind: base (móvil) → `sm` (≥ 640 px) → `lg` (≥ 1024 px).
- La rejilla de proyectos: 1 columna en móvil, 2 en `sm`, 3 en `lg`.
- Los botones principales ocupan todo el ancho en móvil.
- Probar siempre a 375 px y a ≥ 1280 px; no debe haber scroll horizontal de página.

## Prohibido
- `<style>` o `style="color:…"` con colores; hexadecimales en el HTML (`bg-[#FF6A3B]`): usar tokens.
- Fuentes distintas de las tres del manual; tamaños de fuente en píxeles sueltos para títulos (usar las clases).
- Otras sombras, gradientes o colores de marca inventados.
- Copiar cadenas largas de utilidades de otra vista en lugar de usar la clase de componente.
- Texto de interfaz en inglés o catalán, o la marca «ChatGPT y asociados» como nombre del producto.
