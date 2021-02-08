<?php
    if(!isset($model))$model = new InventariosLedcor\Models\EntradaLaminaAlmacen();
    $materiales = \InventariosLedcor\Models\Material::where('presentacion','Plancha')
        ->orderBy('texto_breve')->pluck('texto_breve','id')->toArray();
?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">SGCL-FC11 - @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-inventariolamina'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Inventariolamina'),'method'=>'POST','url'=>url('/inventario/ingresomaterial/lamina'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-inventariolamina']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Inventariolamina'),'method'=>'POST','url'=>url('/inventario/ingresomaterial/lamina'),'class'=>'no_submit','data-alertas'=>'alertas-inventariolamina']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        {!! Form::hidden('id',$model->id) !!}

        <div class="form-group col-md-4">
            {!! Form::label('fecha_recibido','Fecha recibido') !!}
            {!! Form::date('fecha_recibido',null,['id'=>'fecha_recibido','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('consecutivo_lamina','Consecutivo lámina') !!}
            {!! Form::text('consecutivo_lamina',null,['id'=>'consecutivo_lamina','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('material','Código material') !!}
            {!! Form::select('material',$materiales,$model->material_id,['id'=>'material','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('espesor_lote','Espesor lote') !!}
            {!! Form::text('espesor_lote',null,['id'=>'espesor_lote','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('peso_lamina_validado','Peso lámina validado') !!}
            {!! Form::text('peso_lamina_validado',null,['id'=>'peso_lamina_validado','class'=>'form-control']) !!}
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