<?php

use App\Models\Usuario;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    // Esquema provisional de las tablas, hasta que el modelo de BD esté confirmado
    foreach (['usuario_proyecto_rol', 'rol', 'proyecto', 'usuario'] as $tabla) {
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
    Schema::create('rol', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
    });
    Schema::create('usuario_proyecto_rol', function (Blueprint $table) {
        $table->unsignedBigInteger('id_usuario');
        $table->unsignedBigInteger('id_proyecto');
        $table->unsignedBigInteger('id_rol')->nullable();
    });

    DB::table('usuario')->insert([
        ['id' => 1, 'nombre' => 'Administradora', 'correo' => 'admin@devsprint.test', 'contrasena' => 'hash'],
        ['id' => 2, 'nombre' => 'Colaborador', 'correo' => 'colabora@devsprint.test', 'contrasena' => 'hash'],
        ['id' => 3, 'nombre' => 'Ajena', 'correo' => 'ajena@devsprint.test', 'contrasena' => 'hash'],
    ]);
    DB::table('rol')->insert([['id' => 1, 'nombre' => 'Administrador'], ['id' => 2, 'nombre' => 'Colaborador']]);
    DB::table('proyecto')->insert([['id' => 1, 'nombre' => 'DevSprint'], ['id' => 2, 'nombre' => 'Proyecto de otra persona']]);
    DB::table('usuario_proyecto_rol')->insert([
        ['id_usuario' => 1, 'id_proyecto' => 1, 'id_rol' => 1],
        ['id_usuario' => 2, 'id_proyecto' => 1, 'id_rol' => 2],
        ['id_usuario' => 2, 'id_proyecto' => 2, 'id_rol' => 1],
        ['id_usuario' => 1, 'id_proyecto' => 2, 'id_rol' => 2],
    ]);
});

test('quien administra el proyecto le cambia el nombre', function () {
    $this->actingAs(Usuario::find(1))
        ->put(route('proyectos.update', 1), ['nombre' => 'DevSprint 2.0'])
        ->assertRedirect(route('proyectos.index'))
        ->assertSessionHas('status', 'Proyecto actualizado correctamente.');

    $this->assertDatabaseHas('proyecto', ['id' => 1, 'nombre' => 'DevSprint 2.0']);
});

test('el nombre del proyecto es obligatorio y no puede ser muy largo', function () {
    $this->actingAs(Usuario::find(1))
        ->put(route('proyectos.update', 1), ['nombre' => ''])
        ->assertSessionHasErrorsIn('editarProyecto-1', ['nombre' => 'El nombre del proyecto es obligatorio.']);

    $this->actingAs(Usuario::find(1))
        ->put(route('proyectos.update', 1), ['nombre' => str_repeat('a', 256)])
        ->assertSessionHasErrorsIn('editarProyecto-1', ['nombre']);

    $this->assertDatabaseHas('proyecto', ['id' => 1, 'nombre' => 'DevSprint']);
});

test('un colaborador o alguien ajeno no puede editar el proyecto', function (int $idUsuario) {
    $this->actingAs(Usuario::find($idUsuario))
        ->put(route('proyectos.update', 1), ['nombre' => 'Cambiado'])
        ->assertForbidden();

    $this->assertDatabaseHas('proyecto', ['id' => 1, 'nombre' => 'DevSprint']);
})->with(['colaborador' => 2, 'ajena' => 3]);

test('sin iniciar sesión se va al login', function () {
    $this->put(route('proyectos.update', 1), ['nombre' => 'Cambiado'])
        ->assertRedirect(route('login'));

    $this->assertDatabaseHas('proyecto', ['id' => 1, 'nombre' => 'DevSprint']);
});

test('el botón y el pop-up relleno solo salen en los proyectos que administras', function () {
    $this->withoutVite();

    $respuesta = $this->actingAs(Usuario::find(1))->get(route('proyectos.index'))->assertOk();

    $respuesta->assertSeeHtml('data-abrir-modal="modal-editar-proyecto-1"')
        ->assertSeeHtml('<dialog id="modal-editar-proyecto-1"')
        ->assertSeeHtml('value="DevSprint"');
    // En el proyecto 2 es colaboradora: no puede editarlo
    $respuesta->assertDontSeeHtml('modal-editar-proyecto-2');
});

test('si hay errores se vuelve a abrir solo el pop-up de ese proyecto con lo escrito', function () {
    $this->withoutVite();
    DB::table('usuario_proyecto_rol')->where(['id_usuario' => 1, 'id_proyecto' => 2])->update(['id_rol' => 1]);

    $this->actingAs(Usuario::find(1))
        ->from(route('proyectos.index'))
        ->put(route('proyectos.update', 1), ['nombre' => str_repeat('a', 256)])
        ->assertRedirect(route('proyectos.index'));

    $html = $this->actingAs(Usuario::find(1))->get(route('proyectos.index'))->getContent();

    expect($html)->toMatch('/<dialog id="modal-editar-proyecto-1"[^>]*data-abrir-al-cargar/');
    expect($html)->not->toMatch('/<dialog id="modal-editar-proyecto-2"[^>]*data-abrir-al-cargar/');
    expect($html)->toContain('El nombre del proyecto no puede superar 255 caracteres.');
});
