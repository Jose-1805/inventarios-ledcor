<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class LaminaAntesProcesar extends Model
{
    protected $table = 'recepcion_lamina_antes_procesar';

    protected $guarded = ['id'];

    public function material()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Material::class, 'material_id');
    }

    public function operario()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'operario_id');
    }

    public function ordenCompra()
    {
        return $this->belongsTo(\InventariosLedcor\Models\OrdenCompra::class, 'orden_compra_id');
    }
}
