<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaLaminaAlmacen extends Model
{
    protected $table = 'entrada_lamina_almacen';

    protected $guarded = ['id'];

    public function consumoDiarioLamina()
    {
        return $this->hasMany(\InventariosLedcor\Models\ConsumoDiarioLamina::class, 'entrada_lamina_almacen_id');
    }

    public function consumoLamina()
    {
        return $this->hasMany(\InventariosLedcor\Models\ConsumoLamina::class, 'entrada_lamina_almacen_id');
    }

    public function kardexRetalLamina()
    {
        return $this->hasMany(\InventariosLedcor\Models\ConsumoKardexRetalLamina::class, 'entrada_lamina_almacen_id');
    }

    public function material()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Material::class, 'material_id');
    }
}
