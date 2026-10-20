<?php

namespace App\Http\Controllers;

class ProyectosController extends Controller
{
    public function index()
    {
        // Datos de ejemplo hasta que exista la base de datos (tarea "BD: Creación de la base de datos").
        // Cuando esté lista, sustituir por los proyectos del usuario que ha iniciado sesión.
        $proyectos = [
            [
                'nombre' => 'Trabajo de fin de módulo',
                'descripcion' => 'Memoria y presentación final del módulo de desarrollo web.',
                'rol' => 'Administrador',
                'miembros' => 4,
                'tareas_totales' => 12,
                'tareas_hechas' => 7,
            ],
            [
                'nombre' => 'Torneo de debate',
                'descripcion' => 'Organización de equipos, fechas y materiales del torneo del instituto.',
                'rol' => 'Colaborador',
                'miembros' => 6,
                'tareas_totales' => 9,
                'tareas_hechas' => 2,
            ],
            [
                'nombre' => 'Proyecto de robótica',
                'descripcion' => 'Montaje del robot y entrega de la documentación técnica.',
                'rol' => 'Colaborador',
                'miembros' => 3,
                'tareas_totales' => 5,
                'tareas_hechas' => 5,
            ],
        ];

        return view('proyectos', ['proyectos' => $proyectos]);
    }
}
