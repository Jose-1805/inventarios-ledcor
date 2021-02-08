<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyectos';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'cliente_id',
        'user_id',
    ];

}
