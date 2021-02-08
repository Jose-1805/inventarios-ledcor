<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsumoRetalLaminaRequest extends FormRequest
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
            'fecha'=>'required|date',
            'cantidad'=>'required|integer',
            'largo'=>'required|integer',
            'ancho'=>'required|integer',
            'peso'=>'required|numeric',
            'fecha_ingreso'=>'required|date',
            'quien_gasta'=>'required|exists:users,id',//editar mensaje
            'forma_retal'=>'required|file|max:500',
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'entrada_lamina_almacen.required'=>'El campo consecutivo lámina es obligatorio',
            'entrada_lamina_almacen.exists'=>'La infomración enviada es incorrecta',

            'quien_genera.required'=>'El campo quien genera es obligatorio',
            'quien_genera.exists'=>'La infomración enviada es incorrecta',

            'quien_gasta.required'=>'El campo quien gasta es obligatorio',
            'quien_gasta.exists'=>'La infomración enviada es incorrecta',
        ];
    }
}
