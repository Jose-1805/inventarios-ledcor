<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OperarioRequest extends FormRequest
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
                'tipo_identificacion'=>'required|in:C.C,NIT',
                'identificacion'=>'required|max:15|unique:users,identificacion,'.$this->input('id').',id',
                'nombres'=>'required|max:150',
                'apellidos'=>'required|max:150',
                'fecha_ingreso'=>'required|date',
                'funcion'=>'required|in:corte,tubos,radiadores',
                'email'=>'required|max:150|unique:users,email,'.$this->input('id').',id',
                'imagen'=>'file|mimes:jpg,jpeg,png|max:500',
            ];
        }
        return [
            'tipo_identificacion'=>'required|in:C.C,NIT',
            'identificacion'=>'required|max:15|unique:users,identificacion',
            'nombres'=>'required|max:150',
            'apellidos'=>'required|max:150',
            'fecha_ingreso'=>'required|date',
            'funcion'=>'required|in:corte,tubos,radiadores',
            'email'=>'required|max:150|unique:users,email',
            'imagen'=>'file|mimes:jpg,jpeg,png|max:500',
        ];
    }

    public function messages(){
        return[
            'tipo_identificacion.required'=>'El campo tipo de identificación es obligatorio.',
            'tipo_identificacion.in'=>'El campo tipo de identificación debe ser igual a uno de estos valores C.C, NIT.',
            'identificacion.required'=>'El campo identificación es obligatorio.',
            'identificacion.max'=>'El campo identificación debe contener 15 caracteres como máximo.',
            'telefono.required'=>'El campo teléfono es obligatorio.',
            'telefono.max'=>'El campo teléfono debe contener 15 caracteres como máximo.',
            'email.required'=>'El campo correo electrónico es obligatorio.',
            'email.max'=>'El campo correo electrónico debe contener 150 caracteres como máximo.',
            'rol.required'=>'El campo rol es obligatorio.',
            'rol.exists'=>'La información enviada es incorrecta.',
            'password.required'=>'El campo contraseña es obligatorio.',
            'password.min'=>'El campo contraseña debe contener 6 caracteres como mínimo.',
            'password.same'=>'El campo contraseña y confirmación de contraseña deben coincidir.',
            'password_confirm.required'=>'El campo confirmación de contraseña es obligatorio.',
            'password_confirm.min'=>'El campo confirmación de contraseña debe contener 6 caracteres como mínimo.',
            'imagen.file'=>'El campo de imagen es incorrecto',
            'imagen.mimes'=>'La imagen seleccionada debe ser de tipo (jpg, jpeg o png)',
            'imagen.max'=>'La imagen debe pesar máximo 500 kb',
        ];
    }
}
