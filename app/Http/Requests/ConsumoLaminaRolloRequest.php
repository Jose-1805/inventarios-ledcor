<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsumoLaminaRolloRequest extends FormRequest
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
            'inventario_lamina_rollo'=>'required|exists:inventario_lamina_rollo,id',//editar mensaje
            'fecha'=>'required|date',
            'ensamble'=>'required|in:Tanque,Prensa,Perfileria,Adicional,Mecanizado,RadMZ,RadTB,Daño de máquina',
            'maquina'=>'required|in:Fasti,Müller,Durma,Forming Roll',
            'cantidad'=>'required|integer',
            'medida'=>'required|integer',
            'maquina_destino'=>'required|in:Trumpf,Arima,Edel,Dobladora,Otra',
            'corte'=>'required|exists:cortes,id',//editar mensaje
            'quien_corta'=>'required|exists:users,id',//editar mensaje
            'quien_recibe'=>'required|exists:users,id',//editar mensaje
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'inventario_lamina_rollo.required'=>'El campo consecutivo rollo es obligatorio',
            'inventario_lamina_rollo.exists'=>'La infomración enviada es incorrecta',

            'corte.required'=>'El campo número de fabricación es obligatorio',
            'corte.exists'=>'La infomración enviada es incorrecta',

            'quien_corta.required'=>'El campo quien corta es obligatorio',
            'quien_corta.exists'=>'La infomración enviada es incorrecta',

            'quien_recibe.required'=>'El campo quien recibe a es obligatorio',
            'quien_recibe.exists'=>'La infomración enviada es incorrecta',
        ];
    }
}
