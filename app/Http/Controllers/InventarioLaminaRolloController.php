<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\Solicitud;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\InventarioLaminaRollo;
use InventariosLedcor\Http\Requests\IngresoLaminaRolloRequest;

use DB;

class InventarioLaminaRolloController extends Controller
{
    public $privilegio_superadministrador = true;
    //
    public function __construct()
    {
        $this->middleware('permisoModulo:3,' . $this->privilegio_superadministrador);
    }

    public function index(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('inventariolaminarollo.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('inventariolaminarollo.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $inventariolaminarollo = InventarioLaminaRollo::findOrFail($id);
	    return view('inventariolaminarollo.add', [
	        'model' => $inventariolaminarollo	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = InventarioLaminaRollo::select('inventario_lamina_rollo.*',DB::raw('CONCAT(users.nombres," ",users.apellidos) as operario')
            ,'ordenes_compras.numero as orden_compra','proveedores.nombre as proveedor')
            ->join('proveedores','inventario_lamina_rollo.proveedor_id','=','proveedores.id')
            ->join('ordenes_compras','inventario_lamina_rollo.orden_compra_id','=','ordenes_compras.id')
            ->join('users','inventario_lamina_rollo.operario_id','=','users.id')
            ->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/inventario/ingresomaterial/laminarollo/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/inventario/ingresomaterial/laminarollo/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(IngresoLaminaRolloRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);

        $inventariolaminarollo = InventarioLaminaRollo::find($request->id);

	    if(!$inventariolaminarollo)return response(['errors'=>['La información enviada es incorrecta']],422);

        $solicitud = Solicitud::find($request->solicitud);
        $cantidad_disponible = $solicitud->cantidadMaterialDisponible($request->material);
        if($request->peso_validado > ($cantidad_disponible + $solicitud->peso_validado)){
            return response(['errors'=>['La cantidad máxima permitida en el campo peso validado es '.($cantidad_disponible+$solicitud->peso_validado)]],422);
        }

        $inventariolaminarollo->fecha_recibido = $request->fecha_recibido;
        $inventariolaminarollo->peso_sin_validar = $request->peso_sin_validar;
        $inventariolaminarollo->espesor_validado = $request->espesor_validado;
        $inventariolaminarollo->solicitud_id = $request->solicitud;
        $inventariolaminarollo->peso_validado = $request->peso_validado;
        $inventariolaminarollo->lote = $request->lote;
        $inventariolaminarollo->no_identificacion_rollo = $request->no_identificacion_rollo;
        $inventariolaminarollo->fecha_rollo = $request->fecha_rollo;
        $inventariolaminarollo->norma = $request->norma;
        $inventariolaminarollo->ancho_rollo = $request->ancho_rollo;
        $inventariolaminarollo->consecutivo_rollo = $request->consecutivo_rollo;
        $inventariolaminarollo->observacion = $request->observacion;
        $inventariolaminarollo->proveedor_id = $request->proveedor;
        $inventariolaminarollo->material_id = $request->material;
        $inventariolaminarollo->orden_compra_id = $request->orden_compra;
        $inventariolaminarollo->operario_id = $request->operario;
        //$inventariolaminarollo->user_id = $request->user()->id;
	    $inventariolaminarollo->save();
        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];
	}

	public function store(IngresoLaminaRolloRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);
        //
        /*$this->validate($request, [
            'name' => 'required|max:255',
        ]);*/

        $solicitud = Solicitud::find($request->solicitud);
        $cantidad_disponible = $solicitud->cantidadMaterialDisponible($request->material);
        if($request->peso_validado > $cantidad_disponible){
            return response(['errors'=>['La cantidad máxima permitida en el campo peso validado es '.$cantidad_disponible]],422);
        }

        $inventariolaminarollo = new InventarioLaminaRollo();

        $inventariolaminarollo->fecha_recibido = $request->fecha_recibido;
        $inventariolaminarollo->peso_sin_validar = $request->peso_sin_validar;
        $inventariolaminarollo->peso_validado = $request->peso_validado;
        $inventariolaminarollo->espesor_validado = $request->espesor_validado;
        $inventariolaminarollo->solicitud_id = $request->solicitud;
        $inventariolaminarollo->lote = $request->lote;
        $inventariolaminarollo->no_identificacion_rollo = $request->no_identificacion_rollo;
        $inventariolaminarollo->fecha_rollo = $request->fecha_rollo;
        $inventariolaminarollo->norma = $request->norma;
        $inventariolaminarollo->ancho_rollo = $request->ancho_rollo;
        $inventariolaminarollo->consecutivo_rollo = $request->consecutivo_rollo;
        $inventariolaminarollo->observacion = $request->observacion;
        $inventariolaminarollo->proveedor_id = $request->proveedor;
        $inventariolaminarollo->material_id = $request->material;
        $inventariolaminarollo->orden_compra_id = $request->orden_compra;
        $inventariolaminarollo->operario_id = $request->operario;
        //$inventariolaminarollo->user_id = $request->user()->id;
	    $inventariolaminarollo->save();

	    return ['success'=>true];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$inventariolaminarollo = InventarioLaminaRollo::findOrFail($request->input('id'));

		$inventariolaminarollo->delete();
		return "OK";
	    
	}

    public function show($id){
        return redirect('/inventario/ingresomaterial/laminarollo');
    }
}