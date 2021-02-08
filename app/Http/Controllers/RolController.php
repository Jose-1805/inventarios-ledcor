<?php

namespace InventariosLedcor\Http\Controllers;

use InventariosLedcor\Http\Requests\RequestRegistro;
use InventariosLedcor\Http\Requests\RequestRol;
use InventariosLedcor\Models\Registro;
use InventariosLedcor\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolController extends Controller
{
    public $privilegio_superadministrador = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permisoModulo:2,' . $this->privilegio_superadministrador);
    }

    /**s
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rol/index')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function vistaRoles()
    {
        return view('rol.lista_roles')
            ->with('roles', Rol::orderBy("nombre")->where('superadministrador','no')->get())
            ->with('privilegio_superadministrador', $this->privilegio_superadministrador);
    }

    public function vistaPrivilegios(Request $request)
    {
        $rol = null;
        if ($request->has('rol'))
            $rol = Rol::where('superadministrador','no')->find($request->input('rol'));

        return view('rol.lista_privilegios')
            ->with('rol', $rol)
            ->with('privilegio_superadministrador', $this->privilegio_superadministrador);
    }

    public function crear(RequestRol $request){
        if (!Auth::user()->tieneFuncion(2, 1, $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        $rol = new Rol();
        $rol->nombre = $request->nombre;

        $rol->user_id = Auth::user()->id;
        if($request->has('operarios') && $request->input('operarios') == 'si')
            $rol->operarios = 'si';

        $privilegios = '';
        if($request->has('privilegios')){
            if(is_array($request->input('privilegios'))){
                for ($i = 0;$i < count($request->input('privilegios')); $i++){
                    //se separa cada dato por la coma que debe traer para identificar el módulo y la funcion ej: 2,1
                    $data = explode(',',$request->input('privilegios')[$i]);

                    if(count($data) == 2){
                        if(Auth::user()->tieneFuncion($data[0],$data[1],$this->privilegio_superadministrador)){
                            $privilegios .= '('.$request->input('privilegios')[$i].')_';
                        }
                    }else{
                        return response(['error' => ['La información enviada es incorrecta']], 422);
                    }
                }
                //se quita el ultimo '_' para que la cadena quede tipo -> (1,2)_(1,3) y no -> (1,2)_(1,3)_
                $privilegios = trim($privilegios,'_');
            }else{
                return response(['error' => ['La información enviada es incorrecta']], 422);
            }
        }
        if($privilegios != '')
            $rol->privilegios = $privilegios;

        $rol->save();
        return ['success'=>true];
    }

    public function form(Request $request){
        $rol = new Rol();
        if($request->has('rol'))$rol = Rol::find($request->input('rol'));

        return view('rol/form')->with('rol',$rol)->render();
    }

    public function editar(RequestRol $request){
        if (!Auth::user()->tieneFuncion(2, 2, $this->privilegio_superadministrador))
            return response(['error' => ['Unauthorized.']], 401);

        if(!$request->has('rol'))return response(['error'=>['La información envida es incorrecta']],422);

        $rol = Rol::find($request->input('rol'));

        if(!$rol)return response(['error'=>['La información envida es incorrecta']],422);

        $rol->nombre = $request->nombre;
        $rol->privilegios = '';
        $privilegios = '';
        if($request->has('privilegios')){
            if(is_array($request->input('privilegios'))){
                for ($i = 0;$i < count($request->input('privilegios')); $i++){
                    //se separa cada dato por la coma que debe traer para identificar el módulo y la funcion ej: 2,1
                    $data = explode(',',$request->input('privilegios')[$i]);

                    if(count($data) == 2){
                        if(Auth::user()->tieneFuncion($data[0],$data[1],$this->privilegio_superadministrador)){
                            $privilegios .= '('.$request->input('privilegios')[$i].')_';
                        }
                    }else{
                        return response(['error' => ['La información enviada es incorrecta']], 422);
                    }
                }
                //se quita el ultimo '_' para que la cadena quede tipo -> (1,2)_(1,3) y no -> (1,2)_(1,3)_
                $privilegios = trim($privilegios,'_');
            }else{
                return response(['error' => ['La información enviada es incorrecta']], 422);
            }
        }
        if($privilegios != '')
            $rol->privilegios = $privilegios;

        $rol->save();
        return ['success'=>true];
    }
}