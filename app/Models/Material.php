<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales';

    protected $guarded = ['id'];

    public function cortesViaMaterialId()
    {
        return $this->hasMany(\InventariosLedcor\Models\Corte::class, 'material_id');
    }

    public function entradasLaminasAlmacenes()
    {
        return $this->hasMany(\InventariosLedcor\Models\EntradaLaminaAlmacen::class, 'material_id');
    }

    public function inventariosKardexPerfilerias()
    {
        return $this->hasMany(\InventariosLedcor\Models\InventarioKardexPerfilerium::class, 'material_id');
    }

    public function inventariosLaminasRollos()
    {
        return $this->hasMany(\InventariosLedcor\Models\InventarioLaminaRollo::class, 'material_id');
    }

    public function recepcionesLaminasAntesProcesar()
    {
        return $this->hasMany(\InventariosLedcor\Models\RecepcionLaminaAnteProcesar::class, 'material_id');
    }

    public function solicitudesMateriales()
    {
        return $this->hasMany(\InventariosLedcor\Models\SolicitudMaterial::class, 'material_id');
    }
}
