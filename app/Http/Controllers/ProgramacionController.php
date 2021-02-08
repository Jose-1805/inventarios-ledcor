<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\Archivo;
use InventariosLedcor\Models\Corte;
use InventariosLedcor\Models\Estado;
use InventariosLedcor\Models\Proveedor;
use InventariosLedcor\Models\Proyecto;
use InventariosLedcor\Models\Seguimiento;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\Programacion;
use InventariosLedcor\Http\Requests\ProgramacionRequest;

use DB;

class ProgramacionController extends Controller
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

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('programacion.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $programacion = Programacion::findOrFail($id);
	    return view('programacion.add', [
	        'model' => $programacion	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = Programacion::select(
            'programaciones.*',
            'programaciones.calculo_fert as calculo','proyectos.nombre as proyecto','estados.nombre as estado'
        )
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

        if($request->has('linea') && $request->input('linea')){
            $results->where('programaciones.linea',$request->input('linea'));
        }

        if($request->has('subensamble') && $request->input('subensamble')){
            $results->where('programaciones.subensamble',$request->input('subensamble'));
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

	public function update(ProgramacionRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);

	    $programacion = Programacion::find($request->id);

        //primer estado segun precedencia
        $estado_actual = $programacion->estado;
        //el posible siguiente estado a seleccionar
        $siguiente_estado = \InventariosLedcor\Models\Estado::where('estados.precedencia','>',$estado_actual->precedencia)->first();

        $estado = Estado::find($request->estado);
        //no se esta selecionando el siguiente ni el actual estado
        if($estado->precedencia > $siguiente_estado->precedencia){
            //indica que no es una confirmación
            if(!$request->has('confirmar_precedencia') || $request->confirmar_precedencia == 'no'){
                return ['success'=>false,'error_precedencia'=>true];
            }
        }

        if($estado_actual->precedencia > $estado->precedencia)
            return response(['errors'=>['La información enviada es incorrecta']],422);

	    if(!$programacion)return response(['errors'=>['La información enviada es incorrecta']],422);

        $programacion->linea = $request->linea;
        $programacion->tipo_item = $request->tipo_item;
        $programacion->subensamble = $request->subensamble;
        $programacion->tipo_tk = $request->tipo_tk;
        $programacion->no_preliminar_inicial = $request->no_preliminar_inicial;
        $programacion->no_preliminar_final = $request->no_preliminar_final;
        $programacion->no_fabricacion_inicial = $request->no_fabricacion_inicial;
        $programacion->no_fabricacion_final = $request->no_fabricacion_final;
        $programacion->calculo_fert = $request->calculo_fert;
        $programacion->orden_fabricacion_trafo = $request->orden_fabricacion_trafo;
        $programacion->cantidad_tk = $request->cantidad_tk;
        $programacion->proveedor_id = $request->proveedor;
        $programacion->progreso = $request->progreso;
        $programacion->reproceso = 'no';
        if($request->has('reproceso'))
            $programacion->reproceso = 'si';

        $programacion->KVA = $request->KVA;

        $programacion->baterias_tk = null;
        $programacion->no_elem = null;
        $programacion->ancho_rad = null;
        $programacion->longitud_rad = null;
        $programacion->peso_teorico_radiadores = null;
        $programacion->fecha_plan_formado_radiador = null;
        $programacion->fecha_entrega_formado = null;
        if($request->input('subensamble') == 'Rad MZ' || $request->input('subensamble') == 'Rad TB') {
            $programacion->baterias_tk = $request->baterias_tk;
            $programacion->no_elem = $request->no_elem;
            $programacion->ancho_rad = $request->ancho_rad;
            $programacion->longitud_rad = $request->longitud_rad;
            $programacion->peso_teorico_radiadores = $request->peso_teorico_radiadores;
            $programacion->fecha_plan_formado_radiador = $request->fecha_plan_formado_radiador;
            $programacion->fecha_entrega_formado = $request->fecha_entrega_formado;
        }

        $programacion->peso_teorico_tk = null;
        $programacion->peso_teorico_cajas = null;
        if($request->input('subensamble') == 'Tanque') {
            $programacion->peso_teorico_tk = $request->peso_teorico_tk;
            $programacion->peso_teorico_cajas = $request->peso_teorico_cajas;
        }

        $programacion->peso_teorico_prensas = null;
        if($request->input('subensamble') == 'Tanque')
            $programacion->peso_teorico_prensas = $request->peso_teorico_prensas;

        $programacion->fecha_liberacion_planos = $request->fecha_liberacion_planos;
        $programacion->fecha_entrega_material = $request->fecha_entrega_material;
        $programacion->fecha_plan = $request->fecha_plan;
        $programacion->confirmacion_inicial = $request->confirmacion_inicial;
        $programacion->fecha_entrega = $request->fecha_entrega;
        $programacion->proyecto_id = $request->proyecto;
        $programacion->estado_id = $request->estado;
        //$programacion->user_id = $request->user()->id;
	    $programacion->save();
        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];

	}

	public function store(ProgramacionRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        //primer estado segun precedencia
        $primer_estado = Estado::orderBy('precedencia')->first();

        $estado = Estado::find($request->estado);
        //no se esta selecionando la primera precedencia
        if($estado->precedencia > $primer_estado->precedencia){
            //indica que no es una confirmación
            if(!$request->has('confirmar_precedencia') || $request->confirmar_precedencia == 'no'){
                return ['success'=>false,'error_precedencia'=>true];
            }
        }

        $programacion = new Programacion;

        $programacion->linea = $request->linea;
        $programacion->tipo_item = $request->tipo_item;
        $programacion->subensamble = $request->subensamble;
        $programacion->tipo_tk = $request->tipo_tk;
        $programacion->no_preliminar_inicial = $request->no_preliminar_inicial;
        $programacion->no_preliminar_final = $request->no_preliminar_final;
        $programacion->no_fabricacion_inicial = $request->no_fabricacion_inicial;
        $programacion->no_fabricacion_final = $request->no_fabricacion_final;
        $programacion->calculo_fert = $request->calculo_fert;
        $programacion->orden_fabricacion_trafo = $request->orden_fabricacion_trafo;
        $programacion->cantidad_tk = $request->cantidad_tk;
        $programacion->proveedor_id = $request->proveedor;
        $programacion->progreso = $request->progreso;
        if($request->has('reproceso'))
            $programacion->reproceso = 'si';

        $programacion->KVA = $request->KVA;
        if($request->input('subensamble') == 'Rad MZ' || $request->input('subensamble') == 'Rad TB') {
            $programacion->baterias_tk = $request->baterias_tk;
            $programacion->no_elem = $request->no_elem;
            $programacion->ancho_rad = $request->ancho_rad;
            $programacion->longitud_rad = $request->longitud_rad;
            $programacion->peso_teorico_radiadores = $request->peso_teorico_radiadores;
            $programacion->fecha_plan_formado_radiador = $request->fecha_plan_formado_radiador;
            $programacion->fecha_entrega_formado = $request->fecha_entrega_formado;
        }

        if($request->input('subensamble') == 'Tanque') {
            $programacion->peso_teorico_tk = $request->peso_teorico_tk;
            $programacion->peso_teorico_cajas = $request->peso_teorico_cajas;
        }

        if($request->input('subensamble') == 'Tanque')
            $programacion->peso_teorico_prensas = $request->peso_teorico_prensas;

        $programacion->fecha_liberacion_planos = $request->fecha_liberacion_planos;
        $programacion->fecha_entrega_material = $request->fecha_entrega_material;
        $programacion->fecha_plan = $request->fecha_plan;
        $programacion->confirmacion_inicial = $request->confirmacion_inicial;
        $programacion->fecha_entrega = $request->fecha_entrega;
        $programacion->proyecto_id = $request->proyecto;
        $programacion->estado_id = $request->estado;
        //$programacion->user_id = $request->user()->id;

        /*if($programacion->linea == 'Adicionales'){
            $ultimo_consecutivo = Programacion::whereNotNull('no_preliminar_inicial')->orderBy('id','DESC')->first();
            $consecutivo = 0;
            if($ultimo_consecutivo){
                $consecutivo = intval(explode('_',$ultimo_consecutivo->no_preliminar_inicial)[1]);
            }
            $consecutivo++;
            $programacion->no_preliminar_inicial = 'AD_'.$consecutivo;
        }*/

        /*if($programacion->linea == 'Daño de máquina' || $programacion->subensamble == 'Daño de máquina'){
            $ultimo_consecutivo = Programacion::whereNotNull('no_preliminar_final')->orderBy('id','DESC')->first();
            $consecutivo = 0;
            if($ultimo_consecutivo){
                $consecutivo = intval(explode('_',$ultimo_consecutivo->no_preliminar_final)[1]);
            }
            $consecutivo++;
            $programacion->no_preliminar_final = 'DM_'.$consecutivo;
        }*/

	    $programacion->save();

	    return ['success'=>true];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$programacion = Programacion::findOrFail($request->input('id'));

		$programacion->delete();
		return "OK";
	    
	}

	public function copiar(Request $request){
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['errors'=>['Unauthorized.']],401);

        if($request->has('programacion')){
            $programacion = Programacion::find($request->input('programacion'));
            if($programacion){
                $programacion->id = null;
                $programacion->created_at = null;
                $programacion->updated_at = null;
                $programacion->exists = null;
                $programacion->save();

                return ['success'=>true,'programacion'=>$programacion->id];
            }
        }
    }

    public function anexos(Request $request)
    {
        if($request->has('programacion')){
            $programacion = Programacion::find($request->input('programacion'));
            if($programacion){
                return view('programacion.inputs.lista_anexos')->with('anexos',$programacion->anexos);
            }
        }
    }

    public function storeAnexo(Request $request){
        Validator::make($request->all(),[
            'archivo'=>'required|file|max:500',
            'programacion'=>'required|exists:programaciones,id'
        ],[
            'programacion.required'=>'La informaciòn enviada es incorecta',
            'programacion.exists'=>'La informaciòn enviada es incorecta',
        ])->validate();

        $file = $request->file('archivo');
        DB::beginTransaction();
        $archivo = new Archivo();
        $archivo->ubicacion = 'app/programaciones/anexos/'.$request->input('programacion').'/'.date('Y_m_d_H_i_s');
        $archivo->nombre = str_replace('-','_',$file->getClientOriginalName());
        $archivo->programacion_id = $request->input('programacion');
        $archivo->save();

        $file->move(storage_path($archivo->ubicacion),$archivo->nombre);
        DB::commit();
        return ['success'=>true];
    }

    public function formatoImportacion(Request $request){
        Excel::load(storage_path('/app/formatos/importacion_programacion.xlsx'),function ($reader){

            //Datos para N° de fabricación
            $reader->sheet(1,function ($sheet){
                $aux_proveedores = 2;
                Proveedor::select('id','nombre')->get()->each(function ($r) use (&$aux_proveedores,&$sheet){
                    $sheet->row($aux_proveedores,$r->toArray());
                    $aux_proveedores++;
                });
            });

            //Datos para proyectos
            $reader->sheet(2,function ($sheet){
                $aux_proyectos = 2;
                Proyecto::select('id','nombre','fecha_inicio')->each(function ($r) use (&$aux_proyectos,&$sheet){
                    $sheet->row($aux_proyectos,$r->toArray());
                    $aux_proyectos++;
                });
            });

            //Datos para estados
            $reader->sheet(3,function ($sheet){
                $aux_estados = 2;
                Estado::select('id','nombre','precedencia')->each(function ($r) use (&$aux_estados,&$sheet){
                    $sheet->row($aux_estados,$r->toArray());
                    $aux_estados++;
                });
            });
        })->download('xlsx');
    }

    public function importar(Request $request){
        $rules = [
            'archivo'=>'required|file|mimes:xlsx,xls|max:500'
        ];

        Validator::make($request->all(),$rules)->validate();
        $errors = [];
        DB::beginTransaction();
        Excel::load($request->file('archivo'),function ($reader) use (&$errors){
            $reader->sheet(0,function ($sheet) use (&$errors){
                $rows = $sheet->rows()->toArray();
                //debe tener más de 3 filas para contener información
                if(count($rows) > 3){
                    for ($i = 3;$i < count($rows);$i++){
                        //se pasan los datos a un array para validación
                        $data = [
                            'linea'=>$rows[$i][0],
                            'tipo_item'=>$rows[$i][1],
                            'subensamble'=>$rows[$i][2],
                            'tipo_tk'=>$rows[$i][3],
                            'no_preliminar_inicial'=>$rows[$i][4],
                            'no_preliminar_final'=>$rows[$i][5],
                            'no_fabricacion_inicial'=>$rows[$i][6],
                            'no_fabricacion_final'=>$rows[$i][7],
                            'calculo_fert'=>$rows[$i][8],
                            'orden_fabricacion_trafo'=>$rows[$i][9],
                            'cantidad_tk'=>$rows[$i][10],
                            'proyecto'=>$rows[$i][11],
                            'kva'=>$rows[$i][12],
                            'estado'=>$rows[$i][13],
                            'progreso'=>$rows[$i][14],
                            'proveedor'=>$rows[$i][15],
                            'reproceso'=>$rows[$i][16],
                            'baterias_tk'=>$rows[$i][17],
                            'no_elem'=>$rows[$i][18],
                            'ancho_rad'=>$rows[$i][19],
                            'longitud_rad'=>$rows[$i][20],
                            'peso_teorico_prensas'=>$rows[$i][21],
                            'peso_teorico_tk'=>$rows[$i][22],
                            'peso_teorico_cajas'=>$rows[$i][23],
                            'peso_teorico_radiadores'=>$rows[$i][24],
                            'fecha_plan_formado_radiador'=>$rows[$i][25],
                            'fecha_entrega_formado'=>$rows[$i][26],
                            'fecha_liberacion_planos'=>$rows[$i][27],
                            'confirmacion_inicial'=>$rows[$i][28],
                            'fecha_entrega_material'=>$rows[$i][29],
                            'fecha_plan'=>$rows[$i][30],
                            'fecha_entrega'=>$rows[$i][31]
                        ];

                        $rules = ProgramacionRequest::rulesImportacion($data);
                        $messages = ProgramacionRequest::messagesImportacion();

                        $validaror = Validator::make($data,$rules,$messages);

                        //se almacenan los errores si ocurre algún error
                        if($validaror->fails()){
                            $errors[] = '<strong>ERROR EN LA LINEA #'.($i + 1).'</strong>';
                            foreach ($validaror->errors()->all() as $e)
                                $errors[] = $e;
                        }else{
                            $programacion = new Programacion;

                            $programacion->linea = $data['linea'];
                            $programacion->tipo_item = $data['tipo_item'];
                            $programacion->subensamble = $data['subensamble'];
                            $programacion->tipo_tk = $data['tipo_tk'];
                            $programacion->orden_fabricacion_trafo = $data['orden_fabricacion_trafo'];
                            $programacion->cantidad_tk = $data['cantidad_tk'];
                            $programacion->progreso = $data['progreso'];
                            $programacion->reproceso = $data['reproceso'];
                            $programacion->kva = $data['kva'];
                            $programacion->no_preliminar_inicial = $data['no_preliminar_inicial'];
                            $programacion->no_preliminar_final = $data['no_preliminar_final'];
                            $programacion->no_fabricacion_inicial = $data['no_fabricacion_inicial'];
                            $programacion->no_fabricacion_final = $data['no_fabricacion_final'];
                            $programacion->calculo_fert = $data['calculo_fert'];
                            $programacion->proveedor_id = $data['proveedor'];

                            if($data['subensamble'] == 'Rad MZ' || $data['subensamble'] == 'Rad TB') {
                                $programacion->baterias_tk = $data['baterias_tk'];
                                $programacion->no_elem = $data['no_elem'];
                                $programacion->ancho_rad = $data['ancho_rad'];
                                $programacion->longitud_rad = $data['longitud_rad'];
                                $programacion->peso_teorico_radiadores = $data['peso_teorico_radiadores'];
                                $programacion->fecha_plan_formado_radiador = $data['fecha_plan_formado_radiador'];
                                $programacion->fecha_entrega_formado = $data['fecha_entrega_formado'];
                            }

                            if($data['subensamble'] == 'Tanque') {
                                $programacion->peso_teorico_tk = $data['peso_teorico_tk'];
                                $programacion->peso_teorico_cajas = $data['peso_teorico_cajas'];
                            }

                            if($data['subensamble'] == 'Tanque')
                                $programacion->peso_teorico_prensas = $data['peso_teorico_prensas'];

                            $programacion->fecha_liberacion_planos = $data['fecha_liberacion_planos'];
                            $programacion->fecha_entrega_material = $data['fecha_entrega_material'];
                            $programacion->fecha_plan = $data['fecha_plan'];
                            $programacion->confirmacion_inicial = $data['confirmacion_inicial'];
                            $programacion->fecha_entrega = $data['fecha_entrega'];
                            $programacion->proyecto_id = $data['proyecto'];
                            $programacion->estado_id = $data['estado'];

                            /*if($programacion->linea == 'Adicionales'){
                                $ultimo_consecutivo = Programacion::whereNotNull('no_preliminar_inicial')->orderBy('id','DESC')->first();
                                $consecutivo = 0;
                                if($ultimo_consecutivo){
                                    $consecutivo = intval(explode('_',$ultimo_consecutivo->no_preliminar_inicial)[1]);
                                }
                                $consecutivo++;
                                $programacion->no_preliminar_inicial = 'AD_'.$consecutivo;
                            }

                            if($programacion->linea == 'Daño de máquina' || $programacion->subensamble == 'Daño de máquina'){
                                $ultimo_consecutivo = Programacion::whereNotNull('no_preliminar_final')->orderBy('id','DESC')->first();
                                $consecutivo = 0;
                                if($ultimo_consecutivo){
                                    $consecutivo = intval(explode('_',$ultimo_consecutivo->no_preliminar_final)[1]);
                                }
                                $consecutivo++;
                                $programacion->no_preliminar_final = 'DM_'.$consecutivo;
                            }*/

                            $programacion->save();
                        }


                    }
                }else{
                    $errors[] = 'El archivo no tiene información para registrar';
                    return false;
                }
            });
        });

        if(count($errors)){
            DB::rollBack();
            return response(['errors'=>$errors],422);
        }else{
            DB::commit();
            return ['success'=>true];
        }
    }

    public function storeSeguimiento(Request $request){
        Validator::make($request->all(),
        [
            'nota'=>'required|max:255',
            'prg'=>'required|exists:programaciones,id'
        ],
        [
            'prg.required'=>'La información enviada es incorrecta.',
            'prg.exists'=>'La información enviada es incorrecta.'
        ])->validate();

        $programacion = Programacion::find($request->prg);
        $seguimiento = new Seguimiento();
        $seguimiento->nota = $request->nota;
        $seguimiento->programacion_id = $programacion->id;
        $seguimiento->estado_id = $programacion->estado_id;
        $seguimiento->user_id = Auth::user()->id;
        $seguimiento->save();
    }

    public function show($id){
        return redirect('/programacion');
    }
}