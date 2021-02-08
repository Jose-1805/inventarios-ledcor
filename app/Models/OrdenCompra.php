<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    protected $table = 'ordenes_compras';

    protected $fillable = [
        'numero',
        'fecha',
        'posicion',
        'codigo_mecanizado',
        'descripcion',
        'cantidad_requerida',
        'fecha_entrega_requerida',
        'observacion',
        'proyecto_id',
        'cliente_id',
        'user_id',
    ];

}
