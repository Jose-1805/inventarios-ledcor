<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\KardexPerfileria;
use InventariosLedcor\Http\Requests\IngresoPerfileriaRequest;

use DB;

class KardexPerfileriaController extends Controller
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
	    return view('kardexperfileria.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('kardexperfileria.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $kardexperfileria = KardexPerfileria::findOrFail($id);
	    return view('kardexperfileria.add', [
	        'model' => $kardexperfileria	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = KardexPerfileria::select('inventario_kardex_perfileria.*'
            ,DB::raw('CONCAT(entrega_a.nombres," ",entrega_a.apellidos) as entrega_a')
            ,DB::raw('CONCAT(recibe_a.nombres," ",recibe_a.apellidos) as recibe_a')
            ,'proveedores.nombre as proveedor'
            ,'materiales.texto_breve as material'
        )
            ->join('proveedores','inventario_kardex_perfileria.proveedor_id','=','proveedores.id')
            ->join('users as entrega_a','inventario_kardex_perfileria.entrega_a','=','entrega_a.id')
            ->join('users as recibe_a','inventario_kardex_perfileria.recibe_a','=','recibe_a.id')
            ->join('materiales','inventario_kardex_perfileria.material_id','=','materiales.id')
            ->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/inventario/ingresomaterial/kardexperfileria/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/inventario/ingresomaterial/kardexperfileria/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(IngresoPerfileriaRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);
	    //
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
	    $kardexperfileria = KardexPerfileria::find($request->id);

	    if(!$kardexperfileria)return response(['errors'=>['La información enviada es incorrecta']],422);

        $kardexperfileria->cantidad = $request->cantidad;
        $kardexperfileria->fecha = $request->fecha;
        $kardexperfileria->observacion = $request->observacion;
        $kardexperfileria->material_id = $request->material;
        $kardexperfileria->entrega_a = $request->entrega_a;
        $kardexperfileria->recibe_a = $request->recibe_a;
        $kardexperfileria->proveedor_id = $request->proveedor_;
        //$kardexperfileria->user_id = $request->user()->id;
	    $kardexperfileria->save();
        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];

	}

	public function store(IngresoPerfileriaRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);
        //
        /*$this->validate($request, [
            'name' => 'required|max:255',
        ]);*/
        $kardexperfileria = new KardexPerfileria;

        $kardexperfileria->cantidad = $request->cantidad;
        $kardexperfileria->fecha = $request->fecha;
        $kardexperfileria->observacion = $request->observacion;
        $kardexperfileria->material_id = $request->material;
        $kardexperfileria->entrega_a = $request->entrega_a;
        $kardexperfileria->recibe_a = $request->recibe_a;
        $kardexperfileria->proveedor_id = $request->proveedor_;
        //$kardexperfileria->user_id = $request->user()->id;
	    $kardexperfileria->save();

	    return ['success'=>true];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$kardexperfileria = KardexPerfileria::findOrFail($request->input('id'));

		$kardexperfileria->delete();
		return "OK";
	    
	}

    public function show($id){
        return redirect('/inventario/ingresomaterial/kardexperfileria');
    }
}