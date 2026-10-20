<?php

test('la guia de estilos se muestra en local y en tests', function () {
    $this->withoutVite();

    $this->get('/guia-estilos')
        ->assertOk()
        ->assertViewIs('guia-estilos')
        ->assertSee('Guía de estilos')
        ->assertSee('Colores del manual');
});

test('la guia de estilos no esta disponible en produccion', function () {
    $this->withoutVite();
    $this->app['env'] = 'production';

    $this->get('/guia-estilos')->assertNotFound();
});
