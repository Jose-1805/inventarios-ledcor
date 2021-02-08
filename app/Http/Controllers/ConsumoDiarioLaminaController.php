<?php

namespace InventariosLedcor\Http\Controllers;

use Collective\Html\FormFacade;
use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\ConsumoKardexRetalLamina;
use InventariosLedcor\Models\EntradaLaminaAlmacen;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\ConsumoDiarioLamina;
use InventariosLedcor\Http\Requests\ConsumoLaminaRequest;

use DB;

class ConsumoDiarioLaminaController extends Controller
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
	    return view('consumodiariolamina.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('consumodiariolamina.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $consumodiariolamina = ConsumoDiarioLamina::findOrFail($id);
	    return view('consumodiariolamina.add', [
	        'model' => $consumodiariolamina	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = ConsumoDiarioLamina::select(
            'consumo_diario_lamina.id','consumo_diario_lamina.fecha','consumo_diario_lamina.consumo','consumo_diario_lamina.desperdicio','consumo_diario_lamina.observacion',
            'entrada_lamina_almacen.consecutivo_lamina','cortes.peso_tanque','cortes.peso_prensa','cortes.no_fabricacion_inicial as no_fabricacion',
            DB::raw('CONCAT(users.nombres," ",users.apellidos) as operario'),
            'materiales.espesor_mm as espesor','materiales.texto_breve as material',
            'proyectos.nombre as proyecto',
            'calculos.numero as calculo','calculos.fert'
        )
            ->join('users','consumo_diario_lamina.operario_id','=','users.id')
            ->join('cortes','consumo_diario_lamina.corte_id','=','cortes.id')
            ->join('entrada_lamina_almacen','consumo_diario_lamina.entrada_lamina_almacen_id','=','entrada_lamina_almacen.id')
            ->join('proyectos','cortes.proyecto_id','=','proyectos.id')
            ->join('calculos','cortes.calculo_id','=','calculos.id')
            ->join('materiales','entrada_lamina_almacen.material_id','=','materiales.id')
            ->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/inventario/consumomaterial/lamina/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/inventario/consumomaterial/lamina/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(ConsumoLaminaRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);
	    //
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
        DB::beginTransaction();

        $consumodiariolamina = ConsumoDiarioLamina::find($request->id);
        if(!$consumodiariolamina)return response(['errors'=>['La información enviada es incorrecta']],422);

        $inventario_lamina_previo = $consumodiariolamina->entradaLaminaAlmacen;
        $material_previo = $inventario_lamina_previo->material;

        //se reestablecen los valores descontados en la creación
        $material_previo->cantidad += $consumodiariolamina->consumo + $consumodiariolamina->desperdicio;
        $material_previo->save();
        $inventario_lamina_previo->peso_lamina_validado += $consumodiariolamina->consumo + $consumodiariolamina->desperdicio;
        $inventario_lamina_previo->save();

        $inventario_lamina = EntradaLaminaAlmacen::find($request->entrada_lamina_almacen);
        $material = $inventario_lamina->material;
        if($inventario_lamina->peso_lamina_validado < ($request->consumo + $request->desperdicio)){
            return response(['errors'=>['El valor máximo para la suma de los campos consumo y desperdicio es '.$inventario_lamina->peso_lamina_validado]],422);
        }
        if($material->cantidad < ($request->consumo + $request->desperdicio)){
            return response(['errors'=>['Cantidad de material insuficiente, máximo '.$material->cantidad]],422);
        }

        //validacion del retal
        $entrada_lamina_almacen_retal = EntradaLaminaAlmacen::join('kardex_retal_lamina','entrada_lamina_almacen.id','=','kardex_retal_lamina.entrada_lamina_almacen_id')
            ->where('kardex_retal_lamina.id',$request->retal)
            ->where('entrada_lamina_almacen.id',$request->entrada_lamina_almacen)
            ->first();
        if(!$entrada_lamina_almacen_retal)
            return response(['errors'=>['La información enviada es incorrecta']],422);

        $consumodiariolamina->maquina = $request->maquina;
        $consumodiariolamina->fecha = $request->fecha;
        $consumodiariolamina->ensamble = $request->ensamble;
        $consumodiariolamina->consumo = $request->consumo;
        $consumodiariolamina->desperdicio = $request->desperdicio;
        $consumodiariolamina->consecutivo_retal = $request->consecutivo_retal;
        $consumodiariolamina->observacion = $request->observacion;
        $consumodiariolamina->entrada_lamina_almacen_id = $request->entrada_lamina_almacen;
        $consumodiariolamina->corte_id = $request->corte;
        $consumodiariolamina->operario_id = $request->operario;
        $consumodiariolamina->kardex_retal_lamina_id = $request->retal;
	    $consumodiariolamina->save();

        $material->cantidad -= ($request->consumo + $request->desperdicio);
        $material->save();
        $inventario_lamina->peso_lamina_validado -= ($request->consumo + $request->desperdicio);
        $inventario_lamina->save();
        DB::commit();

        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];

	}

	public function store(ConsumoLaminaRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $inventario_lamina = EntradaLaminaAlmacen::find($request->entrada_lamina_almacen);
        $material = $inventario_lamina->material;
        if($inventario_lamina->peso_lamina_validado < ($request->consumo + $request->desperdicio)){
            return response(['errors'=>['El valor máximo para la suma de los campos consumo y desperdicio es '.$inventario_lamina->peso_lamina_validado]],422);
        }
        if($material->cantidad < ($request->consumo + $request->desperdicio)){
            return response(['errors'=>['Cantidad de material insuficiente, máximo '.$material->cantidad]],422);
        }
        DB::beginTransaction();

        $consumodiariolamina = new ConsumoDiarioLamina;

        //validacion del retal
        $entrada_lamina_almacen_retal = EntradaLaminaAlmacen::join('kardex_retal_lamina','entrada_lamina_almacen.id','=','kardex_retal_lamina.entrada_lamina_almacen_id')
            ->where('kardex_retal_lamina.id',$request->retal)
            ->where('entrada_lamina_almacen.id',$request->entrada_lamina_almacen)
            ->first();
        if(!$entrada_lamina_almacen_retal)
            return response(['errors'=>['La información enviada es incorrecta']],422);

        $consumodiariolamina->maquina = $request->maquina;
        $consumodiariolamina->fecha = $request->fecha;
        $consumodiariolamina->ensamble = $request->ensamble;
        $consumodiariolamina->consumo = $request->consumo;
        $consumodiariolamina->desperdicio = $request->desperdicio;
        $consumodiariolamina->consecutivo_retal = $request->consecutivo_retal;
        $consumodiariolamina->observacion = $request->observacion;
        $consumodiariolamina->entrada_lamina_almacen_id = $request->entrada_lamina_almacen;
        $consumodiariolamina->corte_id = $request->corte;
        $consumodiariolamina->operario_id = $request->operario;
        $consumodiariolamina->kardex_retal_lamina_id = $request->retal;

	    $consumodiariolamina->save();
        $material->cantidad -= ($request->consumo + $request->desperdicio);
        $material->save();
        $inventario_lamina->peso_lamina_validado -= ($request->consumo + $request->desperdicio);
        $inventario_lamina->save();
        DB::commit();

	    return ['success'=>true];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$consumodiariolamina = ConsumoDiarioLamina::findOrFail($request->input('id'));

		$consumodiariolamina->delete();
		return "OK";
	    
	}

    public function show($id){
        return redirect('/inventario/consumomateria/lamina');
    }

    function getSelectConsecutivoRetal(Request $request){
            $consecutivos = ConsumoKardexRetalLamina::select('consecutivo_retal','id')
            ->where('entrada_lamina_almacen_id',$request->lamina)
            ->pluck('consecutivo_retal','id');

        return FormFacade::select($request->name,$consecutivos,null,['id'=>$request->name,'class'=>'form-control']);
    }
}