<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tarea extends Model
{
    protected $table = 'tarea';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_limite',
        'id_estado',
        'id_proyecto',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_limite' => 'date',
    ];

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class, 'id_estado');
    }

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            Usuario::class,
            'usuario_asignado',
            'id_tarea',
            'id_usuario'
        );
    }
}