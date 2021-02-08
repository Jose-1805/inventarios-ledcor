<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\DetalleCorte;
use InventariosLedcor\Models\Programacion;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\Corte;
use InventariosLedcor\Http\Requests\CorteRequest;
use InventariosLedcor\Http\Requests\DetalleManualCorteRequest;

use DB;

class CorteController extends Controller
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
	    return view('corte.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('corte.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $corte = Corte::findOrFail($id);
	    return view('corte.add', [
	        'model' => $corte	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = Corte::select(
            'cortes.*',
            'calculos.numero as calculo','calculos.fert','proyectos.nombre as proyecto',
            DB::raw('CONCAT(users.nombres," ",users.apellidos) as elaborado_por')
        )
            ->join('calculos','cortes.calculo_id','=','calculos.id')
            ->join('proyectos','cortes.proyecto_id','=','proyectos.id')
            ->join('users','cortes.user_id','=','users.id');

        if($request->has('ensamble') && $request->ensamble)
            $results = $results->where('cortes.ensamble',$request->ensamble);

        $results = $results->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('seleccion',function ($r){
                if($r->verificacion_calidad == 'si'){
                    return '<input type="checkbox" name="seleccion_'.$r->id.'" id="seleccion_'.$r->id.'" data-corte="'.$r->id.'" class="check-corte">';
                }
            })
            ->editColumn('opciones', function ($r) {
                $opc = '';
                if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                    $opc .= '<a href="' . url('/corte/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
                }

                if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                    $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/corte/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
                }

                return $opc;

            })->rawColumns(['opciones','seleccion']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(CorteRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);
	    //
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
	    $corte = Corte::find($request->id);

	    if(!$corte)return response(['errors'=>['La información enviada es incorrecta']],422);

	    if(!$corte->permitirEdicion())return response(['errors'=>['El corte ha superado la fecha máxima de edición']],422);


        $corte->ensamble = $request->ensamble;
        $corte->no_fabricacion_inicial = $request->no_fabricacion_inicial;
        $corte->no_fabricacion_final = $request->no_fabricacion_final;
        $corte->cantidad_tk = $request->cantidad_tk;
        $corte->fecha_listado = $request->fecha_listado;
        $corte->peso_tanque = $request->peso_tanque;
        $corte->peso_prensa = $request->peso_prensa;
        $corte->peso_caja = $request->peso_caja;
        $corte->peso_otro_item = $request->peso_otro_item;
        $corte->observacion = $request->observacion;
        $corte->calculo_id = $request->calculo;
        $corte->proyecto_id = $request->proyecto;
        $corte->user_id = $request->user;
        $corte->verificacion_calidad = 'no';
        if($request->has('verificacion_calidad') && $request->verificacion_calidad == 'si')
            $corte->verificacion_calidad = 'si';
        //$corte->user_id = $request->user()->id;
	    $corte->save();
	    $corte->desasociarDetalles();
	    $corte->asociarDetalles();
        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];

	}

	public function store(CorteRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);
        //
        /*$this->validate($request, [
            'name' => 'required|max:255',
        ]);*/
        $corte = new Corte;

        $corte->ensamble = $request->ensamble;
        $corte->no_fabricacion_inicial = $request->no_fabricacion_inicial;
        $corte->no_fabricacion_final = $request->no_fabricacion_final;
        $corte->cantidad_tk = $request->cantidad_tk;
        $corte->fecha_listado = $request->fecha_listado;
        $corte->peso_tanque = $request->peso_tanque;
        $corte->peso_prensa = $request->peso_prensa;
        $corte->peso_caja = $request->peso_caja;
        $corte->peso_otro_item = $request->peso_otro_item;
        $corte->observacion = $request->observacion;
        $corte->calculo_id = $request->calculo;
        $corte->proyecto_id = $request->proyecto;
        $corte->user_id = $request->user;

        if($request->has('verificacion_calidad') && $request->verificacion_calidad == 'si')
            $corte->verificacion_calidad = 'si';

        //$corte->user_id = $request->user()->id;
	    $corte->save();
	    $corte->asociarDetalles();
        session()->push('msj_success','Elemento creado con éxito.');
	    return ['success'=>true,'href'=>url('/corte/'.$corte->id.'/edit')];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$corte = Corte::findOrFail($request->input('id'));

		$corte->delete();
		return "OK";
	    
	}

    public function listaDetalle(Request $request)
    {
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');

        if($request->has('corte')) {
            $results = DetalleCorte::select(
                'detalles_cortes.*',
                'materiales.codigo as codigo_material', 'materiales.especificacion', 'materiales.texto_breve as descripcion','materiales.espesor_mm as espesor','materiales.unidad_medida as unidad'
            )
                ->join('cortes', 'detalles_cortes.corte_id', '=', 'cortes.id')
                ->join('materiales', 'detalles_cortes.material_id', '=', 'materiales.id')
                ->where('cortes.id',$request->input('corte'))
                ->get();

            $table = Datatables::of($results);//->removeColumn('id');

            $table = $table->editColumn('opciones', function ($r) {
                $opc = '';
                if (Auth::user()->tieneFuncion(3, 2, $this->privilegio_superadministrador)) {
                    $opc .= '<a href="#!" class="btn btn-xs btn-primary margin-2 btn-editar-detalle-manual" data-detalle="'.$r->id.'" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
                }

                if (Auth::user()->tieneFuncion(3, 3, $this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                    $opc .= '<a href="#!" data-elemento-lista="' . $r->id . '" data-url="' . url('/corte/delete-detalle-manual') . '" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
                }

                return $opc;

            })->rawColumns(['opciones']);

            if (!Auth::user()->tieneFunciones(3, [2, 3], false, $this->privilegio_superadministrador)) $table->removeColumn('opciones');

            $table = $table->make(true);
            return $table;
        }
    }

    public function formDetalleManual(Request $request){
        if($request->has('corte') && $request->input('corte')) {
            $corte = Corte::find($request->input('corte'));

            $detalle = new DetalleCorte();
            if ($request->has('id') && $request->input('id'))
                $detalle = DetalleCorte::where('corte_id',$request->input('corte'))->find($request->input('id'));

            return view('corte/form_detalle_manual', ['detalle' => $detalle,'corte'=>$corte]);
        }
    }

    public function storeDetalleManual(DetalleManualCorteRequest $request){
        $detalle = new DetalleCorte();
        if($request->has('corte') && $request->has('detalle'))
            $detalle = DetalleCorte::where('corte_id',$request->input('corte'))->find($request->input('detalle'));


        if($detalle) {
            $corte = Corte::find($request->corte);
            if(!$corte->permitirEdicion())
                return response(['errors'=>['El corte ha superado la fecha máxima de edición']],422);

            $detalle->posicion = $request->posicion;
            $detalle->plano = $request->plano;
            $detalle->ensamble = $request->ensamble;
            $detalle->nombre = $request->nombre;
            $detalle->cantidad = $request->cantidad;
            $detalle->longitud_1 = $request->longitud_1;
            $detalle->longitud_2 = $request->longitud_2;
            $detalle->centro_corte = $request->centro_corte;
            $detalle->peso_neto = $request->peso_neto;
            $detalle->masa = $request->masa;
            $detalle->proceso = $request->proceso;
            $detalle->observaciones = $request->observaciones;
            $detalle->corte_id = $request->corte;
            $detalle->material_id = $request->material;
            $detalle->save();
            return ['success'=>true];
        }

        return response(['errors'=>['error'=>['La información enviada es incorrecta']]],422);
    }

    public function deleteDetalleManual(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $corte = DetalleCorte   ::findOrFail($request->input('id'));

        $corte->delete();
        return "OK";

    }

    public function vistaImprimirDocumentos(Request $request){
        $cortes = Corte::whereIn('id',$request->cortes)->get();
        if(count($cortes)) {
            return view('corte.vista_imprimir_documentos')->with('cortes', $cortes);
        }
        return 'No se han seleccionado cortes';
    }

    public function certificadoCalidad($corte){
        $corte = Corte::find($corte);
        if($corte){
            $proyecto = $corte->proyecto;
            $calculo = $corte->calculo;
            Excel::load(storage_path('/app/formatos/imprimir/certificado_calidad.xlsx'),function ($reader) use (&$corte,&$proyecto,&$calculo){

                $reader->sheet(0,function ($sheet) use (&$corte,&$proyecto,&$calculo){

                    //proceso
                    $sheet->cell('H7', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });

                    //sub-ensamble
                    $sheet->cell('J7', function($cell) use (&$corte){
                        $cell->setValue($corte->ensamble);
                    });

                    //proyecto
                    $sheet->cell('B12', function($cell) use (&$proyecto){
                        $cell->setValue($proyecto->nombre);
                    });

                    //calculo
                    $sheet->cell('J12', function($cell) use (&$calculo){
                        $cell->setValue($calculo->numero);
                    });

                    //celda kva
                    $sheet->cell('B14', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });

                    //celda tipo
                    $sheet->cell('D14', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });

                    //n° fab inicial
                    $sheet->cell('F14', function($cell) use (&$corte){
                        $cell->setValue($corte->no_fabricacion_inicial);
                    });

                    //n° fab final
                    $sheet->cell('H14', function($cell) use (&$corte){
                        $cell->setValue($corte->no_fabricacion_final);
                    });

                    //linea
                    $sheet->cell('J14', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });

                    //cantidad
                    $sheet->cell('K14', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                });

            })->download('xlsx');
        }
        return redirect()->back();
    }

    public function registroHermeticidad($corte){
        $corte = Corte::find($corte);
        if($corte){
            $proyecto = $corte->proyecto;
            $calculo = $corte->calculo;
            Excel::load(storage_path('/app/formatos/imprimir/registro_hermeticidad.xlsx'),function ($reader) use (&$corte,&$proyecto,&$calculo){

                $reader->sheet(0,function ($sheet) use (&$corte,&$proyecto,&$calculo){

                    //Tipo radiador
                    $sheet->cell('B8', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //Proyecto
                    $sheet->cell('J8', function($cell) use (&$proyecto){
                        $cell->setValue($proyecto->nombre);
                    });
                    //Calculo
                    $sheet->cell('AB8', function($cell) use (&$calculo){
                        $cell->setValue($calculo->numero);
                    });

                    //Radiadores por tanque
                    $sheet->cell('B10', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //Total Radiadores
                    $sheet->cell('J10', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //Numero de elementos
                    $sheet->cell('P10', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //N° Fab Inicial
                    $sheet->cell('V10', function($cell) use (&$corte){
                        $cell->setValue($corte->no_fabricacion_inicial);
                    });
                    //N° Fab final
                    $sheet->cell('AB10', function($cell) use (&$corte){
                        $cell->setValue($corte->no_fabricacion_final);
                    });


                    //Linea
                    $sheet->cell('B12', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //Largo (mm)
                    $sheet->cell('G12', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //Ancho (mm)
                    $sheet->cell('M12', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //Plano
                    $sheet->cell('S13', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //Peso
                    $sheet->cell('AD11', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });

                });

            })->download('xlsx');
        }
        return redirect()->back();
    }

    public function liberacionTanque($corte){
        $corte = Corte::find($corte);
        if($corte){
            $proyecto = $corte->proyecto;
            $calculo = $corte->calculo;
            Excel::load(storage_path('/app/formatos/imprimir/liberacion_tanque.xlsx'),function ($reader) use (&$corte,&$proyecto,&$calculo){

                $reader->sheet(0,function ($sheet) use (&$corte,&$proyecto,&$calculo){

                    //ensamble
                    $sheet->cell('B6', function($cell) use (&$corte){
                        $cell->setValue($corte->ensamble);
                    });
                    //KVA
                    $sheet->cell('L6', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //N° Fabricación
                    $sheet->cell('R6', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //calculo
                    $sheet->cell('AH6', function($cell) use (&$calculo){
                        $cell->setValue($calculo->numero);
                    });

                    //FERT
                    $sheet->cell('B8', function($cell) use (&$calculo){
                        $cell->setValue($calculo->fert);
                    });
                    //Proyecto
                    $sheet->cell('L8', function($cell) use (&$proyecto){
                        $cell->setValue($proyecto->nombre);
                    });
                });

            })->download('xlsx');
        }
        return redirect()->back();
    }

    public function liberacionMdt($corte){
        $corte = Corte::find($corte);
        if($corte){
            $proyecto = $corte->proyecto;
            $calculo = $corte->calculo;
            Excel::load(storage_path('/app/formatos/imprimir/liberacion_mdt.xlsx'),function ($reader) use (&$corte,&$proyecto,&$calculo){

                $reader->sheet(0,function ($sheet) use (&$corte,&$proyecto,&$calculo){

                    //ensamble
                    $sheet->cell('B6', function($cell) use (&$corte){
                        $cell->setValue($corte->ensamble);
                    });
                    //KVA
                    $sheet->cell('L6', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //N° Fabricación
                    $sheet->cell('R6', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //calculo
                    $sheet->cell('AH6', function($cell) use (&$calculo){
                        $cell->setValue($calculo->numero);
                    });

                    //Linea
                    $sheet->cell('B8', function($cell) use (&$corte){
                        $cell->setValue('XXXXX');
                    });
                    //FERT
                    $sheet->cell('G8', function($cell) use (&$calculo){
                        $cell->setValue($calculo->fert);
                    });
                    //Proyecto
                    $sheet->cell('L8', function($cell) use (&$proyecto){
                        $cell->setValue($proyecto->nombre);
                    });
                });

            })->download('xlsx');
        }
        return redirect()->back();
    }

    public function dataProgramacion(Request $request){
        if($request->has('no_fabricacion_inicial')){
            $programacion = Programacion::select('programaciones.*','calculos.id as calculo')
                ->leftJoin('calculos','programaciones.calculo_fert','=','calculos.fert')
                ->where('no_fabricacion_inicial',$request->no_fabricacion_inicial)->first();
            if($programacion){
                return ['success'=>true,'programacion'=>$programacion];
            }
        }
    }

    public function show($id){
        return redirect('/corte');
    }
}