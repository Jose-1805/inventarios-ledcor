<?php

namespace InventariosLedcor\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';


    protected $fillable = [
        'superadministrador',
        'nombre',
        'privilegios',
        'operarios',
        'user_id',
    ];


    /**
     * Retorna un array con la información de los privilegios convertida a texto
     *
     * [
     *   'numero_identificador' => [
     *      'nombre'=>'etiqueta_modulo',
     *      'funciones'=>
     *          [
     *              0 => 'Nombre_funcion_!',
     *              1 => 'Nombre_funcion_2',
     *              2 => 'Nombre_funcion_...',
     *          ],
     *
     *   ]
     * ]
     */
    public function dataPrivilegios(){
        $privilegios = $this->privilegios;

        $data = explode('_',$privilegios);
        $data_return = [];
        if(count($data) > 1) {
            for ($i = 0; $i < count($data); $i++) {
                //se quitan los caracteres '(' y ')' para pasar de (1,2) a 1,2
                $str_privilegio = trim($data[$i], '(');
                $str_privilegio = trim($str_privilegio, ')');
                // se separa en un array por la coma
                $data_privilegio = explode(',', $str_privilegio);
                $modulo = Modulo::where('identificador', $data_privilegio[0])->first();

                if (!array_key_exists($modulo->identificador, $data_return)) {
                    $data_return[$modulo->identificador] = [
                        'nombre' => $modulo->nombre,
                        'etiqueta' => $modulo->etiqueta,
                        'url' => $modulo->url,
                        'estado' => $modulo->estado,
                        'agrupacion' => $modulo->agrupacion,
                        'orden_menu' => $modulo->orden_menu,
                        'funciones' => [],
                    ];
                }

                $funcion = Funcion::where('identificador', $data_privilegio[1])->first();
                $data_return[$modulo->identificador]['funciones'][] = $funcion->nombre;
            }
        }
        return $data_return;
    }

    public function tieneFuncion($identificador_modulo,$identificador_funcion){
        $permisos = $this->privilegios;
        if($permisos) {
            $modulo = Modulo::where('identificador', $identificador_modulo)->first();
            $funcion = Funcion::where('identificador', $identificador_funcion)->first();

            if ($modulo && $funcion && $modulo->tieneFuncion($funcion->id)) {
                $result = ''.strpos($permisos, '(' . $identificador_modulo . ',' . $identificador_funcion . ')');

                if ($result != '')
                    return true;
            }
        }

        return false;
    }
}
