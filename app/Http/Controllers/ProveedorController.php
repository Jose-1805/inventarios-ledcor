<?php

namespace InventariosLedcor\Http\Controllers;

use InventariosLedcor\Http\Requests\RequestCliente;
use InventariosLedcor\Http\Requests\RequestProveedor;
use InventariosLedcor\Models\Cliente;
use InventariosLedcor\Models\Proveedor;
use InventariosLedcor\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class ProveedorController extends Controller
{

    public $privilegio_superadministrador = true;

    function __construct()
    {
        $this->middleware('permisoModulo:8,' . $this->privilegio_superadministrador);
    }

    public function index(){
        return view('proveedor/index')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function create(){
        if(!Auth::user()->tieneFuncion(8,1,$this->privilegio_superadministrador))
            return redirect('/');

        return view('proveedor/crear')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function store(RequestProveedor $request){
        if(!Auth::user()->tieneFuncion(8,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $proveedor = new Proveedor($request->all());
        $proveedor->user_id = Auth::user()->id;
        $proveedor->save();

        return ['success'=>true];
    }

    public function edit($id){
        if(!Auth::user()->tieneFuncion(8,2,$this->privilegio_superadministrador))
            return redirect('/');

        $proveedor = Proveedor::find($id);
        if(!$proveedor) return redirect('/');


        return view('proveedor/editar')
            ->with('proveedor',$proveedor)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function update(RequestProveedor $request){
        if(!Auth::user()->tieneFuncion(8,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized']],401);

        $proveedor = Proveedor::find($request->input('id'));
        $proveedor->nombre = $request->input('nombre');
        $proveedor->alias = $request->input('alias');
        $proveedor->direccion = $request->input('direccion');
        $proveedor->save();

        return ['success'=>true];
    }

    public function delete(Request $request){
        if($request->has('id')){
            $proveedor = Proveedor::find($request->input('id'));
            if($proveedor){
                $proveedor->delete();
            }

            return ['success'=>true];
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function lista(){
        $proveedores = Proveedor::select('proveedores.*')
            ->orderBy('proveedores.created_at', 'ASC')->get();

        $table = Datatables::of($proveedores);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(8,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/proveedor/edit') .'/'. $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(8,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-user="'.$r->id.'" class="btn btn-xs btn-danger margin-2 btn-eliminar-proveedor" data-toggle="modal" data-target="#modal-eliimnar-proveedor"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(8,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function show($id){
        return redirect('/proveedor');
    }
}
