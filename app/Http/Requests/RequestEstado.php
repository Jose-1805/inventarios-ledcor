<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestEstado extends FormRequest
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
            'nombre'=>'required|max:150',
            'precedencia'=>'required|numeric|unique:estados,precedencia,'.$this->id.',id',
            'email'=>'required|email',
            'linea'=>'required|in:LDT,MDT,SDT,Adicionales,Mecanizados',
            'tipo_item'=>'required|in:Corte,Radiadores,Adicionales,Mecanizados',
            'subensamble'=>'required|in:Tanque,Prensa,Perfileria,Adicional,Mecanizado,Rad MZ,Rad TB',
            'tipo_tk'=>'required|in:MON,PM,TRI,TRI ESP,PERF,PRENSA,ADIC,MEC',
        ];
        return $data;
    }
}