<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetalleManualCorteRequest extends FormRequest
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
            'plano'=>'required|max:100',
            'ensamble'=>'required|in:Tanque,Prensa,Perfileria,Adicional,Mecanizado,RadMZ,RadTB,Daño de máquina',
            'nombre'=>'required|max:100',
            'cantidad'=>'required|integer',
            'longitud_1'=>'required|numeric',
            'longitud_2'=>'required|numeric',
            'centro_corte'=>'required|max:150',
            'peso_neto'=>'required|numeric',
            'masa'=>'required|numeric',
            'material'=>'required|exists:materiales,id',
            'proceso'=>'required|in:T,D,NULL',
        ];
        return $data;
    }

    public function messages()
    {
        return [
            'material.exists'=>'La información enviada es incorrecta'
        ];
    }
}
