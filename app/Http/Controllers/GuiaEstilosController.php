<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class GuiaEstilosController extends Controller
{
    /**
     * Página de muestra del sistema de diseño. Solo disponible en local y en tests.
     */
    public function index(): View
    {
        abort_unless(app()->environment(['local', 'testing']), 404);

        return view('guia-estilos');
    }
}
