<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'alias',
        'direccion',
        'user_id',
    ];

}
