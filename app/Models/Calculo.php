<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Calculo extends Model
{
    protected $table = 'calculos';

    protected $guarded = ['id'];

    public function cortes()
    {
        return $this->hasMany(\InventariosLedcor\Models\Corte::class, 'calculo_id');
    }

    public function detalles()
    {
        return $this->hasMany(\InventariosLedcor\Models\DetalleCalculo::class, 'calculo_id');
    }
}
