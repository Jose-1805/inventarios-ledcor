<?php

namespace InventariosLedcor\Http\Controllers;

use InventariosLedcor\Http\Requests\UsuarioRequest;
use InventariosLedcor\Models\Archivo;
use InventariosLedcor\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UsuarioController extends Controller
{

    public $privilegio_superadministrador = true;

    function __construct()
    {
        $this->middleware('permisoModulo:3,' . $this->privilegio_superadministrador);
    }

    public function index(){
        return view('usuario/index')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function create(){
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');

        return view('usuario/crear')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function store(UsuarioRequest $request){
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);
        DB::beginTransaction();
        $user = new User($request->all());
        $user->rol_id = $request->input('rol');
        $user->user_id = Auth::user()->id;
        $user->password = Hash::make($request->input('password'));
        $user->save();

        if($request->hasFile('imagen')){
            $ruta = 'imagenes/usuarios/perfil/'.$user->id;
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
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $usuario = User::find($id);
        if(!$usuario) return redirect('/');


        return view('usuario/editar')
            ->with('usuario',$usuario)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function update(UsuarioRequest $request){
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized']],401);

        DB::beginTransaction();
        $user = User::find($request->input('id'));
        $user->tipo_identificacion = $request->input('tipo_identificacion');
        $user->identificacion = $request->input('identificacion');
        $user->nombres = $request->input('nombres');
        $user->apellidos = $request->input('apellidos');
        $user->telefono = $request->input('telefono');
        $user->fecha_nacimiento = $request->input('fecha_nacimiento');
        $user->email = $request->input('email');
        $user->genero = $request->input('genero');
        $user->rol_id = $request->input('rol');
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

            $ruta = 'imagenes/usuarios/perfil/'.$user->id;

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
            $user = User::find($request->input('id'));
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
        $usuarios = User::select('users.id',DB::raw('CONCAT(IFNULL(users.tipo_identificacion,"") , " " ,users.identificacion) as identificacion'),DB::raw('CONCAT(IFNULL(users.nombres,"")," ",IFNULL(users.apellidos,"")) as nombre'),'users.email','users.telefono','users.fecha_nacimiento','users.genero','roles.nombre as rol')
            ->join('roles','users.rol_id','=','roles.id')
            ->orderBy('users.created_at', 'ASC')->get();

        $table = Datatables::of($usuarios);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/usuario/edit') .'/'. $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-user="'.$r->id.'" class="btn btn-xs btn-danger margin-2 btn-eliminar-usuario" data-toggle="modal" data-target="#modal-eliimnar-usuario"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function show($id){
        return redirect('/usuario');
    }
}
