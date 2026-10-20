# 01 · Identidad y marca

Resumen operativo del *Manual d'identitat corporativa — PROJ* (8 diapositivas; índice: moodboard, misión/visión/valores, logo, paleta, tipografías, maquetación). Si este resumen y el manual discrepan, **manda el manual** y se corrige aquí.

## Marca
- **Nombre en la aplicación: DevSprint.** Es el logotipo del manual y lo que ve el usuario (cabecera, `<title>`, textos, alt de imágenes: «Logo de DevSprint»).
- «ChatGPT y asociados» es el nombre del equipo/empresa ficticia (decisión del 22/09/2026). Puede aparecer en créditos o pie de página, no como nombre del producto.
- Público: estudiantes y equipos de desarrollo que necesitan organizar proyectos académicos y extracurriculares.

## Misión, visión y valores
- **Misión:** facilitar la gestión y organización de proyectos, tareas y equipos con una herramienta digital intuitiva, accesible y eficiente; reducir la desorganización y el estrés.
- **Visión:** ser una herramienta de referencia para estudiantes y equipos de desarrollo; convertir la complejidad de los proyectos en procesos claros, controlables y fáciles de seguir.
- **Valores:** organización, colaboración, eficiencia e innovación (manual) · claridad, colaboración y profesionalidad (acuerdo del equipo, 29/09).
- **Lema ya usado en la interfaz:** «Organiza tu día. Avanza con claridad.»

## Tono de los textos
- Castellano, tuteando («Crea tu primer proyecto», «Empieza a organizar tus tareas»).
- Frases cortas, claras y positivas; sin tecnicismos ni jerga; sin culpar al usuario en los errores («Revisa el correo», no «Correo incorrecto, inténtalo bien»).
- Botones con verbo: «Crear mi cuenta», «Nuevo proyecto», «Guardar».
- El manual está en catalán, pero **la interfaz va en castellano** (decisión del 20/10/2026).

## Paleta (única permitida)
| Token Tailwind | Nombre | HEX | Úsalo para | No lo uses para |
|---|---|---|---|---|
| `principal` | Naranja dinámico / acción | `#FF6A3B` | Logotipo, botones de acción principal, énfasis de marca (sobretítulos, barras de progreso, franja de tarjeta) | Fondos grandes ni texto largo |
| `secundario` | Cendra suau | `#E6E1DA` | Fondo neutro de la interfaz, superficies suaves | Texto |
| `destacado` | Negro limpio / IDE | `#111827` | Cabeceras principales, elementos de control oscuros | Fondos extensos de contenido |
| `alerta` | Rojo alerta | `#E53E3E` | Errores, tareas bloqueadas, plazos a punto de vencer | Decoración |
| `texto` | Gris antracita | `#1F2937` | Cuerpo de texto y descripciones | — |

Reglas de color del manual:
- **El naranja es la llamada a la acción.** Un botón naranja por pantalla (el de la acción principal: «Crear tarea», «Guardar»…).
- **El rojo solo comunica problema** (error, bloqueo, plazo). Si no es un problema, no es rojo.
- Texto sobre claro: `texto`. Alto contraste sobre fondos claros sin usar negro puro.
- Variantes del naranja (`principal-oscuro`, `principal-claro`, `principal-suave`) **no están en el manual**: se usan solo para estado hover y degradados ya existentes.
- **Neutros de apoyo:** para grises (texto secundario, bordes, pistas) se usa la paleta `slate` de Tailwind (`text-slate-500`, `border-slate-300`…), como en las vistas existentes. `[PENDENT]` normalizarlos con Arnaldo (ver `08`).

## Tipografías
| Papel | Fuente | Clase | Dónde |
|---|---|---|---|
| Primaria | **Inter** | `font-display` | Títulos de página y de sección (dashboard, landing) |
| Secundaria | **Plus Jakarta Sans** | `font-sans` (por defecto en todo el `<body>`) | Texto, instrucciones, formularios, descripciones de tareas; buena lectura en móvil |
| Terciaria | **JetBrains Mono** | `font-mono` | **Solo datos variables:** contadores, fechas límite, horas estimadas, porcentajes, recuentos |

Las fuentes se declaran en `vite.config.js` (plugin `bunny`, se descargan al compilar con `npm run build`) y se cargan con la directiva `@fonts` en el `<head>`. **Sin `@fonts` la vista cae a la fuente del sistema.**

## Logotipo
- Logosímbolo «DevSprint»: pila de tarjetas (organización) + línea ascendente (progreso) + flecha a la derecha (agilidad, entregas/sprints). Naranja `#FF6A3B`; versiones en blanco y negro sobre fondo neutro.
- Archivo en el código: `public/images/logoPrincipal.png` (PNG transparente con margen alrededor). Usar con `class="block h-auto w-[150px] max-w-full"` (tarjeta de cabecera) o `w-[190px]` (formularios). Alt: `Logo de DevSprint`.
- No deformar, no recolorear, no añadir sombras ni efectos. Versión de referencia en [`referencias/logo-devsprint-1.png`](referencias/logo-devsprint-1.png).
- Imagen de fondo de las pantallas con capa oscura: `public/images/imagenFondoRegistro.png` (la aplica `.app-fondo`).

## Maquetación del manual
Wireframes en [`referencias/`](referencias/): `wireframe-login.png`, `wireframe-signup.png`, `wireframe-inici.png`. Detalle y estado de cada pantalla en `07-pantallas.md`.
