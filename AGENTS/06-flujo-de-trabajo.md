# 06 · Flujo de trabajo

## Equipo «ChatGPT y asociados»
| Persona | Cuenta GitHub | Áreas habituales |
|---|---|---|
| Albert Canovas Pera | `acanovas33` (propietario del repo) | Wireframe, registro, BD |
| Óscar Ojuel González | `oojuelg2526-cmyk` | Vista de inicio (proyectos) |
| Raúl García Moreno | `[PENDENT]` | Login |
| Arnaldo Alonso Huapaya Sierra | `[PENDENT]` (rama `alonso`) | Modelo relacional, paleta y tipografías |

Estado y reparto reales: **Airtable «Proyecto 1 tareas»** (pestañas Backlog, Sprint 1, 2, 3). Reparto del Sprint 2 (leído el 20/10/2026):
| Tarea | Responsable |
|---|---|
| Vista: Página de Login | Raúl García |
| Vista: Página de Registro | Albert Canovas |
| Vista: Página de inicio, donde se muestran los proyectos | Óscar Ojuel |
| BD: Creación de la base de datos | Albert Canovas |
| BD: crear modelo relacional | Arnaldo Alonso |
**Una tarea, un responsable.** Cada persona trabaja con su agente solo en lo suyo; si necesita algo de otra tarea, lo pide al responsable.

## Sprints (hoja del profesorado)
| Sprint | Fechas |
|---|---|
| 1 | 21/09 – 04/10 (diseño: manual de identidad) |
| 2 | 05/10 – 18/10 |
| **3** | **19/10 – 01/11** |
| Incremento | 02/11 |
| 4 | 02/11 – 15/11 |
| 5 | 16/11 – 29/11 |
| 6 | 30/11 – 13/12 |
| Incremento (presentaciones) | 14/12 – 18/12 |
| Fin del proyecto | 18/12 · entrega 20/12 |
Reunión con el Project Manager como mínimo cada dos semanas; Airtable debe reflejar responsable y estado de cada tarea (forma parte de la evaluación).

## Git
Repositorio: https://github.com/acanovas33/tareasAsociados (público).

- **Una rama por tarea**, desde `main` actualizado, con nombre corto en minúsculas que identifique la tarea (`login`, `registro`, `projectlist`, `bd-modelo`). Las ramas existentes (`Login`, `registro`, `projectlist`, `alonso`) se mantienen; las nuevas siguen esta regla.
- **Commits** en castellano: título corto en imperativo o descriptivo + lista de cambios si hace falta. Ejemplo real: «Vista: página de inicio con la lista de proyectos». Pequeños y con un propósito cada uno. Nunca mezclar tu tarea con cambios de otros.
- **No se hace push directo a `main`.** `[PENDENT]` confirmar con el equipo si se usa Pull Request (propuesta) o fusión manual y quién revisa.
- Antes de empezar o de fusionar: `git fetch` y traer los cambios de `main`.
- **Archivos compartidos** (`resources/css/devsprint.css`, `vite.config.js`, `routes/web.php`, `AGENTS/`): cambios pequeños, avisados en el commit y sin reformatear líneas ajenas.
- Para la tarea de clase «0.6 GitHub (VS Code)»: rama + commit + merge + borrar rama + captura del log de ramas, en pareja.

## Qué puede hacer un agente
Puede: leer el repositorio, crear y editar archivos de **su tarea**, ejecutar pruebas, Pint y `npm run build`, proponer commits, documentar en `AGENTS/`.

**Pide confirmación a su persona antes de:** hacer `push`, fusionar ramas, borrar ramas o archivos que no creó, cambiar dependencias (`composer.json`, `package.json`), tocar archivos compartidos o de otro miembro, o ejecutar migraciones sobre datos que no sean los locales de prueba.

**Nunca:** subir `.env`, contraseñas, tokens o claves; escribir credenciales en el código; subir el contenido de `vendor/`, `node_modules/` o `public/build/`; inventar requisitos, datos o decisiones del equipo (marcar `[PENDENT]`); modificar el manual de identidad; comentar o entregar nada en Classroom (lo hace cada persona).

## Seguridad y datos
- `.env` solo en local (`cp .env.example .env`). Las credenciales de prueba de la entrega final se pasan por canal seguro, no en el repositorio (el repo es público).
- Usuarios y contraseñas de ejemplo solo en seeders con datos ficticios.
- Sin datos personales reales en capturas, tests ni seeders.

## Cuando algo no está claro
1. Busca en esta carpeta y en el brief (`05`).
2. Si sigue sin estar claro: **no lo supongas**. Escribe la duda en `08-decisiones-y-pendientes.md` como `[PENDENT]`, avisa a tu persona y sigue con lo demás.
