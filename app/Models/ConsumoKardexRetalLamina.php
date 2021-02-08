<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class ConsumoKardexRetalLamina extends Model
{
    protected $table = 'kardex_retal_lamina';

    protected $guarded = ['id'];

    public function entradaLaminaAlmacen()
    {
        return $this->belongsTo(\InventariosLedcor\Models\EntradaLaminaAlmacen::class, 'entrada_lamina_almacen_id');
    }

    public function formaRetal()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Archivo::class, 'forma_retal_id');
    }

    public function quienGasta()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'quien_gasta');
    }

    public function quienGenera()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'quien_genera');
    }

    public static function ultimoConsecutivoRetal(){
        $consecutivo = 0;
        $consecutivo_retal = ConsumoKardexRetalLamina::orderBy('consecutivo_retal','DESC')->first();
        if($consecutivo_retal)$consecutivo = $consecutivo_retal->consecutivo_retal;
        return $consecutivo;
    }
}
