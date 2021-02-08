<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCliente extends FormRequest
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
                'nombre'=>'required|max:150|unique:clientes,nombre,'.$this->input('id').',id',
                'alias'=>'required|max:50',
                'direccion'=>'required|max:250',
            ];
        }
        return [
            'nombre'=>'required|max:150|unique:clientes,nombre',
            'alias'=>'required|max:50',
            'direccion'=>'required|max:250',
        ];
    }

    public function messages(){
        return[
            'nombre.required'=>'El campo nombre es obligatorio.',
            'nombre.max'=>'El campo nombre debe contener 150 caracteres como máximo.',
            'nombre.unique'=>'El campo nombre ya está en uso.',

            'alias.required'=>'El campo alias es obligatorio.',
            'alias.max'=>'El campo alias debe contener 50 caracteres como máximo.',

            'direccion.required'=>'El campo dirección es obligatorio.',
            'direccion.max'=>'El campo dirección debe contener 50 caracteres como máximo.',
        ];
    }
}
