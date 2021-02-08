<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCorte extends Model
{
    protected $table = 'detalles_cortes';

    public function corte(){
        return $this->belongsTo(Corte::class,'corte_id');
    }
}
