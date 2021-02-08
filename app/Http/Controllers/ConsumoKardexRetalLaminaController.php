<?php

namespace InventariosLedcor\Http\Controllers;

use Illuminate\Http\Request;

use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\Archivo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\ConsumoKardexRetalLamina;
use InventariosLedcor\Http\Requests\ConsumoRetalLaminaRequest;

use DB;

class ConsumoKardexRetalLaminaController extends Controller
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
	    return view('consumokardexretallamina.index', []);
	}

	public function create(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return redirect('/');
	    return view('consumokardexretallamina.add', [[]]);
	}

	public function edit(Request $request, $id)
	{
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return redirect('/');

        $consumokardexretallamina = ConsumoKardexRetalLamina::findOrFail($id);
	    return view('consumokardexretallamina.add', [
	        'model' => $consumokardexretallamina	    ]);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = ConsumoKardexRetalLamina::select(
            'kardex_retal_lamina.id','kardex_retal_lamina.fecha','kardex_retal_lamina.cantidad','kardex_retal_lamina.largo','kardex_retal_lamina.ancho','kardex_retal_lamina.peso','kardex_retal_lamina.fecha_ingreso',
            'entrada_lamina_almacen.consecutivo_lamina',
            DB::raw('CONCAT(quien_genero.nombres," ",quien_genero.apellidos) as quien_genero'),
            DB::raw('CONCAT(quien_gasto.nombres," ",quien_gasto.apellidos) as quien_gasto'),
            'materiales.espesor_mm as espesor','materiales.familia as tipo_lamina'
        )
            ->join('entrada_lamina_almacen','kardex_retal_lamina.entrada_lamina_almacen_id','=','entrada_lamina_almacen.id')
            ->join('users as quien_genero','kardex_retal_lamina.quien_genera','=','quien_genero.id')
            ->join('users as quien_gasto','kardex_retal_lamina.quien_gasta','=','quien_gasto.id')
            ->join('materiales','entrada_lamina_almacen.material_id','=','materiales.id')
            ->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('forma_retal', function ($r) {
            $obj = ConsumoKardexRetalLamina::find($r->id);
            if($obj->formaRetal)
                return '<div class="text-center"><a target="_blank" href="'.url('/archivo/'.str_replace('/','-',$obj->formaRetal->ubicacion).'-'.$obj->formaRetal->nombre).'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Forma retal"><i class="white-text fa fa-file"></i></a></div>';
        })->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="' . url('/inventario/consumomaterial/kardexretallamina/'.$r->id.'/edit').'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/inventario/consumomaterial/kardexretallamina/delete').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            return $opc;

        })->rawColumns(['forma_retal','opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

	public function update(ConsumoRetalLaminaRequest $request) {
        if(!Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        if(!$request->has('id'))return response(['errors'=>['La información enviada es incorrecta']],422);

	    $consumokardexretallamina = ConsumoKardexRetalLamina::find($request->id);

	    if(!$consumokardexretallamina)return response(['errors'=>['La información enviada es incorrecta']],422);

        $consumokardexretallamina->id = $request->id?:0;
        $consumokardexretallamina->fecha = $request->fecha;
        $consumokardexretallamina->fecha_ingreso = $request->fecha_ingreso;
        $consumokardexretallamina->cantidad = $request->cantidad;
        $consumokardexretallamina->largo = $request->largo;
        $consumokardexretallamina->ancho = $request->ancho;
        $consumokardexretallamina->peso = $request->peso;
        $consumokardexretallamina->entrada_lamina_almacen_id = $request->entrada_lamina_almacen;
        $consumokardexretallamina->quien_genera = Auth::user()->id;
        $consumokardexretallamina->quien_gasta = $request->quien_gasta;
	    $consumokardexretallamina->save();

        if($request->hasFile('forma_retal')){

            //si la mascota tiene imagen se elimina
            $imagen_obj = $consumokardexretallamina->formaRetal;
            if($imagen_obj){
                $file = storage_path($imagen_obj->ubicacion.'/'.$imagen_obj->nombre);
                @unlink($file);
            }

            $ruta = 'imagenes/consumo_kardex_retal_lamina/forma_retal/'.$consumokardexretallamina->id;
            $imagen = $request->file('forma_retal');
            $nombre = $imagen->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $imagen->move(storage_path($ruta),$nombre);

            if(!$imagen_obj)
                $imagen_obj = new Archivo();

            $imagen_obj->nombre = $nombre;
            $imagen_obj->ubicacion = $ruta;
            $imagen_obj->save();

            $consumokardexretallamina->forma_retal_id = $imagen_obj->id;
            $consumokardexretallamina->save();
        }

        session()->push('msj_success','Elemento actualizado con éxito.');
	    return ['success'=>true,'reload'=>true];

	}

	public function store(ConsumoRetalLaminaRequest $request)
	{
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $consumokardexretallamina = new ConsumoKardexRetalLamina;

        $consumokardexretallamina->id = $request->id?:0;
        $consumokardexretallamina->fecha = $request->fecha;
        $consumokardexretallamina->fecha_ingreso = $request->fecha_ingreso;
        $consumokardexretallamina->cantidad = $request->cantidad;
        $consumokardexretallamina->largo = $request->largo;
        $consumokardexretallamina->ancho = $request->ancho;
        $consumokardexretallamina->peso = $request->peso;
        $consumokardexretallamina->entrada_lamina_almacen_id = $request->entrada_lamina_almacen;
        $consumokardexretallamina->quien_genera = Auth::user()->id;
        $consumokardexretallamina->quien_gasta = $request->quien_gasta;
        $consumokardexretallamina->forma_retal_id = null;
        $consumokardexretallamina->consecutivo_retal = ConsumoKardexRetalLamina::ultimoConsecutivoRetal()+1;

        $consumokardexretallamina->save();

        if($request->hasFile('forma_retal')){
            $ruta = 'imagenes/consumo_kardex_retal_lamina/forma_retal/'.$consumokardexretallamina->id;
            $imagen = $request->file('forma_retal');
            $nombre = $imagen->getClientOriginalName();
            $nombre = str_replace('-','_',$nombre);
            $imagen->move(storage_path($ruta),$nombre);

            $imagen_obj = new Archivo();
            $imagen_obj->nombre = $nombre;
            $imagen_obj->ubicacion = $ruta;
            $imagen_obj->save();


            $consumokardexretallamina->forma_retal_id = $imagen_obj->id;
            $consumokardexretallamina->save();
        }


	    return ['success'=>true];
	}

	public function delete(Request $request) {
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

		$consumokardexretallamina = ConsumoKardexRetalLamina::findOrFail($request->input('id'));

        $imagen_obj = $consumokardexretallamina->formaRetal;
        $consumokardexretallamina->delete();
        if($imagen_obj){
            $file = storage_path($imagen_obj->ubicacion.'/'.$imagen_obj->nombre);
            @unlink($file);
            $imagen_obj->delete();
        }

		return "OK";
	    
	}

    public function show($id){
        return redirect('/inventario/consumomaterial/kardexretallamina');
    }
}