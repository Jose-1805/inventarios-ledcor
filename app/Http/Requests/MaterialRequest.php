<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
            'familia'=>'required|max:250',
            'unidad_medida'=>'required|max:150',
            'presentacion'=>'required|max:250',//editar mensaje
            'especificacion'=>'required|max:250',//editar mensaje
            'codigo'=>'required|max:150',//editar mensaje
            'texto_breve'=>'required|max:150',
            'codigo_plano'=>'required|max:150',//editar mensaje
            'valor_unidad'=>'required|numeric',
            'espesor_mm'=>'required|numeric',
            'unidad_solicitud'=>'required|in:Rollo,Guacal,Pieza,mts,lámina',
            'cantidad'=>'required|numeric',
        ];
        return $data;
    }

    public function messages()
    {
        return [
          'presentacion.required'=>'El campo presentación es obligatorio',
          'presentacion.max'=>'El campo presentación puede contener máximo 250 caracteres',

          'especificacion.required'=>'El campo especificación es obligatorio',
          'especificacion.max'=>'El campo especificación puede contener máximo 250 caracteres',

          'codigo.required'=>'El campo código es obligatorio',
          'codigo.max'=>'El campo código puede contener máximo 150 caracteres',

          'codigo_plano.required'=>'El campo código plano es obligatorio',
          'codigo_plano.max'=>'El campo código plano puede contener máximo 150 caracteres',
        ];
    }
}

/*

//REQUEST DE MATERIALES
$data = [
    'familia'=>'required|max:250',
    'unidad_medida'=>'required|max:150',
    'presentacion'=>'required|max:250',//editar mensaje
    'especificacion'=>'required|max:250',//editar mensaje
    'codigo'=>'required|max:150',//editar mensaje
    'texto_breve'=>'required|max:150',
    'codigo_plano'=>'required|max:150',//editar mensaje
    'valor_unidad'=>'required|numeric',
    'espesor_mm'=>'required|numeric',
]

//REQUEST DE SOLICITUD DE MATERIALES
$data = [
    'fecha'=>'required|date',
    'material'=>'required|exists:materiales,id',//editar mensaje
    'um'=>'required|in:Kg,m',
    'cantidad'=>'required|integer',
    'cantidad_entregada'=>'required|numeric',
    'lote'=>'requierd|max:150'
]

//REQUEST DE INGRESO DE LAMINA EN ROLLO
$data = [
    'maerial'=>'required|exists:materiales,id',//editar mensaje
    'fecha_recibido'=>'required|date',
    'peso_sin_validar'=>'required|numeric',
    'peso_validado'=>'required|numeric',
    'lote'=>'required|max:150',
    'no_identificacion_rollo'=>'required|max:150',//editar mensaje
    'fecha_rollo'=>'required|date',
    'proveedor'=>'required|exists:proveedores,id',//editar mensaje
    'norma'=>'required|max:150',
    'ancho_rollo'=>'required|integer',
    'orden_compra'=>'required|exists:ordenes_compras,id',//editar mensaje
    'consecutivo_rollo'=>'required|max:150',
    'operario'=>'required|exists:users,id',//editar mensaje
]

//REQUEST DE INGRESO DE LAMINA SIN PROCESAR
$data = [
    'fecha_recibido'=>'required|date',
    'cantidad'=>'required|integer',
    'material'=>'required|exists:materiales,id',//editar mensaje
    'espesor_mm'=>'required|numeric',
    'peso_lamina'=>'required|numeric',//editar mensaje
    'orden_compra'=>'required|exists:ordenes_compras,id',//editar mensaje
    'lote'=>'required|numeric',
    'peso_guacal'=>'required|numeric',
    'operario'=>'required|exists:users,id',//editar mensaje
]

//REQUEST DE INGRESO DE PERFILERIA
$data = [
    'fecha_recibido'=>'required|date',
    'cantidad'=>'required|numeric',
    'maerial'=>'required|exists:materiales,id',//editar mensaje
    'entrega_a'=>'required|exists:users,id',//editar mensaje
    'recibe_a'=>'required|exists:users,id',//editar mensaje
    'proveedor'=>'required|exists,proveedores,id',//editar mensaje
]

//REQUEST CONSUMO DE LAMINA EN ROLLO
$data = [
    'inventario_lamina_rollo'=>'required|exists:inventario_lamina_rollo,id',//editar mensaje
    'fecha'=>'required|date',
    'peso_validado'=>'required|numeric',
    'maquina'=>'required|in:Fasti,Müller,Durma,Forming Roll',
    'cantidad'=>'required|integer',
    'medida'=>'required|integer',
    'maquina_destino'=>'required|Trumpf,Arima,Edel,Dobladora,Otra',
    'corte'=>'required|exists:cortes,id',//editar mensaje
    'quien_corta'=>'required|exists:users,id',//editar mensaje
    'quien_recibe'=>'required|exists:users,id',//editar mensaje
]

//REQUEST CONSUMO LAMINA
$data = [
    'entrada_lamina_almacen'=>'reuired|exists:entrada_lamina_almacen,id',//editar mensaje
    'fecha'=>'reuired|date',
    'maquina'=>'reuired|in:Fasti,Müller,Durma,Forming Roll',
    'ensamble'=>'reuired|in:Fondo,Tanque,Tk Exp.,Tapa,Prensa,Gabinete,Radiador,Mecanizado,Adicional',
    'corte'=>'reuired|exists:cortes,id',//editar mensaje
    'consumo'=>'reuired|numeric',
    'desperdicio'=>'reuired|numeric',
    'operario'=>'reuired|exists:users,id',//editar mensaje
]

//REQUEST CONSUMO KARDEX RETAL LAMINA
$data = [
    'entrada_lamina_almacen'=>'required|exists:entrada_lamina_almacen,id',//editar mensaje
    'fecha'=>'required|date',
    'cantidad'=>'required|integer',
    'largo'=>'required|integer',
    'ancho'=>'required|integer',
    'peso'=>'required|numeric',
    'fecha_consumo'=>'required|date',
    'quien_genera'=>'required|exists:users,id',//editar mensaje
    'quien_gasta'=>'required|exists:users,id',//editar mensaje
    'forma_retal'=>'required|file|max:500',
]

//REQUEST CONSUMO PERFILERIA
$data = [
    'corte'=>'required|exists:cortes,id',//editar mensaje
    'fecha'=>'required|date',
    'ensamble'=>'required|numeric',
    'cantidad'=>'required|numeric',
    'medida'=>'required|numeric',
    'material'=>'required|exists:materiales,id',//editar mensaje
    'quien_solicito'=>'required|exists:users,id',//editar mensaje
    'proveedor'=>'required|exists:proveedores,id',//editar mensaje
    'quien_entrego'=>'required|exists:users,id',//editar mensaje
]
*/