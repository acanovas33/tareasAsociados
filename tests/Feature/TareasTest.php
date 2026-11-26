<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    // Esquema provisional de las tablas, hasta que el modelo de BD esté confirmado
    foreach (['usuario_asignado', 'usuario_proyecto_rol', 'tarea', 'estado', 'proyecto', 'usuario'] as $tabla) {
        Schema::dropIfExists($tabla);
    }

    Schema::create('usuario', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('correo');
        $table->string('contrasena');
    });
    Schema::create('proyecto', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
    });
    Schema::create('estado', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
    });
    Schema::create('tarea', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->date('fecha_inicio')->nullable();
        $table->date('fecha_limite')->nullable();
        $table->unsignedBigInteger('id_proyecto');
        $table->unsignedBigInteger('id_estado');
    });
    Schema::create('usuario_proyecto_rol', function (Blueprint $table) {
        $table->unsignedBigInteger('id_usuario');
        $table->unsignedBigInteger('id_proyecto');
        $table->unsignedBigInteger('id_rol')->nullable();
    });
    Schema::create('usuario_asignado', function (Blueprint $table) {
        $table->unsignedBigInteger('id_tarea');
        $table->unsignedBigInteger('id_usuario');
    });

    DB::table('proyecto')->insert(['id' => 1, 'nombre' => 'Proyecto de prueba']);
    DB::table('estado')->insert([['id' => 1, 'nombre' => 'Por hacer'], ['id' => 2, 'nombre' => 'En progreso']]);
    DB::table('usuario_proyecto_rol')->insert(['id_usuario' => 1, 'id_proyecto' => 1, 'id_rol' => 1]);
    DB::table('usuario')->insert(['id' => 1, 'nombre' => 'Persona de prueba', 'correo' => 'persona@devsprint.test', 'contrasena' => 'hash']);
});

test('se crea una tarea en el proyecto desde el pop-up', function () {
    $this->post(route('tareas.store', 1), [
        'nombre' => 'Diseñar el Kanban',
        'descripcion' => 'Columnas por estado',
        'id_estado' => 1,
        'fecha_limite' => '2026-11-17',
    ])->assertRedirect()->assertSessionHas('success');

    $this->assertDatabaseHas('tarea', [
        'nombre' => 'Diseñar el Kanban',
        'descripcion' => 'Columnas por estado',
        'fecha_limite' => '2026-11-17',
        'id_proyecto' => 1,
        'id_estado' => 1,
    ]);
    $this->assertDatabaseCount('usuario_asignado', 0);
});

test('la tarea se puede asignar a un usuario', function () {
    $this->post(route('tareas.store', 1), [
        'nombre' => 'Preparar la demo',
        'id_estado' => 2,
        'id_usuario' => 1,
    ])->assertSessionHas('success');

    $idTarea = DB::table('tarea')->where('nombre', 'Preparar la demo')->value('id');

    $this->assertDatabaseHas('usuario_asignado', ['id_tarea' => $idTarea, 'id_usuario' => 1]);
});

test('el título de la tarea es obligatorio', function () {
    $this->post(route('tareas.store', 1), ['nombre' => '', 'id_estado' => 1])
        ->assertSessionHasErrorsIn('crearTarea', ['nombre' => 'El título de la tarea es obligatorio.']);

    $this->assertDatabaseCount('tarea', 0);
});

test('no se acepta un estado ni un usuario que no existen', function () {
    $this->post(route('tareas.store', 1), ['nombre' => 'Tarea', 'id_estado' => 99, 'id_usuario' => 99])
        ->assertSessionHasErrorsIn('crearTarea', ['id_estado', 'id_usuario']);

    $this->assertDatabaseCount('tarea', 0);
});

test('la fecha límite debe ser una fecha válida', function () {
    $this->post(route('tareas.store', 1), ['nombre' => 'Tarea', 'id_estado' => 1, 'fecha_limite' => 'mañana'])
        ->assertSessionHasErrorsIn('crearTarea', ['fecha_limite']);
});

test('no se crean tareas en un proyecto que no existe', function () {
    $this->post(route('tareas.store', 99), ['nombre' => 'Tarea', 'id_estado' => 1])->assertNotFound();

    $this->assertDatabaseCount('tarea', 0);
});

test('el pop-up muestra el formulario con los estados y los usuarios', function () {
    $this->withoutVite();

    $this->blade('<x-modal-crear-tarea :proyecto="5" :estados="[1 => \'Por hacer\', 2 => \'Hecha\']" :usuarios="[7 => \'Persona de prueba\']" />')
        ->assertSee('Crear tarea')
        ->assertSee(route('tareas.store', 5))
        ->assertSee('Por hacer')
        ->assertSee('Persona de prueba')
        ->assertDontSee('data-abrir-al-cargar');
});

test('el pop-up se vuelve a abrir solo cuando hay errores de validación', function () {
    $this->withoutVite();

    $this->withViewErrors(['nombre' => 'El título es obligatorio.'], 'crearTarea')
        ->blade('<x-modal-crear-tarea :proyecto="5" :estados="[1 => \'Por hacer\']" />')
        ->assertSee('data-abrir-al-cargar', false)
        ->assertSee('El título es obligatorio.');
});

