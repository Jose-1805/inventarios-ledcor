<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $guarded = ['id'];

    public function solicitudMateriales(){
        return $this->hasMany(SolicitudMaterial::class,'solicitud_id');
    }

    public function materiales(){
        return $this->belongsToMany(Material::class,'solicitudes_materiales','solicitud_id','material_id');
    }

    /**
     * Determina la cantidad de material que no ha sido registrado
     * en la solicitud correspondiente al objeto de la clase
     *
     * @param $material_id
     */
    public function cantidadMaterialDisponible($material_id){
        $cantidad_entregada = $this->solicitudMateriales()->where('material_id',$material_id)->sum('cantidad');
        $rollos = InventarioLaminaRollo::where('solicitud_id',$this->id)->where('material_id',$material_id)->sum('peso_validado');
        $laminas = LaminaAntesProcesar::select('recepcion_lamina_antes_procesar.*',DB::raw('(peso_por_lamina * cantidad * largo) as total'))->where('solicitud_id',$this->id)->where('material_id',$material_id)->get()->sum('total');
        return $cantidad_entregada - ($rollos + $laminas);
    }

    public static function ultimaSolicitud(){
        return Solicitud::orderBy('numero','DESC')->first();
    }
}
