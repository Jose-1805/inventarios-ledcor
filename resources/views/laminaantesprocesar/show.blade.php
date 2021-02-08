@extends('layouts.app')

@section('content')


<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">Laminaantesprocesar</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-'.model_uc])
        </div>

        <form action="{{ url('/laminaantesprocesar') }}" method="POST" class="form-horizontal">

                
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
            <label for="cantidad" class="control-label">Cantidad</label>
            <div class="">
                <input type="text" name="cantidad" id="cantidad" class="form-control" value="{{$model['cantidad'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="espesor_mm" class="control-label">Espesor Mm</label>
            <div class="">
                <input type="text" name="espesor_mm" id="espesor_mm" class="form-control" value="{{$model['espesor_mm'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_por_lamina" class="control-label">Peso Por Lamina</label>
            <div class="">
                <input type="text" name="peso_por_lamina" id="peso_por_lamina" class="form-control" value="{{$model['peso_por_lamina'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="lote" class="control-label">Lote</label>
            <div class="">
                <input type="text" name="lote" id="lote" class="form-control" value="{{$model['lote'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_guacal" class="control-label">Peso Guacal</label>
            <div class="">
                <input type="text" name="peso_guacal" id="peso_guacal" class="form-control" value="{{$model['peso_guacal'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="observacion" class="control-label">Observacion</label>
            <div class="">
                <input type="text" name="observacion" id="observacion" class="form-control" value="{{$model['observacion'] or ''}}" readonly="readonly">
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