<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UsuarioProyectoRol extends Model
{
    protected $table = 'usuario_proyecto_rol';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null; // clave compuesta: Eloquent no la soporta de forma nativa


    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}