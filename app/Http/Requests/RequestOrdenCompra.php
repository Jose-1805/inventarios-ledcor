<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestOrdenCompra extends FormRequest
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
        if($this->has('id')){
            return [
                'numero'=>'required|max:50|unique:ordenes_compras,numero,'.$this->input('id').',id',
                'fecha'=>'required|date',
                'posicion'=>'required|max:50',
                'codigo_mecanizado'=>'required|max:50',
                'descripcion'=>'required|max:150',
                'cantidad_requerida'=>'required|numeric',
                'fecha_entrega_requerida'=>'required|date',
                'cliente'=>'required|exists:clientes,id',
                'proyecto'=>'required|exists:proyectos,id',
            ];
        }
        return [
            'numero'=>'required|max:50|unique:ordenes_compras,numero',
            'fecha'=>'required|date',
            'posicion'=>'required|max:50',
            'codigo_mecanizado'=>'required|max:50',
            'descripcion'=>'required|max:150',
            'cantidad_requerida'=>'required|numeric',
            'fecha_entrega_requerida'=>'required|date',
            'cliente'=>'required|exists:clientes,id',
            'proyecto'=>'required|exists:proyectos,id',
        ];
    }

    public function messages(){
        return[
            'numero.required'=>'El campo número es obligatorio.',
            'numero.max'=>'El campo número debe contener 150 caracteres como máximo.',
            'numero.unique'=>'El campo número ya está en uso.',

            'fecha_inicio.required'=>'El campo fecha inicio es obligatorio.',
            'fecha_inicio.date'=>'El campo fecha de inicio no tiene el formato correcto.',

            'cliente.required'=>'El campo cliente es obligatorio.',
            'cliente.exists'=>'La informaciòn enviada es incorrecta.',

            'proyecto.required'=>'El campo proyecto es obligatorio.',
            'proyecto.exists'=>'La informaciòn enviada es incorrecta.',
        ];
    }
}
