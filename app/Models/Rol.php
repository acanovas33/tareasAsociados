<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    protected $table = 'rol';
    public $timestamps = false;


    public function usuarioProyectos(): HasMany
    {
        return $this->hasMany(UsuarioProyectoRol::class, 'id_rol');
    }
}