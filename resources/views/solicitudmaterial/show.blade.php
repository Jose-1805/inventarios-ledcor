@extends('layouts.app')

@section('content')


<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">Solicitudmaterial</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-'.model_uc])
        </div>

        <form action="{{ url('/solicitudmaterial') }}" method="POST" class="form-horizontal">

                
        <div class="form-group col-md-3 col-lg-4">
            <label for="id" class="control-label">Id</label>
            <div class="">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="fecha" class="control-label">Fecha</label>
            <div class="">
                <input type="text" name="fecha" id="fecha" class="form-control" value="{{$model['fecha'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="um" class="control-label">Um</label>
            <div class="">
                <input type="text" name="um" id="um" class="form-control" value="{{$model['um'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="cantidad" class="control-label">Cantidad</label>
            <div class="">
                <input type="text" name="cantidad" id="cantidad" class="form-control" value="{{$model['cantidad'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="cantidad_entregada" class="control-label">Cantidad Entregada</label>
            <div class="">
                <input type="text" name="cantidad_entregada" id="cantidad_entregada" class="form-control" value="{{$model['cantidad_entregada'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="lote" class="control-label">Lote</label>
            <div class="">
                <input type="text" name="lote" id="lote" class="form-control" value="{{$model['lote'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="observaciones" class="control-label">Observaciones</label>
            <div class="">
                <input type="text" name="observaciones" id="observaciones" class="form-control" value="{{$model['observaciones'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="material_id" class="control-label">Material Id</label>
            <div class="">
                <input type="text" name="material_id" id="material_id" class="form-control" value="{{$model['material_id'] or ''}}" readonly="readonly">
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