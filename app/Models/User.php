<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $guarded = ['id'];

    public function imagen()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Archivo::class, 'archivo_id');
    }

    public function clientes()
    {
        return $this->hasMany(\InventariosLedcor\Models\Cliente::class, 'user_id');
    }

    public function consumosDiariosLaminas()
    {
        return $this->hasMany(\InventariosLedcor\Models\ConsumoDiarioLamina::class, 'operario_id');
    }

    public function consumosLaminas()
    {
        return $this->hasMany(\InventariosLedcor\Models\ConsumoLamina::class, 'operario_id');
    }


    public function cortes()
    {
        return $this->hasMany(\InventariosLedcor\Models\Corte::class, 'user_id');
    }

    public function ordenesCompras()
    {
        return $this->hasMany(\InventariosLedcor\Models\OrdenCompra::class, 'user_id');
    }

    public function rol()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Role::class, 'rol_id');
    }
}
