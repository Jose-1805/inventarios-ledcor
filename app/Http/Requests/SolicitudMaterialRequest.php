<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudMaterialRequest extends FormRequest
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
            'material'=>'required|filled|exists:materiales,id',//editar mensaje
            'um'=>'required|in:Kg,m',
            'cantidad'=>'required|integer',
            //'cantidad_entregada'=>'required|numeric',
            'lote'=>'required|max:150'
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'material.required'=>'El campo material es obligatorio',
            'material.exists'=>'La infomración enviada es incorrecta',
        ];
    }
}