test('la guía de estilos incluye el pop-up de ejemplo', function () {
    $this->withoutVite();

    $this->get('/guia-estilos')->assertOk()->assertSee('Pop-up (modal)')->assertSee('data-abrir-modal="modal-crear-tarea"', false);
});

test('se guarda la fecha de inicio de la tarea', function () {
    $this->post(route('tareas.store', 1), [
        'nombre' => 'Preparar la demo',
        'id_estado' => 1,
        'fecha_inicio' => '2026-11-20',
        'fecha_limite' => '2026-11-27',
    ])->assertSessionHasNoErrors();

    $this->assertDatabaseHas('tarea', ['nombre' => 'Preparar la demo', 'fecha_inicio' => '2026-11-20', 'fecha_limite' => '2026-11-27']);
});

test('la fecha límite no puede ser anterior a la de inicio', function () {
    $this->post(route('tareas.store', 1), [
        'nombre' => 'Fechas al revés',
        'id_estado' => 1,
        'fecha_inicio' => '2026-11-27',
        'fecha_limite' => '2026-11-20',
    ])->assertSessionHasErrorsIn('crearTarea', ['fecha_limite']);

    $this->assertDatabaseCount('tarea', 0);
});

test('la página de tareas del proyecto incluye el pop-up para crear tareas', function () {
    $this->get(route('tareas.proyecto', 1))
        ->assertOk()
        ->assertSee('data-abrir-modal="modal-crear-tarea"', false)
        ->assertSee('id="modal-crear-tarea"', false)
        ->assertSee('Persona de prueba')
        ->assertSee('En progreso');
});

test('tras crear una tarea desde la página del proyecto se vuelve a ella con el aviso y la tarea en su columna', function () {
    $this->from(route('tareas.proyecto', 1))
        ->post(route('tareas.store', 1), ['nombre' => 'Tarea desde el pop-up', 'id_estado' => 2, 'id_usuario' => 1])
        ->assertRedirect(route('tareas.proyecto', 1))
        ->assertSessionHas('success');

    $this->get(route('tareas.proyecto', 1))->assertSee('Tarea desde el pop-up')->assertSee('Persona de prueba');
});

/**
 * Pop-up «Editar tarea»
 */
function crearTareaDePrueba(array $datos = []): int
{
    return DB::table('tarea')->insertGetId($datos + [
        'nombre' => 'Tarea original',
        'descripcion' => 'Descripción original',
        'fecha_inicio' => '2026-11-20',
        'fecha_limite' => '2026-11-27',
        'id_proyecto' => 1,
        'id_estado' => 1,
    ]);
}

test('se editan los datos de una tarea desde el pop-up', function () {
    $idTarea = crearTareaDePrueba();

    $this->put(route('tareas.update', $idTarea), [
        'tarea_editada' => $idTarea,
        'nombre' => 'Tarea renombrada',
        'descripcion' => '',
        'id_estado' => 2,
        'fecha_inicio' => '2026-11-21',
        'fecha_limite' => '2026-11-30',
    ])->assertRedirect()->assertSessionHas('success', 'Tarea actualizada correctamente.');

    $this->assertDatabaseHas('tarea', [
        'id' => $idTarea,
        'nombre' => 'Tarea renombrada',
        'descripcion' => null,
        'id_estado' => 2,
        'fecha_inicio' => '2026-11-21',
        'fecha_limite' => '2026-11-30',
        'id_proyecto' => 1,
    ]);
});

test('al editar se asignan varias personas y se quitan las que se desmarcan', function () {
    DB::table('usuario')->insert(['id' => 2, 'nombre' => 'Segunda persona', 'correo' => 'segunda@devsprint.test', 'contrasena' => 'hash']);
    DB::table('usuario')->insert(['id' => 3, 'nombre' => 'Tercera persona', 'correo' => 'tercera@devsprint.test', 'contrasena' => 'hash']);
    $idTarea = crearTareaDePrueba();
    DB::table('usuario_asignado')->insert(['id_tarea' => $idTarea, 'id_usuario' => 3]);

    $this->put(route('tareas.update', $idTarea), ['nombre' => 'Tarea', 'id_estado' => 1, 'usuarios' => [1, 2]])
        ->assertSessionHas('success');

    $this->assertDatabaseHas('usuario_asignado', ['id_tarea' => $idTarea, 'id_usuario' => 1]);
    $this->assertDatabaseHas('usuario_asignado', ['id_tarea' => $idTarea, 'id_usuario' => 2]);
    $this->assertDatabaseMissing('usuario_asignado', ['id_tarea' => $idTarea, 'id_usuario' => 3]);

    // Sin ninguna casilla marcada, la tarea se queda sin asignar
    $this->put(route('tareas.update', $idTarea), ['nombre' => 'Tarea', 'id_estado' => 1]);
    $this->assertDatabaseCount('usuario_asignado', 0);
});

