<?php

namespace InventariosLedcor;

use InventariosLedcor\Models\Archivo;
use InventariosLedcor\Models\Funcion;
use InventariosLedcor\Models\Modulo;
use InventariosLedcor\Models\Rol;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_identificacion',
        'identificacion',
        'nombres',
        'apellidos',
        'telefono',
        'fecha_nacimiento',
        'email',
        'genero',
        'fecha_ingreso',
        'funcion',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rol(){
        return $this->belongsTo(Rol::class);
    }

    public function imagen(){
        return $this->belongsTo(Archivo::class,'archivo_id');
    }

    public function esSuperadministrador(){
        if($this->rol->superadministrador == "si")return true;
        return false;
    }

    /**
     * Consulta si un usuario tiene un modulo asignado a su rol
     *
     * @param $identificador -> identificador unico del modulo
     * @return bool
     */
    public function tieneModulo($identificador){
        $permisos = $this->rol->privilegios;

        if(is_numeric(strpos($permisos,'('.$identificador.',')))
            return true;

        return false;

    }


    public function tieneFuncion($identificador_modulo,$identificador_funcion,$privilegio_superadministrador){
        $permisos = $this->rol->privilegios;
        $modulo = Modulo::where('identificador',$identificador_modulo)->first();
        $funcion = Funcion::where('identificador',$identificador_funcion)->first();
        if($modulo && $funcion && $modulo->tieneFuncion($funcion->id) && $modulo->estado == 'Activo' ) {
            $result = ''.strpos($permisos,'(' . $identificador_modulo . ',' . $identificador_funcion . ')');
            if ( $result != '' || ($this->esSuperadministrador() && $privilegio_superadministrador))
                return true;
        }

        return false;

    }

    /**
     * Determina si un usuario tiene habilitadas funciones especificas o una de ellas
     *
     * @param $identificador_modulo
     * @param $funciones => Array con los identificadores de las funciones que se necesitan
     * @param $all => Determina si para retornar verdadero se debe tener todas las funciones o por lo menos una
     * @param $privilegio_superadministrador => Determina si se aplica Excepcion cuando el rol del usuario es superadministrador
     */
    public function tieneFunciones($identificador_modulo,$funciones,$all,$privilegio_superadministrador){
        $return = true;

        for ($i = 0; $i < count($funciones);$i++){
            if($this->tieneFuncion($identificador_modulo,$funciones[$i],$privilegio_superadministrador)){
                if(!$all){
                    return true;
                }else{
                    $return = true;
                }
            }else{
                if($all){
                    return false;
                }else{
                    $return = false;
                }
            }
        }
        return $return;
    }
}
