<?php

namespace InventariosLedcor\Http\Controllers;

use InventariosLedcor\Http\Requests\RequestOrdenCompra;
use InventariosLedcor\Http\Requests\RequestProyecto;
use InventariosLedcor\Models\OrdenCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class OrdenCompraController extends Controller
{

    public $privilegio_superadministrador = true;

    function __construct()
    {
        $this->middleware('permisoModulo:7,' . $this->privilegio_superadministrador);
    }

    public function index(){
        return view('orden_compra/index')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function create(){
        if(!Auth::user()->tieneFuncion(7,1,$this->privilegio_superadministrador))
            return redirect('/');

        return view('orden_compra/crear')->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function store(RequestOrdenCompra $request){
        if(!Auth::user()->tieneFuncion(7,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $orden_compra = new OrdenCompra($request->all());
        $orden_compra->user_id = Auth::user()->id;
        $orden_compra->cliente_id = $request->input('cliente');
        $orden_compra->proyecto_id = $request->input('proyecto');
        $orden_compra->save();

        return ['success'=>true];
    }

    public function edit($id){
        if(!Auth::user()->tieneFuncion(7,2,$this->privilegio_superadministrador))
            return redirect('/');

        $orden_compra = OrdenCompra::find($id);
        if(!$orden_compra) return redirect('/');


        return view('orden_compra/editar')
            ->with('orden_compra',$orden_compra)
            ->with('privilegio_superadministrador',$this->privilegio_superadministrador);
    }

    public function update(RequestOrdenCompra $request){
        if(!Auth::user()->tieneFuncion(7,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized']],401);

        $orden_compra = OrdenCompra::find($request->input('id'));
        $orden_compra->fill($request->all());
        $orden_compra->cliente_id = $request->input('cliente');
        $orden_compra->proyecto_id = $request->input('proyecto');
        $orden_compra->save();

        return ['success'=>true];
    }

    public function delete(Request $request){
        if($request->has('id')){
            $orden_compra = OrdenCompra::find($request->input('id'));
            if($orden_compra){
                $orden_compra->delete();
            }

            return ['success'=>true];
        }
        return response(['error'=>['La información enviada es incorrecta']],422);
    }

    public function lista(){
        $ordenes_compra = OrdenCompra::select('ordenes_compras.*'/*,'clientes.nombre as cliente','proyectos.nombre as proyecto'*/)
            //->join('clientes','ordenes_compras.cliente_id','clientes.id')
            //->join('proyectos','ordenes_compras.proyecto_id','proyectos.id')
            ->orderBy('ordenes_compras.created_at', 'ASC')->get();

        $table = Datatables::of($ordenes_compra);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(7,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/orden-compra/edit') .'/'. $r->id . '" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(7,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-user="'.$r->id.'" class="btn btn-xs btn-danger margin-2 btn-eliminar-orden-compra" data-toggle="modal" data-target="#modal-eliimnar-orden-compra"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(7,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function show($id){
        return redirect('/orden-compra');
    }
}
