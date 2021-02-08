<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoLaminaRequest extends FormRequest
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
            'consecutivo_lamina'=>'required|numeric',
            'material'=>'required|exists:materiales,id',//editar mensaje
            'espesor_lote'=>'required|numeric',
            'peso_lamina_validado'=>'required|numeric',
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'material.required'=>'El campo código material es obligatorio',
            'material.exists'=>'La infomración enviada es incorrecta',

            'consecutivo_lamina.required'=>'El campo consecutivo lámina es obligatorio',
            'consecutivo_lamina.numeric'=>'El campo consecutivo lámina debe ser numérico',

            'peso_lamina_validado.required'=>'El campo peso lámina validado es obligatorio',
            'peso_lamina_validado.numeric'=>'El campo peso lámina validado debe ser numérico',
        ];
    }
}
