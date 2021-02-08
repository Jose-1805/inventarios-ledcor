@extends('layouts.app')

@section('content')


<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">Consumokardexretallamina</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-'.model_uc])
        </div>

        <form action="{{ url('/consumokardexretallamina') }}" method="POST" class="form-horizontal">

                
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
            <label for="cantidad" class="control-label">Cantidad</label>
            <div class="">
                <input type="text" name="cantidad" id="cantidad" class="form-control" value="{{$model['cantidad'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="largo" class="control-label">Largo</label>
            <div class="">
                <input type="text" name="largo" id="largo" class="form-control" value="{{$model['largo'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="ancho" class="control-label">Ancho</label>
            <div class="">
                <input type="text" name="ancho" id="ancho" class="form-control" value="{{$model['ancho'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso" class="control-label">Peso</label>
            <div class="">
                <input type="text" name="peso" id="peso" class="form-control" value="{{$model['peso'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="entrada_lamina_almacen_id" class="control-label">Entrada Lamina Almacen Id</label>
            <div class="">
                <input type="text" name="entrada_lamina_almacen_id" id="entrada_lamina_almacen_id" class="form-control" value="{{$model['entrada_lamina_almacen_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="quien_genera" class="control-label">Quien Genera</label>
            <div class="">
                <input type="text" name="quien_genera" id="quien_genera" class="form-control" value="{{$model['quien_genera'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="quien_gasta" class="control-label">Quien Gasta</label>
            <div class="">
                <input type="text" name="quien_gasta" id="quien_gasta" class="form-control" value="{{$model['quien_gasta'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="forma_retal_id" class="control-label">Forma Retal Id</label>
            <div class="">
                <input type="text" name="forma_retal_id" id="forma_retal_id" class="form-control" value="{{$model['forma_retal_id'] or ''}}" readonly="readonly">
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