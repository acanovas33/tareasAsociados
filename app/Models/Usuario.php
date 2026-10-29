<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';
    public $timestamps = false;

    

    public function tareas(): BelongsToMany
    {
        return $this->belongsToMany(
            Tarea::class,
            'usuario_asignado',
            'id_usuario',
            'id_tarea'
        );
    }

    public function proyectoRoles(): HasMany
    {
        return $this->hasMany(UsuarioProyectoRol::class, 'id_usuario');
    }

    public function proyectos(): BelongsToMany
    {
        return $this->belongsToMany(
            Proyecto::class,
            'usuario_proyecto_rol',
            'id_usuario',
            'id_proyecto'
        )->withPivot('id_rol');
    }
}