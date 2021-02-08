<?php

namespace InventariosLedcor\Http\Controllers;

use InventariosLedcor\Http\Requests\RequestCliente;
use InventariosLedcor\Models\Cliente;
use InventariosLedcor\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class ClienteController extends Controller
{

    public $privilegio_superadministrador = true;

    function __construct()
    {
        $this->middleware('permisoModulo:5,' . $this->privilegio_superadministrador);
    }

    public function index(){
        return view('cliente/index')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function create(){
        if(!Auth::user()->tieneFuncion(5,1,$this->privilegio_superadministrador))
            return redirect('/');

        return view('cliente/crear')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function store(RequestCliente $request){
        if(!Auth::user()->tieneFuncion(5,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $cliente = new Cliente($request->all());
        $cliente->user_id = Auth::user()->id;
        $cliente->save();

        return ['success'=>true];
    }

    public function edit($id){
        if(!Auth::user()->tieneFuncion(5,2,$this->privilegio_superadministrador))
            return redirect('/');

        $cliente = Cliente::find($id);
        if(!$cliente) return redirect('/');


        return view('cliente/editar')
            ->with('cliente',$cliente)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function update(RequestCliente $request){
        if(!Auth::user()->tieneFuncion(5,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized']],401);

        $cliente = Cliente::find($request->input('id'));
        $cliente->nombre = $request->input('nombre');
        $cliente->alias = $request->input('alias');
        $cliente->direccion = $request->input('direccion');
        $cliente->save();

        return ['success'=>true];
    }

    public function delete(Request $request){
        if($request->has('id')){
            $cliente = Cliente::find($request->input('id'));
            if($cliente){
                $cliente->delete();
            }

            return ['success'=>true];
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function lista(){
        $clientes = Cliente::select('clientes.*')
            ->orderBy('clientes.created_at', 'ASC')->get();

        $table = Datatables::of($clientes);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(5,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/cliente/edit') .'/'. $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(5,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-user="'.$r->id.'" class="btn btn-xs btn-danger margin-2 btn-eliminar-cliente" data-toggle="modal" data-target="#modal-eliimnar-cliente"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(5,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }
}
