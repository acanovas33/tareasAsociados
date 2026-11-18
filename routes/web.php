<?php

use App\Http\Controllers\GuiaEstilosController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('registro');
});

Route::get('/saludos/{nombre?}', function ($nombre = 'invitado') {
    return 'Bienvenido a laravel '.$nombre;
})->name('saludo');


Route::get('/proyectos', [ProyectosController::class, 'index'])->middleware('auth')->name('proyectos.index');

Route::get('/guia-estilos', [GuiaEstilosController::class, 'index'])->name('guia-estilos.index');

Route::get('/perfil/editar', [PerfilController::class, 'edit'])->middleware('auth')->name('perfil.edit');

Route::put('/perfil', [PerfilController::class, 'update'])->middleware('auth')->name('perfil.update');

Route::put('/perfil/contrasena', [PerfilController::class, 'updatePassword'])
    ->middleware('auth')
    ->name('perfil.password.update');

Route::get('/registro', [RegistroController::class, 'create'])->name('registro.create');
Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');
Route::get('/registrocorrecto', [RegistroController::class, 'correcto'])->name('registrocorrecto');

Route::get('/tareas/{proyecto}', [TareaController::class, 'index'])->name('tareas.index');

Route::get('/login', [LoginController::class, 'mostrarLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::post('/proyectos', [ProyectosController::class, 'store'])->middleware('auth')->name('proyectos.store');
Route::post('/proyectos/{proyecto}/colaboradores', [ProyectosController::class, 'agregarColaborador'])
    ->middleware('auth')
    ->name('proyectos.colaboradores.store');