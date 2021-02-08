<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
    protected $table = 'cortes';

    protected $guarded = ['id'];

    public function calculo()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Calculo::class, 'calculo_id');
    }

    public function consumoDiarioLamina()
    {
        return $this->hasMany(\InventariosLedcor\Models\ConsumoDiarioLamina::class, 'corte_id');
    }

    public function consumoLamina()
    {
        return $this->hasMany(\InventariosLedcor\Models\ConsumoLamina::class, 'corte_id');
    }

    public function consumoPerfileria()
    {
        return $this->belongsTo(\InventariosLedcor\Models\ConsumoPerfilerium::class, 'consumo_perfileria_id');
    }

    public function corteLaminaPlacas()
    {
        return $this->hasMany(\InventariosLedcor\Models\ConsumoLaminaRollo::class, 'corte_id');
    }

    public function material()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Material::class, 'material_id');
    }

    public function programaciones()
    {
        return $this->hasMany(\InventariosLedcor\Models\Programacion::class, 'corte_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(\InventariosLedcor\Models\Proyecto::class, 'proyecto_id');
    }

    public function user()
    {
        return $this->belongsTo(\InventariosLedcor\Models\User::class, 'user_id');
    }

    public function asociarDetalles(){
        $detalles = DetalleCalculo::select('detalles_calculos.*')
            ->join('calculos','detalles_calculos.calculo_id','=','calculos.id')
            ->where('calculos.id',$this->calculo_id)
            ->where('calculos.ensamble',$this->ensamble)->get();

        foreach ($detalles as $d){
            $detalle = new DetalleCorte();
            $detalle->posicion = $d->posicion;
            $detalle->plano = $d->plano;
            $detalle->ensamble = $d->ensamble;
            $detalle->nombre = $d->nombre;
            $detalle->cantidad = $d->cantidad;
            $detalle->longitud_1 = $d->longitud_1;
            $detalle->longitud_2 = $d->longitud_2;
            $detalle->centro_corte = $d->centro_corte;
            $detalle->peso_neto = $d->peso_neto;
            $detalle->masa = $d->masa;
            $detalle->proceso = $d->proceso;
            $detalle->observaciones = $d->observaciones;
            $detalle->corte_id = $this->id;
            $detalle->material_id = $d->material_id;
            $detalle->creado_por_relacion = 'si';
            $detalle->save();
        }
    }

    public function desasociarDetalles(){
        DetalleCorte::where('corte_id',$this->id)->where('creado_por_relacion','si')->delete();
    }

    public function permitirEdicion(){
        $fecha_limite = strtotime('+2 days',strtotime($this->created_at));
        $fecha_actual = time();
        if($fecha_actual > $fecha_limite){
            return false;
        }
        return true;
    }
}
