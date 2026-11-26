# DevSprint

Aplicación web para **gestionar proyectos y tareas en equipo**. Cada usuario ve sus proyectos, crea los suyos, invita a colaboradores y organiza el trabajo en tareas que avanzan por estados (*Por hacer · En progreso · Hecha*).

Proyecto del equipo **«ChatGPT y asociados»** para el Projecte Intermodular 1 del CFGS Desarrollo de Aplicaciones Web (Politècnics Barcelona, curso 2026/27).

## Equipo
| Persona | Parte principal |
|---|---|
| Albert Cánovas Pera | Registro, página del proyecto con sus tareas |
| Raúl García Moreno | Inicio de sesión |
| Arnaldo Alonso Huapaya Sierra | Modelos y base de datos, perfil, crear proyecto |
| Óscar Ojuel González | Sistema de diseño, lista de proyectos, pop-up «Crear tarea» |

El reparto y el estado de cada tarea se llevan en Airtable, por sprints de dos semanas.

## Qué incluye
- **Usuarios:** registro, inicio y cierre de sesión, edición del perfil y de la contraseña.
- **Proyectos:** lista de los proyectos del usuario, con su rol, y creación de proyectos nuevos.
- **Tareas:** página de cada proyecto con las tareas agrupadas por estado, con responsables y fechas de inicio y de fin, y pop-up para crear tareas nuevas.
- **Sistema de diseño propio** (`resources/css/devsprint.css`): colores, tipografías y componentes del manual de identidad corporativa, con una página de muestra en `/guia-estilos` (solo en local).
- **Interfaz responsive**, para escritorio y móvil.

Lo que falta por hacer: editar y eliminar proyectos, tipos de tarea, editar y eliminar tareas, tablero Kanban con arrastrar y soltar, API para el cliente JavaScript, y roles y permisos completos.

## Tecnologías
| Capa | Herramientas |
|---|---|
| Backend | PHP 8.3 o superior (8.5 en desarrollo), Laravel 13, Eloquent |
| Vistas | Blade y componentes Blade anónimos |
| Estilos | Tailwind CSS 4 con un archivo de diseño propio |
| Cliente | JavaScript sin dependencias (por ejemplo, el pop-up en `resources/js/modal.js`) |
| Compilación | Vite 8 con `laravel-vite-plugin` y fuentes de Bunny Fonts (Inter, Plus Jakarta Sans, JetBrains Mono) |
| Base de datos | SQL Server (servidor del centro) para la aplicación; SQLite en memoria para los tests |
| Pruebas y estilo | Pest 5 y Laravel Pint |
| Trabajo en equipo | Git y GitHub con ramas y Pull Requests, Airtable para las tareas |

## Puesta en marcha en local
Necesitas PHP, Composer, Node.js y npm. Para conectar con SQL Server hace falta además la extensión `pdo_sqlsrv` de PHP.

```bash
git clone https://github.com/acanovas33/tareasAsociados.git
cd tareasAsociados
composer install
npm ci
cp .env.example .env
php artisan key:generate
```

Edita `.env` con los datos de la base de datos:

```dotenv
DB_CONNECTION=sqlsrv
DB_HOST=...
DB_PORT=1433
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

# Para que la sesión use el modelo Usuario del proyecto
AUTH_MODEL=App\Models\Usuario
```

El host, el usuario y la contraseña de la base de datos del equipo están en el material de Classroom de la asignatura. **Nunca se suben al repositorio:** `.env` está ignorado por Git.

Después, arranca la aplicación (en dos terminales, o con `composer run dev`):

```bash
npm run dev
php artisan serve
```

Se abre en http://127.0.0.1:8000. Si prefieres no dejar Vite en marcha, ejecuta `npm run build` una vez.

## Base de datos
Las tablas están creadas directamente en SQL Server y los modelos de Eloquent las relacionan:

| Modelo | Tabla |
|---|---|
| `Usuario` | `usuario` |
| `Proyecto` | `proyecto` |
| `Tarea` | `tarea` |
| `Estado` | `estado` |
| `Rol` | `rol` |
| `UsuarioProyectoRol` | `usuario_proyecto_rol` (qué rol tiene cada usuario en cada proyecto) |
| — | `usuario_asignado` (qué usuarios tienen asignada cada tarea) |

`[PENDENT]` Incluir en el repositorio el script SQL de creación de tablas con los `INSERT` de prueba, que pide la entrega final.

## Rutas principales
| Ruta | Qué muestra |
|---|---|
| `/registro` | Crear cuenta |
| `/login` | Iniciar sesión |
| `/proyectos` | Mis proyectos (y crear uno nuevo) |
| `/proyectos/{proyecto}` | Tareas del proyecto por estado (arrastrar para cambiar de estado; crear y editar tareas con pop-ups) |
| `/perfil/editar` | Editar el perfil |
| `/guia-estilos` | Componentes del diseño (solo en local) |

## Estructura
```
app/Http/Controllers/   controladores (Login, Registro, Proyectos, Tarea, Perfil…)
app/Models/             modelos de Eloquent
resources/views/        vistas Blade y componentes (components/)
resources/css/          app.css y devsprint.css (sistema de diseño)
resources/js/           JavaScript del cliente
routes/web.php          rutas
tests/Feature/          pruebas con Pest
AGENTS/                 guía de diseño y convenciones del equipo
```

## Diseño y convenciones
Antes de crear o cambiar una vista, lee la guía de la carpeta [`AGENTS/`](AGENTS/README.md): identidad de marca, guía visual, catálogo de componentes, convenciones de código y flujo de trabajo. Resumen:

- Texto de la interfaz en castellano y marca **DevSprint**.
- Colores y tipografías a través de los tokens de `devsprint.css`, sin estilos sueltos en las vistas.
- Si falta un componente, se añade a `devsprint.css` y se documenta en la guía.

## Pruebas y estilo de código
```bash
php artisan test --compact     # todas las pruebas
vendor/bin/pint --dirty        # formatear los archivos modificados
```

Las pruebas usan SQLite en memoria y crean las tablas que necesitan.

## Flujo de trabajo
1. Una rama por tarea de Airtable, a partir de `main`.
2. Pull Request hacia `main` y revisión del equipo antes de fusionar.
3. Antes de abrirlo: pruebas en verde y `npm run build` correcto.
4. Sin secretos en el repositorio (`.env`, contraseñas, claves).
