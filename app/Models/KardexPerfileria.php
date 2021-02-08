<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class KardexPerfileria extends Model
{
    protected $table = 'inventario_kardex_perfileria';

    protected $guarded = ['id'];

    public function consumosPerfilerias()
    {
        return $this->hasMany(\InventariosLedcor\Models\ConsumoPerfilerium::class, 'inventario_kardex_perfileria_id');
    }

    public function entregaA()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'entrega_a');
    }

    public function material()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Material::class, 'material_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Proveedor::class, 'proveedor_id');
    }

    public function recibeA()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'recibe_a');
    }
}
