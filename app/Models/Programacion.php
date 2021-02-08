<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Programacion extends Model
{
    protected $table = 'programaciones';

    protected $guarded = ['id'];

    public function corte()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Corte::class, 'corte_id');
    }

    public function estado()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Estado::class, 'estado_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Proyecto::class, 'proyecto_id');
    }

    public function anexos(){
        return $this->hasMany(Archivo::class,'programacion_id');
    }
}
