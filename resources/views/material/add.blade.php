<?php
    if(!isset($model))$model = new \InventariosLedcor\Models\Material();
?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">MATERIALES - @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-materials'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Material'),'method'=>'POST','url'=>url('/inventario/material'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-materials']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Material'),'method'=>'POST','url'=>url('/inventario/material'),'class'=>'no_submit','data-alertas'=>'alertas-materials']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

                    {!! Form::hidden('id',$model->id) !!}

        <div class="form-group col-md-4">
            {!! Form::label('familia','Familia') !!}
            {!! Form::text('familia',null,['id'=>'familia','class'=>'form-control']) !!}
        </div>
                                        
        <div class="form-group col-md-4">
            {!! Form::label('unidad_medida','Unidad Medida') !!}
            {!! Form::text('unidad_medida',null,['id'=>'unidad_medida','class'=>'form-control']) !!}
        </div>
                                        
        <div class="form-group col-md-4">
            {!! Form::label('presentacion','Presentacion') !!}
            {!! Form::text('presentacion',null,['id'=>'presentacion','class'=>'form-control']) !!}
        </div>
                                        
        <div class="form-group col-md-4">
            {!! Form::label('especificacion','Especificacion') !!}
            {!! Form::text('especificacion',null,['id'=>'especificacion','class'=>'form-control']) !!}
        </div>
                                        
        <div class="form-group col-md-4">
            {!! Form::label('codigo','Codigo') !!}
            {!! Form::text('codigo',null,['id'=>'codigo','class'=>'form-control']) !!}
        </div>
                                        
        <div class="form-group col-md-4">
            {!! Form::label('texto_breve','Texto Breve') !!}
            {!! Form::text('texto_breve',null,['id'=>'texto_breve','class'=>'form-control']) !!}
        </div>
                                        
        <div class="form-group col-md-4">
            {!! Form::label('codigo_plano','Codigo Plano') !!}
            {!! Form::text('codigo_plano',null,['id'=>'codigo_plano','class'=>'form-control']) !!}
        </div>
                                        
        <div class="form-group col-md-4">
            <label for="valor_unidad" class="control-label">Valor Unidad</label>
            <div class="">
                <input type="text" name="valor_unidad" id="valor_unidad" class="form-control" value="{{$model['valor_unidad'] or ''}}">
            </div>
        </div>
                
        <div class="form-group col-md-4">
            <label for="espesor_mm" class="control-label">Espesor Mm</label>
            <div class="">
                <input type="text" name="espesor_mm" id="espesor_mm" class="form-control" value="{{$model['espesor_mm'] or ''}}">
            </div>
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('unidad_solicitud','Unidad solicitud') !!}
            {!! Form::select('unidad_solicitud',['Rollo'=>'Rollo','Guacal'=>'Guacal','Pieza'=>'Pieza','mts'=>'mts','lámina'=>'lámina'],null,['id'=>'unidad_solicitud','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('cantidad','Cantidad') !!}
            {!! Form::text('cantidad',null,['id'=>'cantidad','class'=>'form-control']) !!}
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