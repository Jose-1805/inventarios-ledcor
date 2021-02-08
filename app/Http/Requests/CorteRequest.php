<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorteRequest extends FormRequest
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
            'calculo'=>'required|exists:calculos,id',
            'ensamble'=>'required|in:Tanque,Prensa,Perfileria,Adicional,Mecanizado,RadMZ,RadTB,Daño de máquina',
            'cantidad_tk'=>'required|integer',
            'proyecto'=>'required|exists:proyectos,id',
            'no_fabricacion_inicial'=>'required|max:150',
            'no_fabricacion_final'=>'required|max:150',
            'user'=>'required|exists:users,id',
            'peso_tanque'=>'required|numeric',
            'peso_prensa'=>'required|numeric',
            'peso_caja'=>'required|numeric',
            'peso_otro_item'=>'required|numeric',
            'fecha_listado'=>'required|date',
        ];

        return $data;
    }

    public function messages()
    {
        return [
            'calculo.required'=>'El campo calculo es obligatorio',
            'calculo.exists'=>'La información enviada es incorrecta',

            'proyecto.required'=>'El campo proyecto es obligatorio',
            'proyecto.exists'=>'La información enviada es incorrecta',

            'no_fabricacion_inicial.required'=>'El campo N° de fabricación inicial es obligatorio',
            'no_fabricacion_inicial.max'=>'El campo N° de fabricación inicial puede contener máximo 150 caracteres',

            'no_fabricacion_final.required'=>'El campo N° de fabricación final es obligatorio',
            'no_fabricacion_final.max'=>'El campo N° de fabricación final puede contener máximo 150 caracteres',

            'user.required'=>'El campo elaborado por es obligatorio',
            'user.exists'=>'La información enviada es incorrecta',
        ];
    }
}
