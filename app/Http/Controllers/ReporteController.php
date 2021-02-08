<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\Archivo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\Programacion;
use InventariosLedcor\Http\Requests\ProgramacionRequest;

use DB;

class ReporteController extends Controller
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
	    return view('programacion.index', []);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = Programacion::select(
            'programaciones.*',
            'calculos.numero as calculo','proyectos.nombre as proyecto','estados.nombre as estado',
            'cortes.no_fabricacion_inicial','corte_final.no_fabricacion_final'
        )->join('cortes','programaciones.corte_id','=','cortes.id')
        ->join('cortes as corte_final','programaciones.corte_final_id','=','corte_final.id')
        ->join('calculos','cortes.calculo_id','=','calculos.id')
        ->join('proyectos','programaciones.proyecto_id','=','proyectos.id')
        ->join('estados','programaciones.estado_id','=','estados.id');

        if($request->has('estado') && $request->input('estado')){
            $results->where('estados.id',$request->input('estado'));
        }

        if($request->has('fecha_inicial') && $request->input('fecha_inicial')){
            $results->where('programaciones.fecha_plan','>=',$request->input('fecha_inicial'));
        }

        if($request->has('fecha_final') && $request->input('fecha_final')){
            $results->where('programaciones.fecha_plan','<=',$request->input('fecha_final'));
        }

        $results = $results->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/programacion/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/programacion/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}
}