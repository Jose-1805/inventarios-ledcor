<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\DetalleCalculo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\Calculo;
use InventariosLedcor\Http\Requests\CalculoRequest;
use InventariosLedcor\Http\Requests\DetalleManualCalculoRequest;

use DB;

class CalculoController extends Controller
{
    public $privilegio_superadministrador = true;

    public function __construct()
    {
        $this->middleware('permisoModulo:3,' . $this->privilegio_superadministrador);
    }


    public function index(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('calculo.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('calculo.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $calculo = Calculo::findOrFail($id);
	    return view('calculo.add', [
	        'model' => $calculo	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = Calculo::select('calculos.*')->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('seleccion',function ($r){
            return '<a href="#!" data-elemento-lista="'.$r->id.'" class="btn btn-xs btn-success margin-2 btn-ver-detalle"><i class="white-text fa fa-view"></i></a>';
        })
        ->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/calculo/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/calculo/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['seleccion','opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(CalculoRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);
	    //
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
	    $calculo = Calculo::find($request->id);

	    if(!$calculo)return response(['errors'=>['La información enviada es incorrecta']],422);

        $calculo->numero = $request->numero;
        $calculo->ensamble = $request->ensamble;
        $calculo->fert = $request->fert;
	    $calculo->save();
        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];

	}

	public function store(CalculoRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $calculo = new Calculo;

        $calculo->numero = $request->numero;
        $calculo->ensamble = $request->ensamble;
        $calculo->fert = $request->fert;
	    $calculo->save();
        session()->push('msj_success','Elemento creado con éxito.');
	    return ['success'=>true,'href'=>url('/calculo/'.$calculo->id.'/edit')];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$calculo = Calculo::findOrFail($request->input('id'));

		$calculo->delete();
		return "OK";
	    
	}

    public function listaDetalle(Request $request)
    {
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');

        if($request->has('calculo')) {
            $results = DetalleCalculo::select(
                'detalles_calculos.*',
                'materiales.codigo as codigo_material','materiales.espesor_mm as espesor','materiales.unidad_medida as unidad','materiales.especificacion','materiales.texto_breve as descripcion'
            )
                ->join('calculos', 'detalles_calculos.calculo_id', '=', 'calculos.id')
                ->join('materiales', 'detalles_calculos.material_id', '=', 'materiales.id')
                ->where('calculos.id',$request->input('calculo'))
                ->get();

            $table = Datatables::of($results);//->removeColumn('id');

            $table = $table->editColumn('opciones', function ($r) {
                $opc = '';
                if (Auth::user()->tieneFuncion(3, 2, $this->privilegio_superadministrador)) {
                    $opc .= '<a href="#!" class="btn btn-xs btn-primary margin-2 btn-editar-detalle-manual" data-detalle="'.$r->id.'" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
                }

                if (Auth::user()->tieneFuncion(3, 3, $this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                    $opc .= '<a href="#!" data-elemento-lista="' . $r->id . '" data-url="' . url('/calculo/delete-detalle-manual') . '" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
                }

                return $opc;

            })->rawColumns(['opciones']);

            if (!Auth::user()->tieneFunciones(3, [2, 3], false, $this->privilegio_superadministrador)) $table->removeColumn('opciones');

            $table = $table->make(true);
            return $table;
        }
    }

    public function formDetalleManual(Request $request){
        if($request->has('calculo') && $request->input('calculo')) {
            $calculo = Calculo::find($request->input('calculo'));

            $detalle = new DetalleCalculo();
            if ($request->has('id') && $request->input('id'))
                $detalle = DetalleCalculo::where('calculo_id',$request->input('calculo'))->find($request->input('id'));

            return view('calculo/form_detalle_manual', ['detalle' => $detalle,'calculo'=>$calculo]);
        }
    }

    public function storeDetalleManual(DetalleManualCalculoRequest $request){
        $detalle = new DetalleCalculo();
        if($request->has('calculo') && $request->has('detalle'))
            $detalle = DetalleCalculo::where('calculo_id',$request->input('calculo'))->find($request->input('detalle'));

        if($detalle) {
            $detalle->posicion = $request->posicion;
            $detalle->plano = $request->plano;
            $detalle->ensamble = $request->ensamble;
            $detalle->nombre = $request->nombre;
            $detalle->longitud_1 = $request->longitud_1;
            $detalle->longitud_2 = $request->longitud_2;
            $detalle->masa = $request->masa;
            $detalle->material_id = $request->material;
            $detalle->peso_neto = $request->peso_neto;
            $detalle->centro_corte = $request->centro_corte;
            $detalle->proceso = $request->proceso;
            $detalle->observaciones = $request->observaciones;
            $detalle->calculo_id = $request->calculo;
            $detalle->save();
            return ['success'=>true];
        }

        return response(['errors'=>['error'=>['La información enviada es incorrecta']]],422);
    }

    public function deleteDetalleManual(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $calculo = DetalleCalculo   ::findOrFail($request->input('id'));

        $calculo->delete();
        return "OK";
    }

    public function show($id){
        return redirect('/calculo');
    }
}