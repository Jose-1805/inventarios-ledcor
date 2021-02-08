<?php

namespace InventariosLedcor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramacionRequest extends FormRequest
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
            'linea'=>'required|in:LDT,MDT,SDT,Adicionales,Mecanizados,Daño de máquina',
            'tipo_item'=>'required|in:Corte,Radiadores,Adicionales,Mecanizados',
            'subensamble'=>'required|in:Tanque,Prensa,Perfileria,Adicional,Mecanizado,Rad MZ,Rad TB,Daño de máquina',
            'tipo_tk'=>'required|in:MON,PM,TRI,TRI ESP,PERF,PRENSA,ADIC,MEC',
            'no_preliminar_inicial'=>'required|max:150',
            'no_preliminar_final'=>'required|max:150',
            'no_fabricacion_inicial'=>'required|max:150',
            'no_fabricacion_final'=>'required|max:150',
            'calculo_fert'=>'required|max:150',
            'orden_fabricacion_trafo'=>'required|max:150',
            'cantidad_tk'=>'required|integer',
            'proyecto'=>'required|exists:proyectos,id',
            'KVA'=>'required|integer',
            'estado'=>'required|exists:estados,id',
            'baterias_tk'=>'required|integer',
            'no_elem'=>'required|integer',
            'ancho_rad'=>'required|in:326,52',
            'longitud_rad'=>'required|integer',
            'peso_teorico_prensas'=>'required|numeric',
            'peso_teorico_tk'=>'required|numeric',
            'peso_teorico_cajas'=>'required|numeric',
            'peso_teorico_radiadores'=>'required|numeric',
            'fecha_plan_formado_radiador'=>'required|date',
            'fecha_entrega_formado'=>'required|date',
            'fecha_liberacion_planos'=>'required|date',
            'confirmacion_inicial'=>'required|date',
            'fecha_entrega_material'=>'required|date',
            'fecha_plan'=>'required|date',
            'fecha_entrega'=>'required|date',
            'proveedor'=>'required|exists:proveedores,id',
        ];

        if($this->input('subensamble') == 'Rad MZ' || $this->input('subensamble') == 'Rad TB'){
            unset($data['peso_teorico_tk']);
            unset($data['peso_teorico_cajas']);
            unset($data['peso_teorico_prensas']);
        }

        if($this->input('subensamble') == 'Tanque'){
            unset($data['baterias_tk']);
            unset($data['no_elem']);
            unset($data['ancho_rad']);
            unset($data['longitud_rad']);
            unset($data['peso_teorico_radiadores']);
            unset($data['fecha_plan_formado_radiador']);
            unset($data['fecha_entrega_formado']);
            unset($data['peso_teorico_prensas']);
        }
        if($this->input('subensamble') == 'Prensa'){
            unset($data['baterias_tk']);
            unset($data['no_elem']);
            unset($data['ancho_rad']);
            unset($data['longitud_rad']);
            unset($data['peso_teorico_radiadores']);
            unset($data['fecha_plan_formado_radiador']);
            unset($data['fecha_entrega_formado']);
            unset($data['peso_teorico_tk']);
            unset($data['peso_teorico_cajas']);
        }
        return $data;
    }

    public function messages()
    {
        return [
            'no_preliminar_inicial.required'=>'El campo N° preliminar inicial es obligatorio',
            'no_preliminar_inicial.max'=>'El campo N° preliminar inicial puede contener máximo 150 caracteres',

            'no_preliminar_final.required'=>'El campo N° preliminar final es obligatorio',
            'no_preliminar_final.max'=>'El campo N° preliminar final puede contener máximo 150 caracteres',

            'no_fabricacion_inicial.required'=>'El campo N° fabricación inicial es obligatorio',
            'no_fabricacion_inicial.max'=>'El campo N° fabricación inicial puede contener máximo 150 caracteres',

            'no_fabricacion_final.required'=>'El campo N° fabricación final es obligatorio',
            'no_fabricacion_final.max'=>'El campo N° fabricación final puede contener máximo 150 caracteres',

            'orden_fabricacion_trafo.required'=>'El campo orden fabricación trafo es obligatorio',
            'orden_fabricacion_trafo.max'=>'El campo orden fabricación trafo puede contener máximo 150 caracteres',

            'proyecto.required'=>'El campo proyecto es obligatorio',
            'proyecto.exists'=>'La infomración enviada es incorrecta',

            'estado.required'=>'El campo estado es obligatorio',
            'estado.exists'=>'La infomración enviada es incorrecta',

            'no_elem.required'=>'El campo N° elemento es obligatorio',
            'no_elem.integer'=>'El campo N° elemento debe ser de tipo entero',

            'ancho_rad.required'=>'El campo ancho radiador es obligatorio',
            'ancho_rad.in'=>'El campo ancho radiador debe contener uno de estos valores (326,52)',

            'longitud_rad.required'=>'El campo longitud radiador es obligatorio',
            'longitud_rad.integer'=>'El campo longitud radiador debe ser de tipo entero',

            'proveedor.required'=>'El campo solicitado por es obligatorio',
            'proveedor.exists'=>'La infomración enviada es incorrecta',

        ];
    }

    public static function rulesImportacion($data){
        $data_valid = [
            'linea'=>'required|in:LDT,MDT,SDT,Adicionales,Mecanizados,Daño de máquina',
            'tipo_item'=>'required|in:Corte,Radiadores,Adicionales,Mecanizados',
            'subensamble'=>'required|in:Tanque,Prensa,Perfileria,Adicional,Mecanizado,Rad MZ,Rad TB,Daño de máquina',
            'tipo_tk'=>'required|in:MON,PM,TRI,TRI ESP,PERF,PRENSA,ADIC,MEC',
            'no_preliminar_inicial'=>'required|max:150',
            'no_preliminar_final'=>'required|max:150',
            'no_fabricacion_inicial'=>'required|max:150',
            'no_fabricacion_final'=>'required|max:150',
            'calculo_fert'=>'required|max:150',
            'orden_fabricacion_trafo'=>'required|max:150',
            'cantidad_tk'=>'required|integer',
            'proyecto'=>'required|exists:proyectos,id',
            'kva'=>'required|integer',
            'estado'=>'required||exists:estados,id',
            'progreso'=>'required|numeric|max:100',
            'proveedor'=>'required|exists:proveedores,id',
            'reproceso'=>'required|in:si,no',
            'baterias_tk'=>'required|integer',
            'no_elem'=>'required|integer',
            'ancho_rad'=>'required|in:326,52',
            'longitud_rad'=>'required|integer',
            'peso_teorico_prensas'=>'required|numeric',
            'peso_teorico_tk'=>'required|numeric',
            'peso_teorico_cajas'=>'required|numeric',
            'peso_teorico_radiadores'=>'required|numeric',
            'fecha_plan_formado_radiador'=>'required|date',
            'fecha_entrega_formado'=>'required|date',
            'fecha_liberacion_planos'=>'required|date',
            'confirmacion_inicial'=>'required|date',
            'fecha_entrega_material'=>'required|date',
            'fecha_plan'=>'required|date',
            'fecha_entrega'=>'required|date',
        ];

        if($data['subensamble'] == 'Rad MZ' || $data['subensamble'] == 'Rad TB'){
            unset($data_valid['peso_teorico_tk']);
            unset($data_valid['peso_teorico_cajas']);
            unset($data_valid['peso_teorico_prensas']);
        }

        if($data['subensamble'] == 'Tanque'){
            unset($data_valid['baterias_tk']);
            unset($data_valid['no_elem']);
            unset($data_valid['ancho_rad']);
            unset($data_valid['longitud_rad']);
            unset($data_valid['peso_teorico_radiadores']);
            unset($data_valid['fecha_plan_formado_radiador']);
            unset($data_valid['fecha_entrega_formado']);
            unset($data_valid['peso_teorico_prensas']);
        }
        if($data['subensamble'] == 'Prensa'){
            unset($data_valid['baterias_tk']);
            unset($data_valid['no_elem']);
            unset($data_valid['ancho_rad']);
            unset($data_valid['longitud_rad']);
            unset($data_valid['peso_teorico_radiadores']);
            unset($data_valid['fecha_plan_formado_radiador']);
            unset($data_valid['fecha_entrega_formado']);
            unset($data_valid['peso_teorico_tk']);
            unset($data_valid['peso_teorico_cajas']);
        }
        return $data_valid;
    }

    public static function messagesImportacion(){
        return [
            'no_preliminar_inicial.required'=>'El campo N° preliminar inicial es obligatorio',
            'no_preliminar_inicial.max'=>'El campo N° preliminar inicial puede contener máximo 150 caracteres',

            'no_preliminar_final.required'=>'El campo N° preliminar final es obligatorio',
            'no_preliminar_final.max'=>'El campo N° preliminar final puede contener máximo 150 caracteres',

            'corte.required'=>'El campo N° Fab. Inicial es obligatorio',
            'corte.exists'=>'El campo N° Fab. Inicial es incorrecto',

            'corte_final.required'=>'El campo N° Fab. Final es obligatorio',
            'corte_final.exists'=>'El campo N° Fab. Final es incorrecto',

            'orden_fabricacion_trafo.required'=>'El campo orden fabricación trafo es obligatorio',
            'orden_fabricacion_trafo.max'=>'El campo orden fabricación trafo puede contener máximo 150 caracteres',

            'proyecto.required'=>'El campo proyecto es obligatorio',
            'proyecto.exists'=>'El campo proyecto es incorrecto',

            'estado.required'=>'El campo estado es obligatorio',
            'estado.exists'=>'El campo estado es incorrecto',

            'no_elem.required'=>'El campo N° elemento es obligatorio',
            'no_elem.integer'=>'El campo N° elemento debe ser de tipo entero',

            'ancho_rad.required'=>'El campo ancho radiador es obligatorio',
            'ancho_rad.in'=>'El campo ancho radiador debe contener uno de estos valores (326,52)',

            'longitud_rad.required'=>'El campo longitud radiador es obligatorio',
            'longitud_rad.integer'=>'El campo longitud radiador debe ser de tipo entero',

            'no_fabricacion_inicial.required'=>'El campo N° fabricación inicial es obligatorio',
            'no_fabricacion_inicial.max'=>'El campo N° fabricación inicial puede contener máximo 150 caracteres',

            'no_fabricacion_final.required'=>'El campo N° fabricación final es obligatorio',
            'no_fabricacion_final.max'=>'El campo N° fabricación final puede contener máximo 150 caracteres',

            'proveedor.required'=>'El campo solicitado por es obligatorio',
            'proveedor.exists'=>'La infomración enviada es incorrecta',
        ];
    }
}
