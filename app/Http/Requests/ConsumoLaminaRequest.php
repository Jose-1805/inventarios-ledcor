<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsumoLaminaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = [
            'entrada_lamina_almacen'=>'required|exists:entrada_lamina_almacen,id',//editar mensaje
            'retal'=>'required|exists:kardex_retal_lamina,id',
            'fecha'=>'required|date',
            'maquina'=>'required|in:Fasti,Müller,Durma,Forming Roll',
            'ensamble'=>'required|in:Fondo,Tanque,Tk Exp.,Tapa,Prensa,Gabinete,Radiador,Mecanizado,Adicional',
            'corte'=>'required|exists:cortes,id',//editar mensaje
            'consumo'=>'required|numeric',
            'desperdicio'=>'required|numeric',
            'consecutivo_retal'=>'numeric|unique:consumo_diario_lamina,consecutivo_retal,'.$this->id.',id',
            'operario'=>'required|exists:users,id',//editar mensaje
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'entrada_lamina_almacen.required'=>'El campo consecutivo lámina es obligatorio',
            'entrada_lamina_almacen.exists'=>'La infomración enviada es incorrecta',

            'corte.required'=>'El campo número de fabricación es obligatorio',
            'corte.exists'=>'La infomración enviada es incorrecta',

            'operario.required'=>'El campo operario es obligatorio',
            'operario.exists'=>'La infomración enviada es incorrecta',

            'retal.required'=>'El campo consecutivo de retal es obligatorio',
            'retal.exists'=>'La información enviada es incorrecta'
        ];
    }
}
