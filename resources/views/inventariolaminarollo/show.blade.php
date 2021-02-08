@extends('layouts.app')

@section('content')


<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">Inventariolaminarollo</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-'.model_uc])
        </div>

        <form action="{{ url('/inventariolaminarollo') }}" method="POST" class="form-horizontal">

                
        <div class="form-group col-md-3 col-lg-4">
            <label for="id" class="control-label">Id</label>
            <div class="">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="fecha_recibido" class="control-label">Fecha Recibido</label>
            <div class="">
                <input type="text" name="fecha_recibido" id="fecha_recibido" class="form-control" value="{{$model['fecha_recibido'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_sin_validar" class="control-label">Peso Sin Validar</label>
            <div class="">
                <input type="text" name="peso_sin_validar" id="peso_sin_validar" class="form-control" value="{{$model['peso_sin_validar'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_validado" class="control-label">Peso Validado</label>
            <div class="">
                <input type="text" name="peso_validado" id="peso_validado" class="form-control" value="{{$model['peso_validado'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="lote" class="control-label">Lote</label>
            <div class="">
                <input type="text" name="lote" id="lote" class="form-control" value="{{$model['lote'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="no_identificacion_rollo" class="control-label">No Identificacion Rollo</label>
            <div class="">
                <input type="text" name="no_identificacion_rollo" id="no_identificacion_rollo" class="form-control" value="{{$model['no_identificacion_rollo'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="fecha_rollo" class="control-label">Fecha Rollo</label>
            <div class="">
                <input type="text" name="fecha_rollo" id="fecha_rollo" class="form-control" value="{{$model['fecha_rollo'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="norma" class="control-label">Norma</label>
            <div class="">
                <input type="text" name="norma" id="norma" class="form-control" value="{{$model['norma'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="ancho_rollo" class="control-label">Ancho Rollo</label>
            <div class="">
                <input type="text" name="ancho_rollo" id="ancho_rollo" class="form-control" value="{{$model['ancho_rollo'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="consecutivo_rollo" class="control-label">Consecutivo Rollo</label>
            <div class="">
                <input type="text" name="consecutivo_rollo" id="consecutivo_rollo" class="form-control" value="{{$model['consecutivo_rollo'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="observacion" class="control-label">Observacion</label>
            <div class="">
                <input type="text" name="observacion" id="observacion" class="form-control" value="{{$model['observacion'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="proveedor_id" class="control-label">Proveedor Id</label>
            <div class="">
                <input type="text" name="proveedor_id" id="proveedor_id" class="form-control" value="{{$model['proveedor_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="material_id" class="control-label">Material Id</label>
            <div class="">
                <input type="text" name="material_id" id="material_id" class="form-control" value="{{$model['material_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="orden_compra_id" class="control-label">Orden Compra Id</label>
            <div class="">
                <input type="text" name="orden_compra_id" id="orden_compra_id" class="form-control" value="{{$model['orden_compra_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="operario_id" class="control-label">Operario Id</label>
            <div class="">
                <input type="text" name="operario_id" id="operario_id" class="form-control" value="{{$model['operario_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
        
        </form>

    </div>

</div>
</div>
@endsection