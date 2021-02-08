<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoLaminaRolloRequest extends FormRequest
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
            'material'=>'required|exists:materiales,id',//editar mensaje
            'fecha_recibido'=>'required|date',
            'solicitud'=>'required|exists:solicitudes,id',//editar mensaje
            'peso_validado'=>'required|numeric',
            'espesor_validado'=>'required|numeric',
            'peso_sin_validar'=>'required|numeric',
            'lote'=>'required|max:150',
            'no_identificacion_rollo'=>'required|max:150',//editar mensaje
            'fecha_rollo'=>'required|date',
            'proveedor'=>'required|exists:proveedores,id',//editar mensaje
            'norma'=>'required|max:150',
            'ancho_rollo'=>'required|integer',
            'orden_compra'=>'required|exists:ordenes_compras,id',//editar mensaje
            'consecutivo_rollo'=>'required|max:150',
            'operario'=>'required|exists:users,id',//editar mensaje
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'material.required'=>'El campo material es obligatorio',
            'material.exists'=>'La infomración enviada es incorrecta',

            'no_identificacion_rollo.required'=>'El campo número de identificación rollo es obligatorio',
            'no_identificacion_rollo.max'=>'El campo número de identificación rollo puede tener 150 caracteres como máximo',

            'proveedor.required'=>'El campo proveedor es obligatorio',
            'proveedor.exists'=>'La infomración enviada es incorrecta',

            'orden_compra.required'=>'El campo orden de compra es obligatorio',
            'orden_compra.exists'=>'La infomración enviada es incorrecta',

            'operario.required'=>'El campo operario es obligatorio',
            'operario.exists'=>'La infomración enviada es incorrecta',
        ];
    }
}
