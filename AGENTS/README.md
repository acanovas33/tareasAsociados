# AGENTS · guía para los agentes del equipo DevSprint

Esta carpeta es el **contexto compartido** de todos los agentes de IA del equipo (Claude Code, Codex, Cursor, Gemini…) y de las personas que trabajan con ellos. Sirve para que cada miembro, aunque use un agente distinto y trabaje en una pantalla distinta, **diseñe y estructure igual**: mismo aspecto, mismo código, mismas reglas. El aspecto sale del *Manual d'identitat corporativa* del equipo; aquí está traducido a clases y reglas que se pueden aplicar sin interpretar.

> **Antes de crear o tocar cualquier vista, lee este índice, `01-identidad-y-marca.md` y `02-guia-visual.md`.** Si vas a escribir HTML/Blade, lee también `03-componentes.md`.

## Índice
| Archivo | Para qué sirve |
|---|---|
| [`01-identidad-y-marca.md`](01-identidad-y-marca.md) | Marca, tono, paleta, tipografías y logotipo (resumen del manual) |
| [`02-guia-visual.md`](02-guia-visual.md) | Cómo se aplica la identidad: tokens, layout, espaciado, responsive, accesibilidad |
| [`03-componentes.md`](03-componentes.md) | Catálogo de clases y fragmentos de Blade listos para copiar |
| [`04-convenciones-codigo.md`](04-convenciones-codigo.md) | Laravel, Blade, rutas, controladores, tests y formato |
| [`05-producto-y-requisitos.md`](05-producto-y-requisitos.md) | Qué es la aplicación, requisitos obligatorios, roles, estados y glosario |
| [`06-flujo-de-trabajo.md`](06-flujo-de-trabajo.md) | Equipo, Airtable, sprints, Git y qué puede (y no) hacer un agente |
| [`07-pantallas.md`](07-pantallas.md) | Inventario de vistas, quién hace cada una y sus wireframes |
| [`08-decisiones-y-pendientes.md`](08-decisiones-y-pendientes.md) | Decisiones tomadas y dudas abiertas (`[PENDENT]`) |
| [`referencias/`](referencias/) | Wireframes y logotipo del manual |

## El sistema de diseño, en una línea
`resources/css/devsprint.css` contiene **todos** los colores, fuentes y componentes. Las vistas **no** llevan `<style>`, ni colores hexadecimales sueltos, ni cadenas largas de utilidades copiadas de otra vista: usan los tokens (`bg-principal`, `text-texto`, `font-display`…) y las clases de componente (`.tarjeta`, `.campo`, `.boton-principal`…).

**Ver todos los componentes en pantalla:** ruta `/guia-estilos` (solo en local).

## Reglas de oro (valen para todos los agentes)
1. **Diseño = manual de identidad.** Colores, tipografías y logotipo salen de `01-identidad-y-marca.md`. No inventes colores ni fuentes.
2. **Usa lo que ya existe.** Antes de escribir estilos, busca la clase en `devsprint.css` / `03-componentes.md`. Si falta una pieza reutilizable, **añádela a `devsprint.css` y documéntala aquí** en el mismo commit; no la dejes en la vista.
3. **Copia el aspecto de las vistas ya hechas** (`registro`, `proyectos`) y su estructura de código (`04-convenciones-codigo.md`).
4. **Textos de la interfaz en castellano**, tuteando, con la marca **DevSprint**.
5. **No inventes datos ni requisitos.** Lo que no esté claro se marca `[PENDENT]` en `08-decisiones-y-pendientes.md` y se pregunta al equipo. Los requisitos están en `05-producto-y-requisitos.md`.
6. **Una persona, una tarea, una rama.** Trabaja solo en lo que tienes asignado en Airtable y no reescribas el trabajo de otros sin avisar (`06-flujo-de-trabajo.md`).
7. **Nada de secretos en Git**: ni `.env`, ni contraseñas, ni tokens, ni claves.
8. **Verifica antes de dar algo por hecho**: `vendor/bin/pint` sobre tus archivos, `php artisan test --compact` y mira la vista en escritorio y en móvil.

## Checklist antes de hacer commit
- [ ] La vista usa `@fonts` y `@vite('resources/css/app.css')` en el `<head>`.
- [ ] No hay `<style>`, ni `style="..."` (salvo valores dinámicos como el ancho de una barra), ni hexadecimales en el HTML.
- [ ] Colores y fuentes salen de los tokens; los datos variables (fechas, contadores, horas) en `font-mono`.
- [ ] Un solo botón naranja (`.boton-principal`) por pantalla como acción principal.
- [ ] Todos los campos tienen `<label>`, hay foco visible y la pantalla funciona en móvil (375 px) y escritorio.
- [ ] Textos en castellano; marca «DevSprint».
- [ ] Hay un test Pest para la ruta y los estados relevantes (con datos y vacío).
- [ ] Pint pasado **solo sobre tus archivos** y sin reformatear líneas de otras personas.
- [ ] Si has añadido una clase o regla nueva, está documentada en esta carpeta.

## Cómo pedirle una vista a tu agente (plantilla)
```text
Lee AGENTS/README.md, 02-guia-visual.md y 03-componentes.md.
Haz la vista «<nombre>» de la tarea «<tarea de Airtable>».
Reutiliza las clases de resources/css/devsprint.css y copia la estructura de
resources/views/proyectos.blade.php. Controlador y ruta nombrada según
04-convenciones-codigo.md, con test Pest. Si falta algo, marca [PENDENT].
Comprueba escritorio y móvil antes de terminar.
```

## Mantener esta carpeta
La documentación es la memoria de los agentes: si cambia el manual, un componente, una convención o una decisión, **se actualiza aquí en el mismo commit**. Última revisión: 20/10/2026 (Óscar).
