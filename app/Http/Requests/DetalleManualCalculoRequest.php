<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetalleManualCalculoRequest extends FormRequest
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
            'posicion'=>'required|integer',
            'plano'=>'required|max:250',
            'ensamble'=>'required|in:Fondo,Tanque,Tk Exp.,Tapa,Prensa,Gabinete,Radiador,Mecanizado,Adicional',
            'nombre'=>'required|max:150',
            'longitud_1'=>'required|numeric',
            'longitud_2'=>'required|numeric',
            'masa'=>'required|numeric',
            'material'=>'required|exists:materiales,id',
            'peso_neto'=>'required|numeric',
            'centro_corte'=>'required|in:Fasti,GK,Trumpf,Trumpf 1000,Durma,CNC',
            'proceso'=>'required|in:T,D',
            'observaciones'=>'max:250',
        ];
        return $data;
    }

    public function messages()
    {
        return [
            'material.required'=>'El campo código material es obligatorio',
            'material.exists'=>'La información enviada es incorrecta'
        ];
    }
}
