<?php

namespace InventariosLedcor\Http\Controllers;

use Collective\Html\FormFacade;
use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\Material;
use InventariosLedcor\Http\Requests\MaterialRequest;

use DB;

class MaterialController extends Controller
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
	    return view('material.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('material.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $material = Material::findOrFail($id);
	    return view('material.add', [
	        'model' => $material	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = Material::select('*')->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/inventario/material/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/inventario/material/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(MaterialRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);
	    //
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
	    $material = Material::find($request->id);

	    if(!$material)return response(['errors'=>['La información enviada es incorrecta']],422);

        $material->familia = $request->familia;
        $material->unidad_medida = $request->unidad_medida;
        $material->presentacion = $request->presentacion;
        $material->especificacion = $request->especificacion;
        $material->codigo = $request->codigo;
        $material->texto_breve = $request->texto_breve;
        $material->codigo_plano = $request->codigo_plano;
        $material->valor_unidad = $request->valor_unidad;
        $material->espesor_mm = $request->espesor_mm;
        $material->unidad_solicitud = $request->unidad_solicitud;
        $material->cantidad = $request->cantidad;
	    $material->save();
        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];

	}

	public function store(MaterialRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);
        //
        /*$this->validate($request, [
            'name' => 'required|max:255',
        ]);*/
        $material = new Material;

        $material->familia = $request->familia;
        $material->unidad_medida = $request->unidad_medida;
        $material->presentacion = $request->presentacion;
        $material->especificacion = $request->especificacion;
        $material->codigo = $request->codigo;
        $material->texto_breve = $request->texto_breve;
        $material->codigo_plano = $request->codigo_plano;
        $material->valor_unidad = $request->valor_unidad;
        $material->espesor_mm = $request->espesor_mm;
        $material->unidad_solicitud = $request->unidad_solicitud;
        $material->cantidad = $request->cantidad;
	    $material->save();

	    return ['success'=>true];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$material = Material::findOrFail($request->input('id'));

		$material->delete();
		return "OK";
	    
	}

    function getSelectFamilia(Request $request){
        $materiales = Material::select('materiales.texto_breve','materiales.id')
            ->where('familia',$request->familia)
            ->pluck('texto_breve','id');

        return FormFacade::select($request->name,$materiales,null,['id'=>$request->name,'class'=>'form-control']);
    }

    public function show($id){
        return redirect('/material');
    }
}