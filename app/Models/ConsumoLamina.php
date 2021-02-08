<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumoLamina extends Model
{
    protected $table = 'consumo_lamina';

    protected $guarded = ['id'];

    public function corte()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Corte::class, 'corte_id');
    }

    public function entradaLaminaAlmacen()
    {
        return $this->belongsTo(\InventariosLedcor\Models\EntradaLaminaAlmacen::class, 'entrada_lamina_almacen_id');
    }

    public function operario()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'operario_id');
    }
}
