<?php

namespace InventariosLedcor\Http\Controllers;

use Collective\Html\FormFacade;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use InventariosLedcor\Http\Requests;
use InventariosLedcor\Http\Controllers\Controller;
use InventariosLedcor\Models\Correo;
use InventariosLedcor\Models\LogCantidad;
use InventariosLedcor\Models\Material;
use InventariosLedcor\Models\Solicitud;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

use InventariosLedcor\Models\SolicitudMaterial;
use InventariosLedcor\Http\Requests\SolicitudMaterialRequest;

use DB;

class SolicitudMaterialController extends Controller
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
	    return view('solicitudmaterial.index', []);
	}

	public function lista(Request $request)
	{
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = Solicitud::select('solicitudes.*');
            /*->leftJoin('solicitudes_materiales','solicitudes.id','=','solicitudes_materiales.solicitud_id')
            ->leftJoin('materiales','material_id','=','materiales.id');*/

        /*if($request->has('cantidad') && $request->input('cantidad')){
            if($request->input('cantidad') == 'cero') {
                $results->where(function ($q) {
                    $q->whereNull('solicitudes_materiales.cantidad_entregada')
                        ->orWhere('solicitudes_materiales.cantidad_entregada', '0');
                });
            }
        }*/

        if($request->has('fecha_inicial') && $request->input('fecha_inicial')){
            $results->where('solicitudes.fecha','>=',$request->input('fecha_inicial'));
        }

        if($request->has('fecha_final') && $request->input('fecha_final')){
            $results->where('solicitudes.fecha','<=',$request->input('fecha_final'));
        }

        $results = $results->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="'.url('inventario/solicitudmaterial/detalle/'.$r->id).'" class="btn btn-xs btn-primary margin-2" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
	}

    public function storeSolicitud(Request $request)
    {
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $numero = 1;
        $ultima_solicitud = Solicitud::ultimaSolicitud();
        if($ultima_solicitud)$numero = $ultima_solicitud->numero+1;

        $solicitud = new Solicitud();
        $solicitud->numero = $numero;
        $solicitud->fecha = date('Y-m-d');
        $solicitud->save();

        return ['success'=>true,'solicitud'=>$solicitud->id];
    }

	public function mail($id)
    {
        $solicitud = Solicitud::find($id);
        if($solicitud){
            $materiales = $solicitud->solicitudMateriales()->select('materiales.*','solicitudes_materiales.um','solicitudes_materiales.cantidad as cantidad_solicitud','solicitudes_materiales.cantidad_entregada','solicitudes_materiales.lote as lote_solicitud','solicitudes_materiales.observaciones as observaciones_solicitud')
                ->join('materiales','solicitudes_materiales.material_id','materiales.id')
                ->orderBy('materiales.familia')->get();
            return view('solicitudmaterial.mail')->with('solicitud',$solicitud)->with('materiales',$materiales);
        }
        return redirect()->back();
    }

    public function sendMail(Request $request){
        $rules = [
            'para'=>'required|email',
            'cc'=>'required|email',
            'asunto'=>'required|max:150'
        ];

        Validator::make($request->all(), $rules)->validate();

        $solicitud = Solicitud::find($request->solicitud);

        if(!$solicitud) return response(['errors'=>['La información enviada es incorrecta']],422);

        $materiales = $solicitud->solicitudMateriales()->select('materiales.*','solicitudes_materiales.um','solicitudes_materiales.cantidad as cantidad_solicitud','solicitudes_materiales.cantidad_entregada','solicitudes_materiales.lote as lote_solicitud','solicitudes_materiales.observaciones as observaciones_solicitud')
            ->join('materiales','solicitudes_materiales.material_id','materiales.id')
            ->orderBy('materiales.familia')->get();

        Correo::solicitudMaterial($solicitud,$materiales,$request->para,$request->cc,$request->asunto);
    }

	public function detalle($id)
    {
        $solicitud = Solicitud::find($id);
        if($solicitud){
            return view('solicitudmaterial.detalle')->with('solicitud',$solicitud);
        }
        return redirect()->back();
    }

    public function listaDetalle(Request $request)
    {
        if(!Auth::user()->tieneFuncion(3,4,$this->privilegio_superadministrador))
            return redirect('/');
        $results = SolicitudMaterial::select('solicitudes_materiales.*','materiales.texto_breve as material')
            ->join('materiales','material_id','=','materiales.id')
            ->where('solicitudes_materiales.solicitud_id',$request->input('solicitud'))
            ->get();

        $table = Datatables::of($results);//->removeColumn('id');

        $table = $table->editColumn('opciones', function ($r) {
            $opc = '';
            if(Auth::user()->tieneFuncion(3,2,$this->privilegio_superadministrador)) {
                $opc .= '<a href="#!" class="btn btn-xs btn-primary margin-2 btn-editar-detalle" data-detalle="'.$r->id.'" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="white-text fa fa-pencil-square-o"></i></a>';
            }

            if(Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador) && $r->id != Auth::user()->id) {
                $opc .= '<a href="#!" data-elemento-lista="'.$r->id.'" data-url="' . url('/inventario/solicitudmaterial/delete-detalle').'" class="btn btn-xs btn-danger margin-2 btn-eliminar-elemento-lista" data-toggle="modal" data-target="#modal-eliminar-elemento-lista"><i class="white-text fa fa-trash"></i></a>';
            }

            $opc .= '<a href="#!" class="btn btn-xs btn-primary margin-2 btn-cantidad-detalle" data-detalle="'.$r->id.'" data-toggle="tooltip" data-placement="bottom" title="Cantidad entregada"><i class="white-text fa fa-check"></i></a>';

            return $opc;

        })->rawColumns(['opciones']);

        if(!Auth::user()->tieneFunciones(3,[2,3],false,$this->privilegio_superadministrador))$table->removeColumn('opciones');

        $table = $table->make(true);
        return $table;
    }

    public function formDetalle(Request $request)
    {
        if($request->has('solicitud')) {
            $solicitud = Solicitud::find($request->input('solicitud'));
            $detalle = new SolicitudMaterial();
            if ($request->has('detalle')) {
                $detalle = SolicitudMaterial::find($request->input('detalle'));
            }
            return view('solicitudmaterial.form_material', ['detalle' => $detalle,'solicitud'=>$solicitud])->render();
        }
    }

    public function saveDetalle(SolicitudMaterialRequest $request)
    {
        if(!Auth::user()->tieneFuncion(3,1,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $solicitudmaterial = new SolicitudMaterial;
        if($request->has('id') && $request->input('id')) {
            $solicitudmaterial = SolicitudMaterial::find($request->input('id'));
            if(!$solicitudmaterial)
                return response(['errors'=>['La información enviada es incorrecta']],422);
        }

        if(!$solicitudmaterial->exists){
            $solicitud = Solicitud::find($request->input('solicitud'));
            if(!$solicitud){
                return response(['errors'=>['La información enviada es incorrecta']],422);
            }
        }

        $solicitudmaterial->um = $request->um;
        $solicitudmaterial->cantidad = $request->cantidad;
        $solicitudmaterial->lote = $request->lote;
        $solicitudmaterial->observaciones = $request->observaciones;
        $solicitudmaterial->material_id = $request->material;

        if(!$solicitudmaterial->exists){
            $solicitudmaterial->solicitud_id = $solicitud->id;
        }

        $solicitudmaterial->save();

        return ['success'=>true];
    }

    function deleteDetalle(Request $request){
        if(!Auth::user()->tieneFuncion(3,3,$this->privilegio_superadministrador))
            return response(['error'=>['Unauthorized.']],401);

        $solicitudmaterial = SolicitudMaterial::findOrFail($request->input('id'));

        $material = Material::find($solicitudmaterial->material_id);
        $material->cantidad -= $solicitudmaterial->cantidad_entregada;
        $material->save();
        $solicitudmaterial->delete();
        return "OK";
    }

    function getSelect(Request $request){
        $solicitudes = Solicitud::select('solicitudes.*')
            ->join('solicitudes_materiales','solicitudes.id','=','solicitudes_materiales.solicitud_id')
            ->join('materiales','solicitudes_materiales.material_id','=','materiales.id')
            ->where('materiales.id',$request->material)
            ->pluck('numero','id');

        return FormFacade::select($request->name,$solicitudes,null,['id'=>$request->name,'class'=>'form-control']);
    }

    function setCantidadEntregada(Request $request){
        if($request->has('detalle')) {
            if(!$request->has('cantidad') || !$request->cantidad){
                return response(['errors'=>['El campo cantidad entregada es obligatorio']],422);
            }

            if(!is_numeric($request->cantidad))
                return response(['errors'=>['El campo cantidad entregada debe ser de tipo numérico']],422);

            if($request->cantidad < 0)
                return response(['errors'=>['El campo cantidad entregada debe ser un número positivo']],422);

            $detalle = SolicitudMaterial::find($request->detalle);
            if(!$detalle){
                return response(['errors'=>['La información enviada es incorrecta']],422);
            }

            if($request->cantidad > $detalle->cantidad)
                return response(['errors'=>['La cantidad entregada no puede ser mayor a la cantidad registrada']],422);

            $log = new LogCantidad();
            $log->cantidad_anterior = $detalle->cantidad_entregada;
            $log->cantidad_nueva = $request->cantidad;
            $log->solicitud_material_id = $detalle->id;
            $log->user_id = Auth::user()->id;

            $material = Material::find($detalle->material_id);
            $material->cantidad -= $detalle->cantidad_entregada;
            $material->cantidad += $request->cantidad;
            $detalle->cantidad_entregada = $request->cantidad;
            $material->save();
            $detalle->save();
            $log->save();
            return ['success'=>true];


        }
    }

    /*function cantidadMaterialDisponible(Request $request){
        $solicitud = Solicitud::find($request->solicitud);
        if($solicitud){
            return $solicitud->cantidadMaterialDisponible($request->material);
        }
        return 0;
    }*/
}