test('al editar se valida igual que al crear y no se cambia nada si hay errores', function () {
    $idTarea = crearTareaDePrueba();

    $this->put(route('tareas.update', $idTarea), [
        'nombre' => '',
        'id_estado' => 99,
        'fecha_inicio' => '2026-11-27',
        'fecha_limite' => '2026-11-20',
        'usuarios' => [99],
    ])->assertSessionHasErrorsIn('editarTarea', [
        'nombre' => 'El título de la tarea es obligatorio.',
        'id_estado',
        'fecha_limite',
        'usuarios.0',
    ]);

    $this->assertDatabaseHas('tarea', ['id' => $idTarea, 'nombre' => 'Tarea original', 'id_estado' => 1]);
});

test('editar una tarea que no existe devuelve 404', function () {
    $this->put(route('tareas.update', 99), ['nombre' => 'Tarea', 'id_estado' => 1])->assertNotFound();
});

test('cada tarea del tablero tiene su pop-up de edición con los datos actuales', function () {
    $idTarea = crearTareaDePrueba();
    DB::table('usuario_asignado')->insert(['id_tarea' => $idTarea, 'id_usuario' => 1]);

    $this->get(route('tareas.proyecto', 1))
        ->assertOk()
        ->assertSee('data-abrir-modal="modal-editar-tarea-'.$idTarea.'"', false)
        ->assertSee('id="modal-editar-tarea-'.$idTarea.'"', false)
        ->assertSee('value="Tarea original"', false)
        ->assertSee('value="2026-11-20"', false)
        ->assertSee('name="usuarios[]" value="1" class="h-4 w-4 accent-principal" checked', false);
});

test('si la edición tiene errores, al volver solo se reabre el pop-up de esa tarea', function () {
    $idTarea = crearTareaDePrueba();
    $otraTarea = crearTareaDePrueba(['nombre' => 'Otra tarea']);

    $this->from(route('tareas.proyecto', 1))
        ->put(route('tareas.update', $idTarea), ['tarea_editada' => $idTarea, 'nombre' => '', 'id_estado' => 1])
        ->assertRedirect(route('tareas.proyecto', 1));

    $pagina = $this->get(route('tareas.proyecto', 1))->assertOk()->getContent();

    // <dialog id="modal-editar-tarea-N" ... data-abrir-al-cargar>: el que se abre solo al cargar
    $abierto = fn (int $id) => '/<dialog id="modal-editar-tarea-'.$id.'"[^>]*data-abrir-al-cargar/';

    expect($pagina)->toMatch($abierto($idTarea));
    expect($pagina)->not->toMatch($abierto($otraTarea));
    expect($pagina)->toContain('El título de la tarea es obligatorio.');
});

test('lo escrito al editar no aparece en el pop-up de crear tarea', function () {
    $idTarea = crearTareaDePrueba();

    $this->from(route('tareas.proyecto', 1))
        ->put(route('tareas.update', $idTarea), ['tarea_editada' => $idTarea, 'nombre' => 'Texto escrito al editar', 'id_estado' => 99]);

    $this->get(route('tareas.proyecto', 1))
        ->assertSee('id="tarea-nombre" name="nombre" value=""', false);
});

/**
 * Pop-up «Eliminar tarea»
 */
test('se elimina una tarea con sus asignaciones', function () {
    $idTarea = crearTareaDePrueba();
    $otraTarea = crearTareaDePrueba(['nombre' => 'Otra tarea']);
    DB::table('usuario_asignado')->insert([
        ['id_tarea' => $idTarea, 'id_usuario' => 1],
        ['id_tarea' => $otraTarea, 'id_usuario' => 1],
    ]);

    $this->from(route('tareas.proyecto', 1))
        ->delete(route('tareas.destroy', $idTarea))
        ->assertRedirect(route('tareas.proyecto', 1))
        ->assertSessionHas('success', 'Tarea eliminada correctamente.');

    $this->assertDatabaseMissing('tarea', ['id' => $idTarea]);
    $this->assertDatabaseMissing('usuario_asignado', ['id_tarea' => $idTarea]);
    $this->assertDatabaseHas('tarea', ['id' => $otraTarea]);
    $this->assertDatabaseHas('usuario_asignado', ['id_tarea' => $otraTarea, 'id_usuario' => 1]);
});

test('eliminar una tarea que no existe devuelve 404', function () {
    $this->delete(route('tareas.destroy', 99))->assertNotFound();
});

test('la tarea solo se elimina por DELETE, no con un enlace', function () {
    $idTarea = crearTareaDePrueba();

    $this->get('/tareas/'.$idTarea)->assertStatus(405);

    $this->assertDatabaseHas('tarea', ['id' => $idTarea]);
});

test('el pop-up de editar lleva al de confirmar la eliminación de esa tarea', function () {
    $idTarea = crearTareaDePrueba();

    $this->get(route('tareas.proyecto', 1))
        ->assertOk()
        ->assertSee('data-abrir-modal="modal-eliminar-tarea-'.$idTarea.'"', false)
        ->assertSee('id="modal-eliminar-tarea-'.$idTarea.'"', false)
        ->assertSee('action="'.route('tareas.destroy', $idTarea).'"', false)
        ->assertSee('name="_method" value="DELETE"', false)
        ->assertSee('¿Eliminar «Tarea original»?');
});
