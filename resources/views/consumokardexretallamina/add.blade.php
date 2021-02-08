<?php
    if(!isset($model))$model = new InventariosLedcor\Models\ConsumoKardexRetalLamina();

    $laminas = \InventariosLedcor\Models\EntradaLaminaAlmacen::orderBy('consecutivo_lamina')->pluck('consecutivo_lamina','id');
    $consecutivos_retal = \InventariosLedcor\Models\ConsumoDiarioLamina::whereNotNull('consecutivo_retal')->pluck('consecutivo_retal','id');
    $operarios = \InventariosLedcor\User::select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(users.nombres," ",users.apellidos) as nombre'))
        ->join('roles','rol_id','=','roles.id')
        ->where('roles.operarios','si')
        ->orderBy('nombre')->pluck('nombre','id');
?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">SGCL-FC08 - @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-consumokardexretallaminas'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Consumokardexretallamina'),'method'=>'POST','url'=>url('/inventario/consumomaterial/kardexretallamina'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-consumokardexretallaminas']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Consumokardexretallamina'),'method'=>'POST','url'=>url('/inventario/consumomaterial/kardexretallamina'),'class'=>'no_submit','data-alertas'=>'alertas-consumokardexretallaminas']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        @if(!$model->exists)
            @php($model->consecutivo_retal = InventariosLedcor\Models\ConsumoKardexRetalLamina::ultimoConsecutivoRetal()+1)
        @endif

        {!! Form::hidden('id',$model->id) !!}

        <div class="form-group col-md-4">
            {!! Form::label('entrada_lamina_almacen','Consecutivo lámina') !!}
            {!! Form::select('entrada_lamina_almacen',$laminas,$model->entrada_lamina_almacen_id,['id'=>'entrada_lamina_almacen','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('consecutivo_retal','Consecutivo retal') !!}
            {!! Form::text('consecutivo_retal',$model->consecutivo_retal,['id'=>'consecutivo_retal','class'=>'form-control','disabled'=>'disabled']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('fecha_ingreso','Fecha de ingreso') !!}
            {!! Form::date('fecha_ingreso',null,['id'=>'fecha_ingreso','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('cantidad','Cantidad') !!}
            {!! Form::number('cantidad',null,['id'=>'cantidad','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('largo','Largo') !!}
            {!! Form::number('largo',null,['id'=>'largo','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('ancho','Ancho') !!}
            {!! Form::number('ancho',null,['id'=>'ancho','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('peso','Peso') !!}
            {!! Form::text('peso',null,['id'=>'peso','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('fecha','Fecha') !!}
            {!! Form::date('fecha',null,['id'=>'fecha','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('quien_gasta','Quien gasta') !!}
            {!! Form::select('quien_gasta',$operarios,null,['id'=>'quien_gasta','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('forma_retal','Forma Retal') !!}
            {!! Form::file('forma_retal',null,['id'=>'forma_retal_id','class'=>'form-control']) !!}
            @if($model->exists && $model->formaRetal)
                <div class="form-group col-xs-12 no-padding margin-top-10">
                    <a href="{{url('/archivo/'.str_replace('/','-',$model->formaRetal->ubicacion).'-'.$model->formaRetal->nombre)}}" target="_blank" class="btn btn-info btn-block">Ver forma retal <i class="fa fa-file"></i></a>
                </div>
            @endif
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