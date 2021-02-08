<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\EntradaLaminaAlmacen;
use InventariosLedcor\Http\Requests\IngresoLaminaRequest;

use DB;

class InventarioLaminaController extends Controller
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
	    return view('inventariolamina.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('inventariolamina.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $inventariolamina = EntradaLaminaAlmacen::findOrFail($id);
	    return view('inventariolamina.add', [
	        'model' => $inventariolamina	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = EntradaLaminaAlmacen::select('entrada_lamina_almacen.*'
            ,'materiales.texto_breve as material')
            ->join('materiales','entrada_lamina_almacen.material_id','=','materiales.id')
            ->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/inventario/ingresomaterial/lamina/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/inventario/ingresomaterial/lamina/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(IngresoLaminaRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);

        $inventariolamina = EntradaLaminaAlmacen::find($request->id);

	    if(!$inventariolamina)return response(['errors'=>['La información enviada es incorrecta']],422);

        $inventariolamina->fecha_recibido = $request->fecha_recibido;
        $inventariolamina->consecutivo_lamina = $request->consecutivo_lamina;
        $inventariolamina->espesor_lote = $request->espesor_lote;
        $inventariolamina->peso_lamina_validado = $request->peso_lamina_validado;
        $inventariolamina->material_id = $request->material;
	    $inventariolamina->save();
        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];
	}

	public function store(IngresoLaminaRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);
        //
        /*$this->validate($request, [
            'name' => 'required|max:255',
        ]);*/
        $inventariolamina = new EntradaLaminaAlmacen();

        $inventariolamina->fecha_recibido = $request->fecha_recibido;
        $inventariolamina->consecutivo_lamina = $request->consecutivo_lamina;
        $inventariolamina->espesor_lote = $request->espesor_lote;
        $inventariolamina->peso_lamina_validado = $request->peso_lamina_validado;
        $inventariolamina->material_id = $request->material;
	    $inventariolamina->save();

	    return ['success'=>true];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$inventariolamina = EntradaLaminaAlmacen::findOrFail($request->input('id'));

		$inventariolamina->delete();
		return "OK";
	    
	}

    public function show($id){
        return redirect('/inventario/ingresomaterial/lamina');
    }
}