<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\Material;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\ConsumoPerfileria;
use InventariosLedcor\Http\Requests\ConsumoPerfileriaRequest;

use DB;

class ConsumoPerfileriaController extends Controller
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
	    return view('consumoperfileria.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('consumoperfileria.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $consumoperfileria = ConsumoPerfileria::findOrFail($id);
	    return view('consumoperfileria.add', [
	        'model' => $consumoperfileria	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = ConsumoPerfileria::select(
            'consumo_perfileria.id','consumo_perfileria.fecha','consumo_perfileria.ensamble','consumo_perfileria.cantidad','consumo_perfileria.medida','consumo_perfileria.observacion',
            'cortes.no_fabricacion_inicial as no_fabricacion','calculos.numero as calculo',
            DB::raw('CONCAT(quien_entrego.nombres," ",quien_entrego.apellidos) as quien_entrego'),
            DB::raw('CONCAT(quien_solicito.nombres," ",quien_solicito.apellidos) as quien_solicito'),
            'materiales.texto_breve as material','clientes.nombre as cliente'
        )
            ->join('cortes','consumo_perfileria.corte_id','=','cortes.id')
            ->join('calculos','cortes.calculo_id','=','calculos.id')
            ->join('clientes','consumo_perfileria.cliente_id','=','clientes.id')
            ->join('materiales','consumo_perfileria.material_id','=','materiales.id')
            ->join('users as quien_entrego','consumo_perfileria.quien_entrego','=','quien_entrego.id')
            ->join('users as quien_solicito','consumo_perfileria.quien_solicito','=','quien_solicito.id')
            ->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/inventario/consumomaterial/perfileria/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/inventario/consumomaterial/perfileria/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(ConsumoPerfileriaRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);

	    $consumoperfileria = ConsumoPerfileria::find($request->id);

	    if(!$consumoperfileria)return response(['errors'=>['La información enviada es incorrecta']],422);

	    DB::beginTransaction();
	    //se reestablecen los valores de la materia prima selecciona anteriormente
        $material_previo = $consumoperfileria->material;
        $material_previo->cantidad += $consumoperfileria->cantidad * $consumoperfileria->medida;
        $material_previo->save();

        $material = Material::find($request->material);
        if($material->cantidad < $request->cantidad * $request->medida){
            return response(['errors'=>['El producto de la cantidad por la madida no puede superar la cantidad disponible del material ('.$material->cantidad.')']],422);
        }

        $material->cantidad -= $request->cantidad * $request->medida;
        $material->save();

        $consumoperfileria->fecha = $request->fecha;
        $consumoperfileria->cantidad = $request->cantidad;
        $consumoperfileria->medida = $request->medida;
        $consumoperfileria->ensamble = $request->ensamble;
        $consumoperfileria->observacion = $request->observacion;
        $consumoperfileria->quien_entrego = $request->quien_entrego;
        $consumoperfileria->quien_solicito = $request->quien_solicito;
        $consumoperfileria->cliente_id = $request->cliente;
        $consumoperfileria->corte_id = $request->corte;
        $consumoperfileria->material_id = $request->material;
        //$consumoperfileria->user_id = $request->user()->id;
	    $consumoperfileria->save();
	    DB::commit();
        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];

	}

	public function store(ConsumoPerfileriaRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        DB::beginTransaction();
        $material = Material::find($request->material);
        if($material->cantidad < $request->cantidad * $request->medida){
            return response(['errors'=>['El producto de la cantidad por la madida no puede superar la cantidad disponible del material ('.$material->cantidad.')']],422);
        }

        $material->cantidad -= $request->cantidad * $request->medida;
        $material->save();

        $consumoperfileria = new ConsumoPerfileria;

        $consumoperfileria->fecha = $request->fecha;
        $consumoperfileria->cantidad = $request->cantidad;
        $consumoperfileria->medida = $request->medida;
        $consumoperfileria->ensamble = $request->ensamble;
        $consumoperfileria->observacion = $request->observacion;
        $consumoperfileria->quien_entrego = $request->quien_entrego;
        $consumoperfileria->quien_solicito = $request->quien_solicito;
        $consumoperfileria->cliente_id = $request->cliente;
        $consumoperfileria->corte_id = $request->corte;
        $consumoperfileria->material_id = $request->material;
        //$consumoperfileria->user_id = $request->user()->id;
	    $consumoperfileria->save();

        DB::commit();
	    return ['success'=>true];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$consumoperfileria = ConsumoPerfileria::findOrFail($request->input('id'));

		$consumoperfileria->delete();
		return "OK";
	    
	}

    public function show($id){
        return redirect('/inventario/consumomaterial/perfileria');
    }
}