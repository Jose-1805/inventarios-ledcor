<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'alias',
        'direccion',
        'user_id',
    ];

}
