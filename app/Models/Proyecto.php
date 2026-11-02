<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    protected $table = 'proyecto';
    public $timestamps = false;

    protected $fillable = ['nombre'];

    public function tareas(): HasMany
    {
        return $this->hasMany(Tarea::class, 'id_proyecto');
    }

    public function usuarioRoles(): HasMany
    {
        return $this->hasMany(UsuarioProyectoRol::class, 'id_proyecto');
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            Usuario::class,
            'usuario_proyecto_rol',
            'id_proyecto',
            'id_usuario'
        )->withPivot('id_rol');
    }
}