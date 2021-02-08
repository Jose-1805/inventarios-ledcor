<?php

namespace InventariosLedcor\Http\Controllers;

use InventariosLedcor\Http\Requests\RequestProyecto;
use InventariosLedcor\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ProyectoController extends Controller
{

    public $privilegio_superadministrador = true;

    function __construct()
    {
        $this->middleware('permisoModulo:6,' . $this->privilegio_superadministrador);
    }

    public function index(){
        return view('proyecto/index')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function create(){
        if(!Auth::user()->tieneFuncion(6,1,$this->privilegio_superadministrador))
            return redirect('/');

        return view('proyecto/crear')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function store(RequestProyecto $request){
        if(!Auth::user()->tieneFuncion(6,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $proyecto = new Proyecto($request->all());
        $proyecto->user_id = Auth::user()->id;
        $proyecto->cliente_id = $request->input('cliente');
        $proyecto->save();

        return ['success'=>true];
    }

    public function edit($id){
        if(!Auth::user()->tieneFuncion(6,2,$this->privilegio_superadministrador))
            return redirect('/');

        $proyecto = Proyecto::find($id);
        if(!$proyecto) return redirect('/');


        return view('proyecto/editar')
            ->with('proyecto',$proyecto)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function update(RequestProyecto $request){
        if(!Auth::user()->tieneFuncion(6,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized']],401);

        $proyecto = Proyecto::find($request->input('id'));
        $proyecto->nombre = $request->input('nombre');
        $proyecto->fecha_inicio = $request->input('fecha_inicio');
        $proyecto->cliente_id = $request->input('cliente');
        $proyecto->save();

        return ['success'=>true];
    }

    public function delete(Request $request){
        if($request->has('id')){
            $proyecto = Proyecto::find($request->input('id'));
            if($proyecto){
                $proyecto->delete();
            }

            return ['success'=>true];
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function lista(){
        $proyectos = Proyecto::select('proyectos.*','clientes.nombre as cliente')
            ->join('clientes','proyectos.cliente_id','clientes.id')
            ->orderBy('proyectos.created_at', 'ASC')->get();

        $table = Datatables::of($proyectos);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(6,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/proyecto/edit') .'/'. $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(6,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-user="'.$r->id.'" class="btn btn-xs btn-danger margin-2 btn-eliminar-proyecto" data-toggle="modal" data-target="#modal-eliimnar-proyecto"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(6,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function show($id){
        return redirect('/proyecto');
    }
}
