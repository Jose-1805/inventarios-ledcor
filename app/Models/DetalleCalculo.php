<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCalculo extends Model
{
    protected $table = 'detalles_calculos';

    public function calculo(){
        return $this->belongsTo(Calculo::class,'calculo_id');
    }

    public function material(){
        return $this->belongsTo(Material::class,'material_id');
    }
}
