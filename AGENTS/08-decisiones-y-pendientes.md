# 08 · Decisiones y pendientes

Registro vivo. Una decisión resuelta pasa a «Decisiones tomadas» con fecha y quién; una duda nueva se añade a «Pendientes» marcada `[PENDENT]`. **Los agentes no resuelven pendientes por su cuenta.**

## Decisiones tomadas
| Fecha | Decisión | Quién |
|---|---|---|
| 22/09/2026 | «ChatGPT y asociados» es el nombre del equipo/empresa ficticia | Equipo |
| 29/09/2026 | Público: estudiantes del ámbito académico y equipos mixtos | Equipo |
| 20/10/2026 | La marca visible de la aplicación es **DevSprint** (logotipo del manual) | Óscar |
| 20/10/2026 | Textos de la interfaz en **castellano** | Óscar |
| 20/10/2026 | Las fuentes del manual (Inter, Plus Jakarta Sans, JetBrains Mono) sustituyen a Instrument Sans | Óscar |
| 20/10/2026 | Estilo en un CSS global documentado (`devsprint.css`) con tokens del manual y clases de componente; las vistas no llevan estilos propios | Óscar |
| 20/10/2026 | Estructura visual de las vistas (fondo con imagen, tarjetas blancas con franja naranja) se mantiene; el manual cambia tipografías | Óscar |
| 20/10/2026 | Esta carpeta `AGENTS/` vale para Claude Code, Codex, Cursor, Gemini y similares | Óscar |

## Pendientes
### Diseño
- `[PENDENT]` **Contraste del botón naranja:** texto blanco sobre `#FF6A3B` ≈ 2,9:1 (< 3:1 de WCAG); alternativa `text-destacado` ≈ 6:1. Lo decide el equipo/Arnaldo; hoy `.boton-principal` usa blanco (como `registro`).
- `[PENDENT]` **Neutros de apoyo:** las vistas usan la paleta `slate` de Tailwind para grises (no está en el manual). Validar o sustituir por tonos del manual con Arnaldo.
- `[PENDENT]` **Colores/iconos de estados y tipos de tarea** (requisito 5): el manual no los define.
- `[PENDENT]` **Estados de carga y de éxito** y componente de **alerta** (bloqueado, plazo a punto de vencer).
- `[PENDENT]` **Layout base de Blade** (`<html>`, `<head>`, `@fonts`, `@vite`) para no repetirlo en cada vista; y menú lateral y barra superior del wireframe «inici».
- `[PENDENT]` **Vista `registro`:** migrarla a `devsprint.css` (hoy usa estilos propios y no carga `@fonts`); la rama `registro` usa grises azulados distintos a los de `slate` de las demás.
- `[PENDENT]` **Modo oscuro:** no definido; no implementar hasta decidirlo.

### Producto y técnica
- `[PENDENT]` Base de datos de producción (hoy SQLite en local; el reto habla de SQL Server/MySQL) y modelo relacional (Albert/Arnaldo).
- `[PENDENT]` Autenticación: sesiones de Laravel (web) frente a tokens (API). El enunciado pide sesión mediante la API.
- `[PENDENT]` Frontend de la pantalla Kanban: JavaScript sin framework (DOM y eventos, según 0612) frente a otro; el Site menciona Vue sin fijarlo.
- `[PENDENT]` Mejoras opcionales (analítica, calendario, recursos, documentos): cuáles se implementan.
- `[PENDENT]` Nombre y año de los hitos de despliegue (10/11 y 08/12) y rúbricas de cada módulo (lo confirma el profesorado).

### Equipo y flujo
- `[PENDENT]` Cómo se fusionan las ramas (Pull Request o manual) y quién revisa.
- `[PENDENT]` Cuentas de GitHub de Raúl y Arnaldo; permisos de escritura en el repositorio.
- `[PENDENT]` Si `.claude/skills/`, `.mcp.json` y `boost.json` (plantilla de Laravel Boost) se mantienen en el repositorio.
- `[PENDENT]` Ruta `/saludos/{nombre?}` de prueba: eliminar.

## Cómo añadir una duda
Una línea con `[PENDENT]`, el tema y la opción que se propone. Avisa a tu persona del equipo y sigue trabajando en lo que no depende de ella.
