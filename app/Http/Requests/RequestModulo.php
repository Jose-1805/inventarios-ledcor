<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestModulo extends FormRequest
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
        if($this->has('modulo')){
            return [
                'nombre'=>'required|max:150|unique:modulos,nombre,'.$this->input('modulo').',id',
                //'identificador'=>'required|numeric|unique:modulos,identificador,'.$this->input('modulo').',id',
                'etiqueta'=>'required|max:150',
                'url'=>'required|max:150|unique:modulos,url,'.$this->input('modulo').',id',
                'estado'=>'required|in:Activo,Inactivo',
            ];
        }
        return [
            'nombre'=>'required|max:150|unique:modulos,nombre',
            'identificador'=>'required|numeric|unique:modulos,identificador',
            'etiqueta'=>'required|max:150',
            'url'=>'required|max:150|unique:modulos,url',
            'estado'=>'required|in:Activo,Inactivo',
        ];
    }

    public function messages(){
        return[
        ];
    }
}
