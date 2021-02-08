<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestProyecto extends FormRequest
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
                'nombre'=>'required|max:150|unique:proyectos,nombre,'.$this->input('id').',id',
                'fecha_inicio'=>'required|date',
                'cliente'=>'required|exists:clientes,id',
            ];
        }
        return [
            'nombre'=>'required|max:150|unique:proyectos,nombre',
            'fecha_inicio'=>'required|date',
            'cliente'=>'required|exists:clientes,id',
        ];
    }

    public function messages(){
        return[
            'nombre.required'=>'El campo nombre es obligatorio.',
            'nombre.max'=>'El campo nombre debe contener 150 caracteres como máximo.',
            'nombre.unique'=>'El campo nombre ya está en uso.',

            'fecha_inicio.required'=>'El campo fecha inicio es obligatorio.',
            'fecha_inicio.date'=>'El campo fecha de inicio no tiene el formato correcto.',

            'cliente.required'=>'El campo cliente es obligatorio.',
            'cliente.exists'=>'La informaciòn enviada es incorrecta.',
        ];
    }
}
