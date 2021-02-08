<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculoRequest extends FormRequest
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
            'numero'=>'required|unique:calculos,numero,'.$this->id.',id',
            'ensamble'=>'required|in:Fondo,Tanque,Tk Exp.,Tapa,Prensa,Gabinete,Radiador,Mecanizado,Adicional',
            'fert'=>'required|max:250',
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'numero.required'=>'El campo N° calculo es obligatorio',
            'numero.unique'=>'El campo N° calculo ya está en uso',
        ];
    }
}
