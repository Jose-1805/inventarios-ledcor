<?php

namespace InventariosLedcor\Http\Controllers;

use InventariosLedcor\Http\Requests\OperarioRequest;
use InventariosLedcor\Http\Requests\UsuarioRequest;
use InventariosLedcor\Models\Archivo;
use InventariosLedcor\Models\Rol;
use InventariosLedcor\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class OperarioController extends Controller
{

    public $privilegio_superadministrador = true;

    function __construct()
    {
        $this->middleware('permisoModulo:4,' . $this->privilegio_superadministrador);
    }

    public function index(){
        return view('operario/index')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function create(){
        if(!Auth::user()->tieneFuncion(4,1,$this->privilegio_superadministrador))
            return redirect('/');

        return view('operario/crear')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function store(OperarioRequest $request){
        if(!Auth::user()->tieneFuncion(4,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $rol = Rol::where('operarios','si')->first();
        if(!$rol) return response(['error'=>['No se ha encontrado un rol asignable a operadores.']],422);

        DB::beginTransaction();
        $user = new User($request->all());
        $user->rol_id = $rol->id;
        $user->user_id = Auth::user()->id;
        $user->save();

        if($request->hasFile('imagen')){
            $ruta = 'imagenes/operarios/perfil/'.$user->id;
            $imagen = $request->file('imagen');
            $nombre = $imagen->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $imagen->move(storage_path($ruta),$nombre);

            $imagen_obj = new Archivo();
            $imagen_obj->nombre = $nombre;
            $imagen_obj->ubicacion = $ruta;
            $imagen_obj->save();


            $user->archivo_id = $imagen_obj->id;
            $user->save();
        }
        DB::commit();

        return ['success'=>true];
    }

    public function edit($id){
        if(!Auth::user()->tieneFuncion(4,2,$this->privilegio_superadministrador))
            return redirect('/');

        $usuario = User::select('users.*')->join('roles','users.rol_id','=','roles.id')
            ->where('roles.operarios','si')
            ->where('users.id',$id)->first();

        if(!$usuario) return redirect('/');


        return view('operario/editar')
            ->with('usuario',$usuario)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function update(OperarioRequest $request){
        if(!Auth::user()->tieneFuncion(4,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized']],401);

        DB::beginTransaction();
        $user = User::select('users.*')->join('roles','users.rol_id','=','roles.id')
            ->where('roles.operarios','si')
            ->where('users.id',$request->input('id'))->first();

        $user->tipo_identificacion = $request->input('tipo_identificacion');
        $user->identificacion = $request->input('identificacion');
        $user->nombres = $request->input('nombres');
        $user->apellidos = $request->input('apellidos');
        $user->fecha_ingreso = $request->input('fecha_ingreso');
        $user->email = $request->input('email');
        $user->funcion = $request->input('funcion');
        //$user->user_id = Auth::user()->id;
        //$user->password = Hash::make($request->input('password'));
        $user->save();

        if($request->hasFile('imagen')){

            //si la mascota tiene imagen se elimina
            $imagen_obj = $user->imagen;
            if($imagen_obj){
                $file = storage_path($imagen_obj->ubicacion.'/'.$imagen_obj->nombre);
                @unlink($file);
            }

            $ruta = 'imagenes/operarios/perfil/'.$user->id;

            $imagen = $request->file('imagen');
            $nombre = $imagen->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $imagen->move(storage_path($ruta),$nombre);

            if(!$imagen_obj)
                $imagen_obj = new Archivo();

            $imagen_obj->nombre = $nombre;
            $imagen_obj->ubicacion = $ruta;
            $imagen_obj->save();

            $user->archivo_id = $imagen_obj->id;
            $user->save();
        }
        DB::commit();
        return ['success'=>true];
    }

    public function delete(Request $request){
        if($request->has('id')){
            $user = User::select('users.*')->join('roles','users.rol_id','=','roles.id')
                ->where('roles.operarios','si')
                ->where('users.id',$request->input('id'))->first();
            if($user){
                $imagen_obj = $user->imagen;
                if($imagen_obj){
                    $file = storage_path($imagen_obj->ubicacion.'/'.$imagen_obj->nombre);
                    @unlink($file);
                    $imagen_obj->delete();
                }
                $user->delete();
            }

            return ['success'=>true];
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function lista(){
        $usuarios = User::select('users.id','users.nombres','users.apellidos','users.fecha_ingreso','users.funcion')
            ->join('roles','users.rol_id','=','roles.id')
            ->where('roles.operarios','si')
            ->orderBy('users.created_at', 'ASC')
            ->get();

        $table = Datatables::of($usuarios);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(4,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/operario/edit') .'/'. $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(4,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-user="'.$r->id.'" class="btn btn-xs btn-danger margin-2 btn-eliminar-usuario" data-toggle="modal" data-target="#modal-eliimnar-usuario"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(4,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }
}
