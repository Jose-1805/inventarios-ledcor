<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\InventarioLaminaRollo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\ConsumoLaminaRollo;
use InventariosLedcor\Http\Requests\ConsumoLaminaRolloRequest;

use DB;

class ConsumoLaminaRolloController extends Controller
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
	    return view('consumolaminarollo.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('consumolaminarollo.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $consumolaminarollo = ConsumoLaminaRollo::findOrFail($id);
	    return view('consumolaminarollo.add', [
	        'model' => $consumolaminarollo	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = ConsumoLaminaRollo::select(
            'corte_lamina_placas.id','corte_lamina_placas.peso_validado','corte_lamina_placas.maquina','corte_lamina_placas.fecha','corte_lamina_placas.cantidad','corte_lamina_placas.medida','corte_lamina_placas.maquina_destino','corte_lamina_placas.observacion',
            'inventario_lamina_rollo.consecutivo_rollo','inventario_lamina_rollo.ancho_rollo','inventario_lamina_rollo.no_identificacion_rollo',
            DB::raw('CONCAT(quien_corta.nombres," ",quien_corta.apellidos) as quien_corta'),
            DB::raw('CONCAT(quien_recibe.nombres," ",quien_recibe.apellidos) as quien_recibe'),
            'cortes.no_fabricacion_inicial as no_fabricacion',
            'materiales.texto_breve as material','materiales.espesor_mm as espesor',
            'ordenes_compras.numero as orden_compra','proyectos.nombre as proyecto',
            'calculos.numero as calculo','calculos.fert'
        )
            ->join('users as quien_corta','corte_lamina_placas.quien_corta','=','quien_corta.id')
            ->join('users as quien_recibe','corte_lamina_placas.quien_recibe','=','quien_recibe.id')
            ->join('cortes','corte_lamina_placas.corte_id','=','cortes.id')
            ->join('calculos','cortes.calculo_id','=','calculos.id')
            ->join('inventario_lamina_rollo','corte_lamina_placas.inventario_lamina_rollo_id','=','inventario_lamina_rollo.id')
            ->join('materiales','inventario_lamina_rollo.material_id','=','materiales.id')
            ->join('ordenes_compras','inventario_lamina_rollo.orden_compra_id','=','ordenes_compras.id')
            ->join('proyectos','ordenes_compras.proyecto_id','=','proyectos.id')
            ->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/inventario/consumomaterial/laminarollo/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/inventario/consumomaterial/laminarollo/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(ConsumoLaminaRolloRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);

        DB::beginTransaction();

        $consumolaminarollo = ConsumoLaminaRollo::find($request->id);
        if(!$consumolaminarollo)return response(['errors'=>['La información enviada es incorrecta']],422);

        $inventario_lamina_rollo_previo = $consumolaminarollo->inventarioLaminaRollo;
        $material_previo = $inventario_lamina_rollo_previo->material;

        //se reestablecen los valores descontados en la creación
        $material_previo->cantidad += $consumolaminarollo->cantidad;
        $material_previo->save();
        $inventario_lamina_rollo_previo->peso_validado += $consumolaminarollo->cantidad;
        $inventario_lamina_rollo_previo->save();



        $inventario_lamina_rollo = InventarioLaminaRollo::find($request->inventario_lamina_rollo);
        $material = $inventario_lamina_rollo->material;
        if($inventario_lamina_rollo->peso_validado < $request->cantidad){
            return response(['errors'=>['La cantidad máxima para el campo cantidad es '.$inventario_lamina_rollo->peso_validado]],422);
        }
        if($material->cantidad < $request->cantidad){
            return response(['errors'=>['Cantidad de material insuficiente, máximo '.$material->cantidad]],422);
        }

        $consumolaminarollo->maquina = $request->maquina;
        $consumolaminarollo->fecha = $request->fecha;
        $consumolaminarollo->ensamble = $request->ensamble;
        $consumolaminarollo->cantidad = $request->cantidad;
        $consumolaminarollo->medida = $request->medida;
        $consumolaminarollo->maquina_destino = $request->maquina_destino;
        $consumolaminarollo->observacion = $request->observacion;
        $consumolaminarollo->inventario_lamina_rollo_id = $request->inventario_lamina_rollo;
        $consumolaminarollo->corte_id = $request->corte;
        $consumolaminarollo->quien_corta = $request->quien_corta;
        $consumolaminarollo->quien_recibe = $request->quien_recibe;
        //$consumolaminarollo->user_id = $request->user()->id;
	    $consumolaminarollo->save();
        $material->cantidad -= $request->cantidad;
        $material->save();
        $inventario_lamina_rollo->peso_validado -= $request->cantidad;
        $inventario_lamina_rollo->save();
        DB::commit();
        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];

	}

	public function store(ConsumoLaminaRolloRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);
        //
        /*$this->validate($request, [
            'name' => 'required|max:255',
        ]);*/

        $inventario_lamina_rollo = InventarioLaminaRollo::find($request->inventario_lamina_rollo);
        $material = $inventario_lamina_rollo->material;
        if($inventario_lamina_rollo->peso_validado < $request->cantidad){
            return response(['errors'=>['La cantidad máxima para el campo cantidad es '.$inventario_lamina_rollo->peso_validado]],422);
        }
        if($material->cantidad < $request->cantidad){
            return response(['errors'=>['Cantidad de material insuficiente, máximo '.$material->cantidad]],422);
        }
        DB::beginTransaction();

        $consumolaminarollo = new ConsumoLaminaRollo;

        $consumolaminarollo->maquina = $request->maquina;
        $consumolaminarollo->fecha = $request->fecha;
        $consumolaminarollo->ensamble = $request->ensamble;
        $consumolaminarollo->cantidad = $request->cantidad;
        $consumolaminarollo->medida = $request->medida;
        $consumolaminarollo->maquina_destino = $request->maquina_destino;
        $consumolaminarollo->observacion = $request->observacion;
        $consumolaminarollo->inventario_lamina_rollo_id = $request->inventario_lamina_rollo;
        $consumolaminarollo->corte_id = $request->corte;
        $consumolaminarollo->quien_corta = $request->quien_corta;
        $consumolaminarollo->quien_recibe = $request->quien_recibe;
        //$consumolaminarollo->user_id = $request->user()->id;
	    $consumolaminarollo->save();
	    $material->cantidad -= $request->cantidad;
	    $material->save();
	    $inventario_lamina_rollo->peso_validado -= $request->cantidad;
	    $inventario_lamina_rollo->save();
	    DB::commit();

	    return ['success'=>true];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$consumolaminarollo = ConsumoLaminaRollo::findOrFail($request->input('id'));

		$consumolaminarollo->delete();
		return "OK";
	    
	}

    public function show($id){
        return redirect('/inventario/consumomaterial/laminarollo');
    }
}