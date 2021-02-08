<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoLaminaSinProcesarRequest extends FormRequest
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
            'cantidad'=>'required|integer',
            'material'=>'required|exists:materiales,id',//editar mensaje
            'solicitud'=>'required|exists:solicitudes,id',//editar mensaje
            'espesor_mm'=>'required|numeric',
            'peso_por_lamina'=>'required|numeric',//editar mensaje
            'orden_compra'=>'required|exists:ordenes_compras,id',//editar mensaje
            'lote'=>'required|numeric',
            'peso_guacal'=>'required|numeric',
            'largo'=>'required|numeric',
            'ancho'=>'required|numeric',
            'operario'=>'required|exists:users,id',//editar mensaje
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'material.required'=>'El campo material es obligatorio',
            'material.exists'=>'La infomración enviada es incorrecta',

            'peso_por_lamina.required'=>'El campo peso làmina es obligatorio',
            'peso_por_lamina.numeric'=>'El campo peso làmina debe ser de tipo númerico',

            'orden_compra.required'=>'El campo orden de compra es obligatorio',
            'orden_compra.exists'=>'La infomración enviada es incorrecta',

            'operario.required'=>'El campo operario es obligatorio',
            'operario.exists'=>'La infomración enviada es incorrecta',
        ];
    }
}
