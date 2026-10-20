# 07 · Pantallas

Inventario de vistas de la aplicación, su estado y de dónde sale cada diseño. Actualízalo cuando se cree o cambie una pantalla. Los wireframes del manual están en [`referencias/`](referencias/).

| Pantalla | Ruta | Vista / controlador | Responsable (Airtable) | Rama | Estado (20/10/2026) |
|---|---|---|---|---|---|
| Registro («sign up») | `/` y `/registro` | `registro.blade.php` · `RegistroController@index` | Albert | `main` / `registro` | Maquetada, sin backend (no guarda usuarios). La rama `registro` usa Tailwind con colores previos al manual |
| Login | `[PENDENT]` | — | Raúl | `Login` (vacía) | Sin empezar |
| Inicio: lista de proyectos | `/proyectos` (`proyectos.index`) | `proyectos.blade.php` · `ProyectosController@index` | Óscar | `projectlist` | Hecha con datos de ejemplo; usa `devsprint.css` |
| Crear proyecto | `[PENDENT]` | — | — | — | El botón «Nuevo proyecto» aún no enlaza a nada |
| Proyecto con tareas / Kanban | `[PENDENT]` | — | — | — | Sin asignar |

## Wireframes del manual
- **Login** — [`referencias/wireframe-login.png`](referencias/wireframe-login.png): logo arriba a la izquierda; mensaje «Benvinguda a la Web!»; campos Correu y Contrasenya; botones «sign up» y «Login».
- **Sign up** — [`referencias/wireframe-signup.png`](referencias/wireframe-signup.png): variante del login con el formulario de registro.
- **Inici** — [`referencias/wireframe-inici.png`](referencias/wireframe-inici.png): barra superior (logo, selector «Projecte: DevSprint», buscador «Cercar tasca…», usuario), menú lateral, botón «+ nova tasca» y tarjetas de tarea en horizontal (título, modelo, fecha de término). Es la pantalla de **tareas dentro de un proyecto**; la lista de proyectos (tarea de Óscar) es la pantalla anterior a esta.

Los wireframes son orientativos (cajas grises). El aspecto final lo definen la identidad y el sistema de diseño (`01`, `02`, `03`).

## Datos de cada pantalla (de los requisitos)
- **Proyectos:** nombre, descripción, rol del usuario (Administrador/Colaborador), miembros, progreso de tareas. Acción: crear proyecto.
- **Proyecto/Kanban:** columnas por estado (Por hacer · En progreso · Hecha), tarjetas de tarea con tipo (color o icono), responsable y fecha límite (`font-mono`), arrastrar y soltar que guarda vía API; una tarea en «Hecha» no se puede mover.
- **Administración del proyecto:** editar, eliminar, añadir/quitar colaboradores (solo el administrador).

## Navegación prevista (propuesta)
Registro ⇄ Login → **Proyectos** → Proyecto (Kanban) → Tarea. `[PENDENT]` confirmar con Albert (wireframes) y el equipo: menú lateral, cierre de sesión y selector de proyecto.
