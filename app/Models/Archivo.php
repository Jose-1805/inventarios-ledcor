<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'archivos';


    protected $fillable = [
        'nombre',
        'ubicacion',
    ];

}
