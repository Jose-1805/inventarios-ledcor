@extends('layouts.app')

@section('content')


<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">Consumolaminarollo</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-'.model_uc])
        </div>

        <form action="{{ url('/consumolaminarollo') }}" method="POST" class="form-horizontal">

                
        <div class="form-group col-md-3 col-lg-4">
            <label for="id" class="control-label">Id</label>
            <div class="">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_validado" class="control-label">Peso Validado</label>
            <div class="">
                <input type="text" name="peso_validado" id="peso_validado" class="form-control" value="{{$model['peso_validado'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="maquina" class="control-label">Maquina</label>
            <div class="">
                <input type="text" name="maquina" id="maquina" class="form-control" value="{{$model['maquina'] or ''}}" readonly="readonly">
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
            <label for="medida" class="control-label">Medida</label>
            <div class="">
                <input type="text" name="medida" id="medida" class="form-control" value="{{$model['medida'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="maquina_destino" class="control-label">Maquina Destino</label>
            <div class="">
                <input type="text" name="maquina_destino" id="maquina_destino" class="form-control" value="{{$model['maquina_destino'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="observacion" class="control-label">Observacion</label>
            <div class="">
                <input type="text" name="observacion" id="observacion" class="form-control" value="{{$model['observacion'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="inventario_lamina_rollo_id" class="control-label">Inventario Lamina Rollo Id</label>
            <div class="">
                <input type="text" name="inventario_lamina_rollo_id" id="inventario_lamina_rollo_id" class="form-control" value="{{$model['inventario_lamina_rollo_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="corte_id" class="control-label">Corte Id</label>
            <div class="">
                <input type="text" name="corte_id" id="corte_id" class="form-control" value="{{$model['corte_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="quien_corta" class="control-label">Quien Corta</label>
            <div class="">
                <input type="text" name="quien_corta" id="quien_corta" class="form-control" value="{{$model['quien_corta'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="quien_recibe" class="control-label">Quien Recibe</label>
            <div class="">
                <input type="text" name="quien_recibe" id="quien_recibe" class="form-control" value="{{$model['quien_recibe'] or ''}}" readonly="readonly">
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