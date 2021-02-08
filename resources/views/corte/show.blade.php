@extends('layouts.app')

@section('content')


<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">Corte</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-'.model_uc])
        </div>

        <form action="{{ url('/corte') }}" method="POST" class="form-horizontal">

                
        <div class="form-group col-md-3 col-lg-4">
            <label for="id" class="control-label">Id</label>
            <div class="">
                <input type="text" name="id" id="id" class="form-control" value="{{$model['id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="no_fabricacion_inicial" class="control-label">No Fabricacion Inicial</label>
            <div class="">
                <input type="text" name="no_fabricacion_inicial" id="no_fabricacion_inicial" class="form-control" value="{{$model['no_fabricacion_inicial'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="no_fabricacion_final" class="control-label">No Fabricacion Final</label>
            <div class="">
                <input type="text" name="no_fabricacion_final" id="no_fabricacion_final" class="form-control" value="{{$model['no_fabricacion_final'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="cantidad_tk" class="control-label">Cantidad Tk</label>
            <div class="">
                <input type="text" name="cantidad_tk" id="cantidad_tk" class="form-control" value="{{$model['cantidad_tk'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="fecha_listado" class="control-label">Fecha Listado</label>
            <div class="">
                <input type="text" name="fecha_listado" id="fecha_listado" class="form-control" value="{{$model['fecha_listado'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_tanque" class="control-label">Peso Tanque</label>
            <div class="">
                <input type="text" name="peso_tanque" id="peso_tanque" class="form-control" value="{{$model['peso_tanque'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_prensa" class="control-label">Peso Prensa</label>
            <div class="">
                <input type="text" name="peso_prensa" id="peso_prensa" class="form-control" value="{{$model['peso_prensa'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_caja" class="control-label">Peso Caja</label>
            <div class="">
                <input type="text" name="peso_caja" id="peso_caja" class="form-control" value="{{$model['peso_caja'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="peso_otro_item" class="control-label">Peso Otro Item</label>
            <div class="">
                <input type="text" name="peso_otro_item" id="peso_otro_item" class="form-control" value="{{$model['peso_otro_item'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="observacion" class="control-label">Observacion</label>
            <div class="">
                <input type="text" name="observacion" id="observacion" class="form-control" value="{{$model['observacion'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="calculo_id" class="control-label">Calculo Id</label>
            <div class="">
                <input type="text" name="calculo_id" id="calculo_id" class="form-control" value="{{$model['calculo_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="proyecto_id" class="control-label">Proyecto Id</label>
            <div class="">
                <input type="text" name="proyecto_id" id="proyecto_id" class="form-control" value="{{$model['proyecto_id'] or ''}}" readonly="readonly">
            </div>
        </div>
        
                
        <div class="form-group col-md-3 col-lg-4">
            <label for="user_id" class="control-label">User Id</label>
            <div class="">
                <input type="text" name="user_id" id="user_id" class="form-control" value="{{$model['user_id'] or ''}}" readonly="readonly">
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