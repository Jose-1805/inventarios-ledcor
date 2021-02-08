<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = "modulos";

    protected $fillable = [
        'nombre',
        'identificador',
        'etiqueta',
        'url',
        'estado',
    ];

    public function funciones(){
        return $this->belongsToMany(Funcion::class,'modulos_funciones','modulo_id','funcion_id');
    }

    public function tieneFuncion($id){
        $response = $this->funciones()->where("funciones.id",$id)->get()->count();
        if($response)return true;

        return false;
    }
}
