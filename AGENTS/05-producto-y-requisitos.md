# 05 · Producto y requisitos

Fuente: enunciado «PROJ_01 · Aplicació de gestió de projectes» (Google Site del centro) y reto «0612 & 0613 · Programar l'eina de gestió». **Entrega final: 20/12/2026.**

## Qué es DevSprint
Aplicación web para que estudiantes y equipos **organicen proyectos, colaboren, creen y sigan tareas y cumplan plazos**. Problema de partida: la desorganización de proyectos académicos y extracurriculares (plazos incumplidos, tareas olvidadas, estrés).

## Alcance DAW
- Backend **Laravel**, acceso a datos con **Eloquent** y una **API central**.
- Cliente web dinámico con **JavaScript**: consumo de la API, DOM y eventos.
- Registro, inicio de sesión y gestión de sesión mediante la API.
- Responsive (mínimo escritorio y móvil) con un **framework CSS** (aquí, Tailwind).
- Identidad corporativa (manual) y wireframes.
- Despliegue en un entorno de producción accesible.

## Requisitos obligatorios
| # | Requisito |
|---|---|
| 1 | **Usuarios y autenticación:** registro e inicio de sesión |
| 2 | **Proyectos:** al iniciar sesión se listan los proyectos del usuario; cualquier usuario puede crear uno; su creador es su **administrador** |
| 3 | **Administración del proyecto:** el administrador edita o elimina el proyecto y añade o elimina colaboradores |
| 4 | **Estados del workflow:** como mínimo `Por hacer`, `En progreso` y `Hecha` |
| 5 | **Tipos de tarea:** configurables y claramente distinguibles (color **o** icono) |
| 6 | **Tareas:** todos los miembros pueden crearlas, editarlas y eliminarlas |
| 7 | **Asignación:** un miembro puede asignarse una tarea; el administrador puede asignar cualquier tarea a cualquier miembro |
| 8 | **Cambio de estado:** cada usuario solo cambia el estado de **sus** tareas asignadas; el administrador, el de todas |
| 9 | **Kanban:** columnas por estado y arrastrar y soltar que **persiste el cambio a través de la API** |
| 10 | **Estado final bloqueado:** una tarea en `Hecha` no puede volver a otro estado |
| 11 | **Roles y permisos:** niveles de acceso acordes con las responsabilidades |
| — | **Identidad corporativa** aplicada, **diseño responsive** y **despliegue** en producción |

## Requisitos opcionales (mejoras)
Analítica e informes de progreso · calendario y plazos (periodos críticos) · gestión de recursos (tiempo, presupuesto, personas) · gestión documental (subida y organización de archivos). `[PENDENT]` si se implementa alguna: lo decide el equipo.

## Roles y permisos (derivados de los requisitos)
| Acción | Administrador del proyecto | Colaborador |
|---|---|---|
| Ver el proyecto y sus tareas | Sí | Sí |
| Editar o eliminar el proyecto | Sí | No |
| Añadir o quitar colaboradores | Sí | No |
| Crear, editar y eliminar tareas | Sí | Sí |
| Asignarse una tarea | Sí | Sí |
| Asignar una tarea a otro miembro | Sí | No |
| Cambiar el estado de una tarea | De todas | Solo de las suyas |
| Reabrir una tarea en `Hecha` | **No** (estado final bloqueado) | **No** |
Ser «administrador» es un rol **por proyecto**: quien crea un proyecto es su administrador; en otros proyectos puede ser colaborador. Matriz derivada del enunciado, no validada por el profesorado.

## Glosario (usar estos términos en la interfaz)
| Término | Significado |
|---|---|
| Proyecto | Conjunto de tareas de un equipo; tiene un administrador y colaboradores |
| Administrador | Creador del proyecto; gestiona proyecto, colaboradores y asignaciones |
| Colaborador | Miembro añadido a un proyecto |
| Tarea | Unidad de trabajo con título, estado, tipo y responsable |
| Estado | Fase de la tarea: Por hacer · En progreso · Hecha |
| Tipo de tarea | Categoría configurable, distinguible por color o icono |
| Kanban | Vista de columnas por estado con arrastrar y soltar |

Nota: la metodología del equipo en Airtable usa estados más amplios (Backlog, To Do, In Progress, In Review, Blocked, Ready for Testing, Testing, Reopened, Completed/Done). Son para **gestionar el equipo en Airtable**, no los estados de las tareas de la aplicación.

## Datos de ejemplo hasta que exista la BD
Mientras no haya modelo relacional, las vistas reciben arrays con esta forma (ver `ProyectosController`); al migrar a Eloquent se conserva el mismo nombre de campos para no tocar la vista:
```php
[
    'nombre' => 'Trabajo de fin de módulo',
    'descripcion' => 'Memoria y presentación final.',
    'rol' => 'Administrador',        // 'Administrador' | 'Colaborador'
    'miembros' => 4,
    'tareas_totales' => 12,
    'tareas_hechas' => 7,
]
```

## Entrega final (Classroom, 20/12)
Proyecto web completo · modelo relacional · script SQL con `INSERT` para probar · credenciales de prueba por canal seguro (**nunca en el repositorio**) · manual de identidad y elementos relacionados. Despliegue en producción con dominio, HTTPS y CDN (módulo 0614; primera versión el 10/11 y final el 08/12 `[PENDENT]` confirmar año y detalles).
