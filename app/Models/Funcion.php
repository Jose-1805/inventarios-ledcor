<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Funcion extends Model
{
    protected $table = "funciones";

    protected $fillable = [
        'nombre',
        'identificador'
    ];
}
