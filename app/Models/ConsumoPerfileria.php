<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumoPerfileria extends Model
{
    protected $table = 'consumo_perfileria';

    protected $guarded = ['id'];

    public function cortes()
    {
        return $this->hasMany(\InventariosLedcor\Models\Corte::class, 'consumo_perfileria_id');
    }

    public function inventarioKardexPerfileria()
    {
        return $this->belongsTo(\InventariosLedcor\Models\InventarioKardexPerfilerium::class, 'inventario_kardex_perfileria_id');
    }

    public function cliente()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Cliente::class, 'cliente_id');
    }

    public function quienEntrego()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'quien_entrego');
    }

    public function quienSolicito()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'quien_solicito');
    }

    public function material(){
        return $this->belongsTo(Material::class,'material_id');
    }
}
