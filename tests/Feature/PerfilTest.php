<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    Schema::dropIfExists('usuario');
    Schema::create('usuario', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('correo');
        $table->string('contrasena');
    });
});

test('la página de perfil muestra los datos de la fila con id uno', function () {
    $this->withoutVite();
    DB::table('usuario')->insert([
        ['id' => 1, 'nombre' => 'Nombre real', 'correo' => 'real@devsprint.test', 'contrasena' => 'hash'],
        ['id' => 2, 'nombre' => 'Otro usuario', 'correo' => 'otro@devsprint.test', 'contrasena' => 'hash'],
    ]);

    $this->get(route('perfil.edit'))
        ->assertOk()
        ->assertViewIs('editar-perfil')
        ->assertSee('value="Nombre real"', false)
        ->assertSee('value="real@devsprint.test"', false)
        ->assertSee(route('perfil.update'))
        ->assertSee(route('perfil.password.update'));
});
