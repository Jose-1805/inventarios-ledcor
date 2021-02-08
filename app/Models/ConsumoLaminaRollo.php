<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumoLaminaRollo extends Model
{
    protected $table = 'corte_lamina_placas';

    protected $guarded = ['id'];

    public function corte()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Corte::class, 'corte_id');
    }

    public function inventarioLaminaRollo()
    {
        return $this->belongsTo(\InventariosLedcor\Models\InventarioLaminaRollo::class, 'inventario_lamina_rollo_id');
    }

    public function quienCorta()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'quien_corta');
    }

    public function quienRecibe()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'quien_recibe');
    }
}
