<?php
    if(!isset($model))$model = new InventariosLedcor\Models\SolicitudMaterial();
    $materiales = \InventariosLedcor\Models\Material::orderBy('codigo')->pluck('codigo','id')->toArray();
?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">SOLICITUD DE MATERIALES - @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-solicitudmaterials'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Solicitudmaterial'),'method'=>'POST','url'=>url('/inventario/solicitudmaterial'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-solicitudmaterials']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Solicitudmaterial'),'method'=>'POST','url'=>url('/inventario/solicitudmaterial'),'class'=>'no_submit','data-alertas'=>'alertas-solicitudmaterials']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        {!! Form::hidden('id',$model->id) !!}

        <div class="form-group col-md-4">
            {!! Form::label('fecha','Fecha de solicitud') !!}
            {!! Form::date('fecha',null,['id'=>'fecha','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('material','Material') !!}
            {!! Form::select('material',$materiales,$model->material_id,['id'=>'material','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('um','Um') !!}
            {!! Form::select('um',['Kg'=>'Kg','m'=>'m'],$model->um,['id'=>'um','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('cantidad','Cantidad') !!}
            {!! Form::number('cantidad',null,['id'=>'cantidad','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('cantidad_entregada','Cantidad entregada') !!}
            {!! Form::text('cantidad_entregada',null,['id'=>'cantidad_entregada','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('lote','Lote') !!}
            {!! Form::text('lote',null,['id'=>'lote','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-xs-12">
            {!! Form::label('observaciones','Observaciones') !!}
            {!! Form::textarea('observaciones',null,['id'=>'observaciones','class'=>'form-control','rows'=>'3']) !!}
        </div>
        
        <div class="form-group col-xs-12 text-right">
            <button type="submit" class="btn btn-success btn-submit btn-submit-general">
                <i class="fa fa-save"></i> Guardar
            </button>
        </div>
        {!! Form::close() !!}

    </div>
</div>
@endsection