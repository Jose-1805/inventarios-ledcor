@extends('layouts.app')

@section('content')


<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">Programacion</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-'.model_uc])
        </div>

        <form action="{{ url('/programacion') }}" method="POST" class="form-horizontal">

                
        <div class="form-group col-md-3 col-lg-4">
            <label for="id" class="control-label">Id</label>
            <div class="">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="linea" class="control-label">Linea</label>
            <div class="">
                <input type="text" name="linea" id="linea" class="form-control" value="{{$model['linea'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="tipo_item" class="control-label">Tipo Item</label>
            <div class="">
                <input type="text" name="tipo_item" id="tipo_item" class="form-control" value="{{$model['tipo_item'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="subensamble" class="control-label">Subensamble</label>
            <div class="">
                <input type="text" name="subensamble" id="subensamble" class="form-control" value="{{$model['subensamble'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="tipo_tk" class="control-label">Tipo Tk</label>
            <div class="">
                <input type="text" name="tipo_tk" id="tipo_tk" class="form-control" value="{{$model['tipo_tk'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="no_preliminar_inicial" class="control-label">No Preliminar Inicial</label>
            <div class="">
                <input type="text" name="no_preliminar_inicial" id="no_preliminar_inicial" class="form-control" value="{{$model['no_preliminar_inicial'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="no_preliminar_final" class="control-label">No Preliminar Final</label>
            <div class="">
                <input type="text" name="no_preliminar_final" id="no_preliminar_final" class="form-control" value="{{$model['no_preliminar_final'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="orden_fabricacion_trafo" class="control-label">Orden Fabricacion Trafo</label>
            <div class="">
                <input type="text" name="orden_fabricacion_trafo" id="orden_fabricacion_trafo" class="form-control" value="{{$model['orden_fabricacion_trafo'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="cantidad_tk" class="control-label">Cantidad Tk</label>
            <div class="">
                <input type="text" name="cantidad_tk" id="cantidad_tk" class="form-control" value="{{$model['cantidad_tk'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="KVA" class="control-label">KVA</label>
            <div class="">
                <input type="text" name="KVA" id="KVA" class="form-control" value="{{$model['KVA'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="baterias_tk" class="control-label">Baterias Tk</label>
            <div class="">
                <input type="text" name="baterias_tk" id="baterias_tk" class="form-control" value="{{$model['baterias_tk'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="no_elem" class="control-label">No Elem</label>
            <div class="">
                <input type="text" name="no_elem" id="no_elem" class="form-control" value="{{$model['no_elem'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="ancho_rad" class="control-label">Ancho Rad</label>
            <div class="">
                <input type="text" name="ancho_rad" id="ancho_rad" class="form-control" value="{{$model['ancho_rad'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="longitud_rad" class="control-label">Longitud Rad</label>
            <div class="">
                <input type="text" name="longitud_rad" id="longitud_rad" class="form-control" value="{{$model['longitud_rad'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="fecha_plan_formado_radiador" class="control-label">Fecha Plan Formado Radiador</label>
            <div class="">
                <input type="text" name="fecha_plan_formado_radiador" id="fecha_plan_formado_radiador" class="form-control" value="{{$model['fecha_plan_formado_radiador'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="fecha_entrega_formado" class="control-label">Fecha Entrega Formado</label>
            <div class="">
                <input type="text" name="fecha_entrega_formado" id="fecha_entrega_formado" class="form-control" value="{{$model['fecha_entrega_formado'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="fecha_liberacion_planos" class="control-label">Fecha Liberacion Planos</label>
            <div class="">
                <input type="text" name="fecha_liberacion_planos" id="fecha_liberacion_planos" class="form-control" value="{{$model['fecha_liberacion_planos'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="fecha_entrega_material" class="control-label">Fecha Entrega Material</label>
            <div class="">
                <input type="text" name="fecha_entrega_material" id="fecha_entrega_material" class="form-control" value="{{$model['fecha_entrega_material'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="fecha_plan" class="control-label">Fecha Plan</label>
            <div class="">
                <input type="text" name="fecha_plan" id="fecha_plan" class="form-control" value="{{$model['fecha_plan'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="confirmacion_inicial" class="control-label">Confirmacion Inicial</label>
            <div class="">
                <input type="text" name="confirmacion_inicial" id="confirmacion_inicial" class="form-control" value="{{$model['confirmacion_inicial'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="fecha_entrega" class="control-label">Fecha Entrega</label>
            <div class="">
                <input type="text" name="fecha_entrega" id="fecha_entrega" class="form-control" value="{{$model['fecha_entrega'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_teorico_prensas" class="control-label">Peso Teorico Prensas</label>
            <div class="">
                <input type="text" name="peso_teorico_prensas" id="peso_teorico_prensas" class="form-control" value="{{$model['peso_teorico_prensas'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_teorico_tk" class="control-label">Peso Teorico Tk</label>
            <div class="">
                <input type="text" name="peso_teorico_tk" id="peso_teorico_tk" class="form-control" value="{{$model['peso_teorico_tk'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_teorico_cajas" class="control-label">Peso Teorico Cajas</label>
            <div class="">
                <input type="text" name="peso_teorico_cajas" id="peso_teorico_cajas" class="form-control" value="{{$model['peso_teorico_cajas'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_teorico_radiadores" class="control-label">Peso Teorico Radiadores</label>
            <div class="">
                <input type="text" name="peso_teorico_radiadores" id="peso_teorico_radiadores" class="form-control" value="{{$model['peso_teorico_radiadores'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="corte_id" class="control-label">Corte Id</label>
            <div class="">
                <input type="text" name="corte_id" id="corte_id" class="form-control" value="{{$model['corte_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="proyecto_id" class="control-label">Proyecto Id</label>
            <div class="">
                <input type="text" name="proyecto_id" id="proyecto_id" class="form-control" value="{{$model['proyecto_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="estado_id" class="control-label">Estado Id</label>
            <div class="">
                <input type="text" name="estado_id" id="estado_id" class="form-control" value="{{$model['estado_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="created_at" class="control-label">Created At</label>
            <div class="">
                <input type="text" name="created_at" id="created_at" class="form-control" value="{{$model['created_at'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="updated_at" class="control-label">Updated At</label>
            <div class="">
                <input type="text" name="updated_at" id="updated_at" class="form-control" value="{{$model['updated_at'] or ''}}" readonly="readonly">
            </div>
        </div>
        
        
        </form>

    </div>

</div>
</div>
@endsection