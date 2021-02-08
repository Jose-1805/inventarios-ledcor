<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class InventarioLaminaRollo extends Model
{
    protected $table = 'inventario_lamina_rollo';
    public $timestamps = false;

    protected $guarded = ['id'];

    public function corteLaminaPlacas()
    {
        return $this->hasMany(\InventariosLedcor\Models\ConsumoLaminaRollo::class, 'inventario_lamina_rollo_id');
    }

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
