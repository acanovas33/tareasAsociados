<?php

use App\Http\Controllers\GuiaEstilosController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\RegistroController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('registro');
});

Route::get('/saludos/{nombre?}', function ($nombre = "invitado"){
    return "Bienvenido a laravel " . $nombre;
})->name("saludo");

Route::get('/registro', [RegistroController::class, 'index']);

Route::get('/proyectos', [ProyectosController::class, 'index'])->name('proyectos.index');

Route::get('/guia-estilos', [GuiaEstilosController::class, 'index'])->name('guia-estilos.index');
