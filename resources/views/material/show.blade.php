@extends('layouts.app')

@section('content')


<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">Material</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-'.model_uc])
        </div>

        <form action="{{ url('/material') }}" method="POST" class="form-horizontal">

                
        <div class="form-group col-md-3 col-lg-4">
            <label for="id" class="control-label">Id</label>
            <div class="">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="familia" class="control-label">Familia</label>
            <div class="">
                <input type="text" name="familia" id="familia" class="form-control" value="{{$model['familia'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="unidad_medida" class="control-label">Unidad Medida</label>
            <div class="">
                <input type="text" name="unidad_medida" id="unidad_medida" class="form-control" value="{{$model['unidad_medida'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="presentacion" class="control-label">Presentacion</label>
            <div class="">
                <input type="text" name="presentacion" id="presentacion" class="form-control" value="{{$model['presentacion'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="especificacion" class="control-label">Especificacion</label>
            <div class="">
                <input type="text" name="especificacion" id="especificacion" class="form-control" value="{{$model['especificacion'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="codigo" class="control-label">Codigo</label>
            <div class="">
                <input type="text" name="codigo" id="codigo" class="form-control" value="{{$model['codigo'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="texto_breve" class="control-label">Texto Breve</label>
            <div class="">
                <input type="text" name="texto_breve" id="texto_breve" class="form-control" value="{{$model['texto_breve'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="codigo_plano" class="control-label">Codigo Plano</label>
            <div class="">
                <input type="text" name="codigo_plano" id="codigo_plano" class="form-control" value="{{$model['codigo_plano'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="valor_unidad" class="control-label">Valor Unidad</label>
            <div class="">
                <input type="text" name="valor_unidad" id="valor_unidad" class="form-control" value="{{$model['valor_unidad'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="espesor_mm" class="control-label">Espesor Mm</label>
            <div class="">
                <input type="text" name="espesor_mm" id="espesor_mm" class="form-control" value="{{$model['espesor_mm'] or ''}}" readonly="readonly">
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