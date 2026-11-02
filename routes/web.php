<?php

use App\Http\Controllers\GuiaEstilosController;
use App\Http\Controllers\PerfilController;
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

Route::get('/perfil/editar', [PerfilController::class, 'edit'])->name('perfil.edit');

Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');

Route::put('/perfil/contrasena', [PerfilController::class, 'updatePassword'])->name('perfil.password.update');
