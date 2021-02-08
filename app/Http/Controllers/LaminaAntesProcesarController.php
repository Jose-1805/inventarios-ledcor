<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\Solicitud;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\LaminaAntesProcesar;
use InventariosLedcor\Http\Requests\IngresoLaminaSinProcesarRequest;

use DB;

class LaminaAntesProcesarController extends Controller
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
	    return view('laminaantesprocesar.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('laminaantesprocesar.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $laminaantesprocesar = LaminaAntesProcesar::findOrFail($id);
	    return view('laminaantesprocesar.add', [
	        'model' => $laminaantesprocesar	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = LaminaAntesProcesar::select('recepcion_lamina_antes_procesar.*','materiales.texto_breve',DB::raw('CONCAT(users.nombres," ",users.apellidos) as operario'),'ordenes_compras.numero as orden_compra')
            ->join('users','recepcion_lamina_antes_procesar.operario_id','=','users.id')
            ->join('ordenes_compras','recepcion_lamina_antes_procesar.orden_compra_id','=','ordenes_compras.id')
            ->join('materiales','recepcion_lamina_antes_procesar.material_id','=','materiales.id')
            ->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/inventario/ingresomaterial/laminaantesprocesar/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/inventario/ingresomaterial/laminaantesprocesar/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(IngresoLaminaSinProcesarRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);
	    //
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
	    $laminaantesprocesar = LaminaAntesProcesar::find($request->id);

	    if(!$laminaantesprocesar)return response(['errors'=>['La información enviada es incorrecta']],422);

        $solicitud = Solicitud::find($request->solicitud);
        $cantidad_disponible = $solicitud->cantidadMaterialDisponible($request->material);
        if(($request->peso_por_lamina * $request->cantidad * $request->ancho) > ($cantidad_disponible + ($laminaantesprocesar->peso_por_lamina * $laminaantesprocesar->cantidad * $laminaantesprocesar->ancho))){
            return response(['errors'=>['El producto máximo entre los campos (peso lámina, cantidad y ancho) es '.($cantidad_disponible+($laminaantesprocesar->peso_por_lamina * $laminaantesprocesar->cantidad * $laminaantesprocesar->ancho))]],422);
        }

        $laminaantesprocesar->fecha_recibido = $request->fecha_recibido;
        $laminaantesprocesar->cantidad = $request->cantidad;
        $laminaantesprocesar->espesor_mm = $request->espesor_mm;
        $laminaantesprocesar->peso_por_lamina = $request->peso_por_lamina;
        $laminaantesprocesar->lote = $request->lote;
        $laminaantesprocesar->peso_guacal = $request->peso_guacal;
        $laminaantesprocesar->largo = $request->largo;
        $laminaantesprocesar->ancho = $request->ancho;
        $laminaantesprocesar->observacion = $request->observacion;
        $laminaantesprocesar->material_id = $request->material;
        $laminaantesprocesar->solicitud_id = $request->solicitud;
        $laminaantesprocesar->orden_compra_id = $request->orden_compra;
        $laminaantesprocesar->operario_id = $request->operario;
        //$laminaantesprocesar->user_id = $request->user()->id;
	    $laminaantesprocesar->save();
        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];

	}

	public function store(IngresoLaminaSinProcesarRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $solicitud = Solicitud::find($request->solicitud);
        $cantidad_disponible = $solicitud->cantidadMaterialDisponible($request->material);
        if(($request->peso_por_lamina * $request->cantidad * $request->ancho) > $cantidad_disponible){
            return response(['errors'=>['El producto máximo entre los campos (peso lámina, cantidad y ancho) es '.$cantidad_disponible]],422);
        }

        $laminaantesprocesar = new LaminaAntesProcesar;

        $laminaantesprocesar->fecha_recibido = $request->fecha_recibido;
        $laminaantesprocesar->cantidad = $request->cantidad;
        $laminaantesprocesar->espesor_mm = $request->espesor_mm;
        $laminaantesprocesar->peso_por_lamina = $request->peso_por_lamina;
        $laminaantesprocesar->lote = $request->lote;
        $laminaantesprocesar->peso_guacal = $request->peso_guacal;
        $laminaantesprocesar->largo = $request->largo;
        $laminaantesprocesar->ancho = $request->ancho;
        $laminaantesprocesar->observacion = $request->observacion;
        $laminaantesprocesar->material_id = $request->material;
        $laminaantesprocesar->solicitud_id = $request->solicitud;
        $laminaantesprocesar->orden_compra_id = $request->orden_compra;
        $laminaantesprocesar->operario_id = $request->operario;
        //$laminaantesprocesar->user_id = $request->user()->id;
	    $laminaantesprocesar->save();

	    return ['success'=>true];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$laminaantesprocesar = LaminaAntesProcesar::findOrFail($request->input('id'));

		$laminaantesprocesar->delete();
		return "OK";
	    
	}

    public function show($id){
        return redirect('/inventario/ingresomaterial/laminaantesprocesar');
    }
}