<?php

test('la pagina de proyectos responde correctamente', function () {
    $this->withoutVite();

    $this->get('/proyectos')
        ->assertOk()
        ->assertViewIs('proyectos')
        ->assertSee('Mis proyectos')
        ->assertSee('Nuevo proyecto');
});

test('la pagina de proyectos muestra el nombre, el rol y el progreso de cada proyecto', function () {
    $this->withoutVite();

    $this->view('proyectos', ['proyectos' => [[
        'nombre' => 'Proyecto de prueba',
        'descripcion' => 'Descripcion de prueba',
        'rol' => 'Administrador',
        'miembros' => 3,
        'tareas_totales' => 4,
        'tareas_hechas' => 1,
    ]]])
        ->assertSee('Proyecto de prueba')
        ->assertSee('Administrador')
        ->assertSee('25%')
        ->assertSee('1 de 4 tareas hechas');
});

test('la pagina de proyectos muestra un mensaje cuando no hay proyectos', function () {
    $this->withoutVite();

    $this->view('proyectos', ['proyectos' => []])
        ->assertSee('Todavía no tienes proyectos');
});

test('un proyecto sin tareas muestra el progreso a cero', function () {
    $this->withoutVite();

    $this->view('proyectos', ['proyectos' => [[
        'nombre' => 'Proyecto vacio',
        'descripcion' => 'Sin tareas todavia',
        'rol' => 'Colaborador',
        'miembros' => 1,
        'tareas_totales' => 0,
        'tareas_hechas' => 0,
    ]]])
        ->assertSee('0%')
        ->assertSee('0 de 0 tareas hechas');
});
