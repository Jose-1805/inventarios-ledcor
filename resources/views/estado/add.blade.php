<?php
    if(!isset($model))$model = new \InventariosLedcor\Models\Estado();
    $subensambles = ['Tanque'=>'Tanque','Prensa'=>'Prensa','Perfileria'=>'Perfileria','Adicional'=>'Adicional','Mecanizado'=>'Mecanizado','Rad MZ'=>'Rad MZ','Rad TB'=>'Rad TB','Daño de máquina'=>'Daño de máquina'];
    $lineas = ['LDT'=>'LDT','MDT'=>'MDT','SDT'=>'SDT','Adicionales'=>'Adicionales','Mecanizados'=>'Mecanizados'];
    $tipos_items = ['Corte'=>'Corte','Radiadores'=>'Radiadores','Adicionales'=>'Adicionales','Mecanizados'=>'Mecanizados'];
    $tipos_tk = ['MON'=>'MON','PM'=>'PM','TRI'=>'TRI','TRI ESP'=>'TRI ESP','PERF'=>'PERF','PRENSA'=>'PRENSA','ADIC'=>'ADIC','MEC'=>'MEC'];

?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">ESTADOS - @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-estados'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-estado'),'method'=>'POST','url'=>url('/estado'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-estados']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-estado'),'method'=>'POST','url'=>url('/estado'),'class'=>'no_submit','data-alertas'=>'alertas-estados']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        {!! Form::hidden('id',$model->id) !!}

        <div class="form-group col-md-4">
            {!! Form::label('nombre','Nombre') !!}
            {!! Form::text('nombre',null,['id'=>'nombre','class'=>'form-control']) !!}
        </div>
                                        
        <div class="form-group col-md-4">
            {!! Form::label('precedencia','Precedencia') !!}
            {!! Form::number('precedencia',null,['id'=>'precedencia','class'=>'form-control']) !!}
        </div>
                                        
        <div class="form-group col-md-4">
            {!! Form::label('email','Email') !!}
            {!! Form::text('email',null,['id'=>'email','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('linea','Linea') !!}
            {!! Form::select('linea',$lineas,null,['id'=>'linea','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('tipo_item','Tipo item') !!}
            {!! Form::select('tipo_item',$tipos_items,null,['id'=>'tipo_item','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('subensamble','Subensamble') !!}
            {!! Form::select('subensamble',$subensambles,null,['id'=>'subensamble','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('tipo_tk','Tipo TK') !!}
            {!! Form::select('tipo_tk',$tipos_tk,null,['id'=>'tipo_tk','class'=>'form-control']) !!}
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