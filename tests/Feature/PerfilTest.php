<?php

use App\Models\User;

test('la página de perfil muestra las acciones de actualización', function () {
    $this->withoutVite();
    $usuario = User::factory()->make();
    $this->actingAs($usuario);

    $this->get(route('perfil.edit'))
        ->assertOk()
        ->assertViewIs('editar-perfil')
        ->assertSee(route('perfil.update'))
        ->assertSee(route('perfil.password.update'));
});
