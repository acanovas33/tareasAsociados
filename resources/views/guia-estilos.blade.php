<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guía de estilos</title>
    @fonts
    @vite('resources/css/app.css')
</head>
<body class="app-fondo">
    <main class="mx-auto w-full max-w-5xl space-y-6">
        <div class="tarjeta">
            <div class="tarjeta-franja"></div>
            <div class="tarjeta-cuerpo">
                <img src="{{ asset('images/logoPrincipal.png') }}" alt="Logo de DevSprint" class="mb-6 block h-auto w-[150px] max-w-full">
                <p class="sobretitulo mb-2">Sistema de diseño</p>
                <h1 class="titulo-pagina">Guía de estilos</h1>
                <p class="texto-suave mt-2">Todos los componentes de <span class="codigo">resources/css/devsprint.css</span> tal y como se ven. Consulta la guía completa en <span class="codigo">AGENTS/</span> y copia los fragmentos de <span class="codigo">AGENTS/03-componentes.md</span>.</p>
            </div>
        </div>

        {{-- 1. Colores --}}
        <section class="tarjeta">
            <div class="tarjeta-franja"></div>
            <div class="tarjeta-cuerpo">
                <h2 class="titulo-seccion">Colores del manual</h2>
                <p class="texto-suave mt-2">Usa siempre los tokens, nunca hexadecimales sueltos.</p>

                <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-5">
                    <div>
                        <div class="h-16 rounded-xl bg-principal"></div>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Principal</p>
                        <p class="font-mono text-xs text-slate-500">#FF6A3B</p>
                        <p class="texto-suave"><span class="codigo">bg-principal</span></p>
                        <p class="text-xs leading-5 text-slate-500">Marca y botones de acción</p>
                    </div>
                    <div>
                        <div class="h-16 rounded-xl bg-secundario ring-1 ring-slate-300"></div>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Secundario</p>
                        <p class="font-mono text-xs text-slate-500">#E6E1DA</p>
                        <p class="texto-suave"><span class="codigo">bg-secundario</span></p>
                        <p class="text-xs leading-5 text-slate-500">Fondo neutro</p>
                    </div>
                    <div>
                        <div class="h-16 rounded-xl bg-destacado"></div>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Destacado</p>
                        <p class="font-mono text-xs text-slate-500">#111827</p>
                        <p class="texto-suave"><span class="codigo">bg-destacado</span></p>
                        <p class="text-xs leading-5 text-slate-500">Cabeceras y controles oscuros</p>
                    </div>
                    <div>
                        <div class="h-16 rounded-xl bg-alerta"></div>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Alerta</p>
                        <p class="font-mono text-xs text-slate-500">#E53E3E</p>
                        <p class="texto-suave"><span class="codigo">bg-alerta</span></p>
                        <p class="text-xs leading-5 text-slate-500">Errores, bloqueos, plazos</p>
                    </div>
                    <div>
                        <div class="h-16 rounded-xl bg-texto"></div>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Texto</p>
                        <p class="font-mono text-xs text-slate-500">#1F2937</p>
                        <p class="texto-suave"><span class="codigo">text-texto</span></p>
                        <p class="text-xs leading-5 text-slate-500">Cuerpo de texto</p>
                    </div>
                </div>

                <h3 class="mt-8 text-sm font-bold text-slate-900">Variantes del naranja (no están en el manual)</h3>
                <div class="mt-3 flex flex-wrap gap-4">
                    <div class="flex items-center gap-2"><span class="h-8 w-8 rounded-lg bg-principal-oscuro"></span><span class="codigo">principal-oscuro</span></div>
                    <div class="flex items-center gap-2"><span class="h-8 w-8 rounded-lg bg-principal-claro"></span><span class="codigo">principal-claro</span></div>
                    <div class="flex items-center gap-2"><span class="h-8 w-8 rounded-lg bg-principal-suave"></span><span class="codigo">principal-suave</span></div>
                </div>
                <p class="texto-suave mt-2">Solo para hover y degradados. Los grises de apoyo son la paleta <span class="codigo">slate</span> de Tailwind.</p>
            </div>
        </section>

        {{-- 2. Tipografías --}}
        <section class="tarjeta">
            <div class="tarjeta-franja"></div>
            <div class="tarjeta-cuerpo">
                <h2 class="titulo-seccion">Tipografías</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    <div>
                        <p class="font-display text-4xl font-bold text-slate-900">Aa</p>
                        <p class="mt-2 font-display text-lg font-bold text-slate-900">Inter</p>
                        <p class="texto-suave">Primaria · títulos · <span class="codigo">font-display</span></p>
                        <p class="mt-2 font-display text-sm font-bold text-slate-700">Organiza tu día. Avanza con claridad.</p>
                    </div>
                    <div>
                        <p class="font-sans text-4xl font-semibold text-slate-900">Aa</p>
                        <p class="mt-2 font-sans text-lg font-bold text-slate-900">Plus Jakarta Sans</p>
                        <p class="texto-suave">Secundaria · texto y formularios · <span class="codigo">font-sans</span></p>
                        <p class="mt-2 text-sm text-slate-700">Organiza tu día. Avanza con claridad.</p>
                    </div>
                    <div>
                        <p class="font-mono text-4xl font-bold text-slate-900">Aa</p>
                        <p class="mt-2 font-mono text-lg font-bold text-slate-900">JetBrains Mono</p>
                        <p class="texto-suave">Terciaria · datos variables · <span class="codigo">font-mono</span></p>
                        <p class="mt-2 font-mono text-sm text-slate-700">23/10/2026 · 12 h · 58%</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. Textos --}}
        <section class="tarjeta">
            <div class="tarjeta-franja"></div>
            <div class="tarjeta-cuerpo">
                <h2 class="titulo-seccion">Jerarquía de textos</h2>
                <div class="mt-6 space-y-5">
                    <div>
                        <p class="sobretitulo mb-2">Sobretítulo de ejemplo</p>
                        <p class="texto-suave"><span class="codigo">.sobretitulo</span> · encima de un título</p>
                    </div>
                    <div>
                        <p class="titulo-pagina">Título de página</p>
                        <p class="texto-suave mt-1"><span class="codigo">.titulo-pagina</span> · un <span class="codigo">&lt;h1&gt;</span> por pantalla</p>
                    </div>
                    <div>
                        <p class="titulo-seccion">Título de sección o tarjeta</p>
                        <p class="texto-suave mt-1"><span class="codigo">.titulo-seccion</span> · <span class="codigo">&lt;h2&gt;</span></p>
                    </div>
                    <div>
                        <p class="texto-suave">Texto de apoyo con la descripción de la pantalla o del bloque.</p>
                        <p class="texto-suave mt-1"><span class="codigo">.texto-suave</span></p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-700">Texto de cuerpo: hereda la fuente y el color de <span class="codigo">.app-fondo</span>.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. Botones --}}
        <section class="tarjeta">
            <div class="tarjeta-franja"></div>
            <div class="tarjeta-cuerpo">
                <h2 class="titulo-seccion">Botón principal</h2>
                <p class="texto-suave mt-2">Un solo botón naranja por pantalla, para la acción principal. Pasa el ratón y usa el tabulador para ver hover y foco.</p>
                <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center">
                    <button type="button" class="boton-principal w-full sm:w-auto">Nuevo proyecto</button>
                    <button type="button" class="boton-principal w-full sm:w-64">Crear mi cuenta</button>
                </div>
                <p class="texto-suave mt-4"><span class="codigo">.boton-principal</span> + <span class="codigo">w-full</span> o <span class="codigo">w-full sm:w-auto</span></p>
            </div>
        </section>

        {{-- 5. Formularios --}}
        <section class="tarjeta">
            <div class="tarjeta-franja"></div>
            <div class="tarjeta-cuerpo">
                <h2 class="titulo-seccion">Formularios</h2>
                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="ejemplo-correo" class="etiqueta">Correo electrónico</label>
                        <input type="email" id="ejemplo-correo" placeholder="tu@correo.com" class="campo">
                        <p class="texto-suave mt-2"><span class="codigo">.etiqueta</span> + <span class="codigo">.campo</span></p>
                    </div>
                    <div>
                        <label for="ejemplo-error" class="etiqueta">Contraseña</label>
                        <input type="password" id="ejemplo-error" value="1234" class="campo">
                        <div class="campo-error">La contraseña debe tener al menos 8 caracteres.</div>
                        <p class="texto-suave mt-2"><span class="codigo">.campo-error</span> debajo del campo</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 6. Tarjetas --}}
        <section class="space-y-6">
            <div class="tarjeta">
                <div class="tarjeta-franja"></div>
                <div class="tarjeta-cuerpo">
                    <h2 class="titulo-seccion">Tarjetas</h2>
                    <p class="texto-suave mt-2"><span class="codigo">.tarjeta</span> + <span class="codigo">.tarjeta-franja</span> (primer hijo) + <span class="codigo">.tarjeta-cuerpo</span> o <span class="codigo">p-6</span>. Ejemplo de tarjeta de proyecto en rejilla:</p>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <article class="tarjeta flex flex-col">
                    <div class="tarjeta-franja"></div>
                    <div class="flex flex-1 flex-col p-6">
                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-principal">Administrador</p>
                        <h3 class="titulo-seccion">Trabajo de fin de módulo</h3>
                        <p class="texto-suave mt-2 flex-1">Memoria y presentación final del módulo de desarrollo web.</p>
                        <div class="mt-6">
                            <div class="mb-1.5 flex items-center justify-between text-sm font-semibold text-slate-700">
                                <span>Progreso</span>
                                <span class="font-mono">58%</span>
                            </div>
                            <div class="progreso" role="progressbar" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100" aria-label="Progreso de Trabajo de fin de módulo">
                                <div class="progreso-barra" style="width: 58%"></div>
                            </div>
                            <p class="mt-3 text-[13px] text-slate-500"><span class="font-mono">7</span> de <span class="font-mono">12</span> tareas hechas · <span class="font-mono">4</span> miembros</p>
                        </div>
                    </div>
                </article>

                <article class="tarjeta flex flex-col">
                    <div class="tarjeta-franja"></div>
                    <div class="flex flex-1 flex-col p-6">
                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Colaborador</p>
                        <h3 class="titulo-seccion">Torneo de debate</h3>
                        <p class="texto-suave mt-2 flex-1">Organización de equipos, fechas y materiales del torneo.</p>
                        <div class="mt-6">
                            <div class="mb-1.5 flex items-center justify-between text-sm font-semibold text-slate-700">
                                <span>Progreso</span>
                                <span class="font-mono">22%</span>
                            </div>
                            <div class="progreso" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100" aria-label="Progreso de Torneo de debate">
                                <div class="progreso-barra" style="width: 22%"></div>
                            </div>
                            <p class="mt-3 text-[13px] text-slate-500"><span class="font-mono">2</span> de <span class="font-mono">9</span> tareas hechas · <span class="font-mono">6</span> miembros</p>
                        </div>
                    </div>
                </article>

                <article class="tarjeta flex flex-col">
                    <div class="tarjeta-franja"></div>
                    <div class="flex flex-1 flex-col p-6">
                        <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Colaborador</p>
                        <h3 class="titulo-seccion">Proyecto de robótica</h3>
                        <p class="texto-suave mt-2 flex-1">Montaje del robot y entrega de la documentación técnica.</p>
                        <div class="mt-6">
                            <div class="mb-1.5 flex items-center justify-between text-sm font-semibold text-slate-700">
                                <span>Progreso</span>
                                <span class="font-mono">100%</span>
                            </div>
                            <div class="progreso" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" aria-label="Progreso de Proyecto de robótica">
                                <div class="progreso-barra" style="width: 100%"></div>
                            </div>
                            <p class="mt-3 text-[13px] text-slate-500"><span class="font-mono">5</span> de <span class="font-mono">5</span> tareas hechas · <span class="font-mono">3</span> miembros</p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- 7. Datos variables, estado vacío y alerta --}}
        <section class="tarjeta">
            <div class="tarjeta-franja"></div>
            <div class="tarjeta-cuerpo">
                <h2 class="titulo-seccion">Datos variables</h2>
                <p class="texto-suave mt-2">Fechas límite, contadores, horas y porcentajes van en <span class="codigo">font-mono</span>.</p>
                <p class="mt-4 text-sm text-slate-700">Entrega el <span class="font-mono">23/10/2026</span> · estimación <span class="font-mono">12 h</span> · <span class="font-mono">7/12</span> tareas</p>

                <h2 class="titulo-seccion mt-10">Alerta (patrón provisional)</h2>
                <p class="texto-suave mt-2">Bloqueos, plazos a punto de vencer y errores críticos. Siempre con texto o icono, nunca solo color. Pendiente de componente propio.</p>
                <p class="mt-4 text-sm font-semibold text-alerta">⚠ Tarea bloqueada: falta aprobar el diseño.</p>
            </div>
        </section>

        <div class="tarjeta text-center">
            <div class="tarjeta-franja"></div>
            <div class="p-9">
                <h2 class="titulo-seccion">Estado vacío</h2>
                <p class="texto-suave mt-2">Todavía no tienes proyectos. Crea tu primer proyecto para empezar a organizar tus tareas.</p>
            </div>
        </div>

        <p class="text-center text-xs text-white/75">Organiza tu día. Avanza con claridad.</p>
    </main>
</body>
</html>
