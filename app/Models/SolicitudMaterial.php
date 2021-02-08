<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudMaterial extends Model
{
    protected $table = 'solicitudes_materiales';

    protected $guarded = ['id'];

    public function material()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Material::class, 'material_id');
    }

    public function solicitud(){
        return $this->belongsTo(Solicitud::class,'solicitud_id');
    }
}
