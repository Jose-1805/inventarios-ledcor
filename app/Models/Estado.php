<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';

    protected $guarded = ['id'];

    public function programaciones()
    {
        return $this->hasMany(\InventariosLedcor\Models\Programacion::class, 'estado_id');
    }
}
