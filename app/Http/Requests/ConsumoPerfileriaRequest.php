<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsumoPerfileriaRequest extends FormRequest
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
            'corte'=>'required|exists:cortes,id',//editar mensaje
            'fecha'=>'required|date',
            'ensamble'=>'required|in:Tanque,Prensa,Perfileria,Adicional,Mecanizado,RadMZ,RadTB,Daño de máquina',
            'cantidad'=>'required|numeric',
            'medida'=>'required|numeric',
            'material'=>'required|exists:materiales,id',//editar mensaje
            'quien_solicito'=>'required|exists:users,id',//editar mensaje
            'cliente'=>'required|exists:clientes,id',//editar mensaje
            'quien_entrego'=>'required|exists:users,id',//editar mensaje
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'corte.required'=>'El campo número de fabricación es obligatorio',
            'corte.exists'=>'La infomración enviada es incorrecta',

            'material.required'=>'El campo material es obligatorio',
            'material.exists'=>'La infomración enviada es incorrecta',

            'quien_solicito.required'=>'El campo quien solicitó es obligatorio',
            'quien_solicito.exists'=>'La infomración enviada es incorrecta',

            'cliente.required'=>'El campo cliente interno es obligatorio',
            'cliente.exists'=>'La infomración enviada es incorrecta',

            'quien_entrego.required'=>'El campo quien entregó es obligatorio',
            'quien_entrego.exists'=>'La infomración enviada es incorrecta',
        ];
    }
}
