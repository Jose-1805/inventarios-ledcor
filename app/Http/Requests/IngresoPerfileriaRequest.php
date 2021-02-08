<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoPerfileriaRequest extends FormRequest
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
            'fecha_recibido'=>'required|date',
            'cantidad'=>'required|numeric',
            'material'=>'required|exists:materiales,id',//editar mensaje
            'entrega_a'=>'required|exists:users,id',//editar mensaje
            'recibe_a'=>'required|exists:users,id',//editar mensaje
            'proveedor'=>'required|exists,proveedores,id',//editar mensaje
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'material.required'=>'El campo material es obligatorio',
            'material.exists'=>'La infomración enviada es incorrecta',

            'entrega_a.required'=>'El campo entrega a es obligatorio',
            'entrega_a.exists'=>'La infomración enviada es incorrecta',

            'recibe_a.required'=>'El campo recibe a es obligatorio',
            'recibe_a.exists'=>'La infomración enviada es incorrecta',

            'proveedor.required'=>'El campo proveedor es obligatorio',
            'proveedor.exists'=>'La infomración enviada es incorrecta',
        ];
    }
}
