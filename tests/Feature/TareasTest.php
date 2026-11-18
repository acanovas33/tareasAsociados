<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    // Esquema provisional de las tablas, hasta que el modelo de BD esté confirmado
    foreach (['usuario_asignado', 'tarea', 'estado', 'proyecto', 'usuario'] as $tabla) {
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
        $table->date('fecha_limite')->nullable();
        $table->unsignedBigInteger('id_proyecto');
        $table->unsignedBigInteger('id_estado');
    });
    Schema::create('usuario_asignado', function (Blueprint $table) {
        $table->unsignedBigInteger('id_tarea');
        $table->unsignedBigInteger('id_usuario');
    });

    DB::table('proyecto')->insert(['id' => 1, 'nombre' => 'Proyecto de prueba']);
    DB::table('estado')->insert([['id' => 1, 'nombre' => 'Por hacer'], ['id' => 2, 'nombre' => 'En progreso']]);
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
