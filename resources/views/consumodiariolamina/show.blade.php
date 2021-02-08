@extends('layouts.app')

@section('content')


<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">Consumodiariolamina</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-'.model_uc])
        </div>

        <form action="{{ url('/consumodiariolamina') }}" method="POST" class="form-horizontal">

                
        <div class="form-group col-md-3 col-lg-4">
            <label for="id" class="control-label">Id</label>
            <div class="">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
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
            <label for="ensamble" class="control-label">Ensamble</label>
            <div class="">
                <input type="text" name="ensamble" id="ensamble" class="form-control" value="{{$model['ensamble'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="consumo" class="control-label">Consumo</label>
            <div class="">
                <input type="text" name="consumo" id="consumo" class="form-control" value="{{$model['consumo'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="desperdicio" class="control-label">Desperdicio</label>
            <div class="">
                <input type="text" name="desperdicio" id="desperdicio" class="form-control" value="{{$model['desperdicio'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="observacion" class="control-label">Observacion</label>
            <div class="">
                <input type="text" name="observacion" id="observacion" class="form-control" value="{{$model['observacion'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="entrada_lamina_almacen_id" class="control-label">Entrada Lamina Almacen Id</label>
            <div class="">
                <input type="text" name="entrada_lamina_almacen_id" id="entrada_lamina_almacen_id" class="form-control" value="{{$model['entrada_lamina_almacen_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="corte_id" class="control-label">Corte Id</label>
            <div class="">
                <input type="text" name="corte_id" id="corte_id" class="form-control" value="{{$model['corte_id'] or ''}}" readonly="readonly">
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