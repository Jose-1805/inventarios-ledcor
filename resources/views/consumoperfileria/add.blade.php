<?php
    if(!isset($model))$model = new InventariosLedcor\Models\ConsumoPerfileria();
    $cortes = \InventariosLedcor\Models\Corte::orderBy('no_fabricacion_inicial')->pluck('no_fabricacion_inicial','id')->toArray();
    $clientes = \InventariosLedcor\Models\Cliente::orderBy('nombre')->pluck('nombre','id');
    $materiales = \InventariosLedcor\Models\Material::where('familia','PERFILERIA')
        ->orderBy('texto_breve')->pluck('texto_breve','id')->toArray();
    $operarios = \InventariosLedcor\User::select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(users.nombres," ",users.apellidos) as nombre'))
        ->join('roles','rol_id','=','roles.id')
        ->where('roles.operarios','si')
        ->orderBy('nombre')->pluck('nombre','id');
?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">SGCL-FC19 - @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-consumoperfileria'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Consumoperfilerium'),'method'=>'POST','url'=>url('/inventario/consumomaterial/perfileria'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-consumoperfileria']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Consumoperfilerium'),'method'=>'POST','url'=>url('/inventario/consumomaterial/perfileria'),'class'=>'no_submit','data-alertas'=>'alertas-consumoperfileria']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        {!! Form::hidden('id',$model->id) !!}

        <div class="form-group col-md-4">
            {!! Form::label('corte','N° de fabricación') !!}
            {!! Form::select('corte',$cortes,$model->corte_id,['id'=>'corte','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('fecha','Fecha') !!}
            {!! Form::date('fecha',null,['id'=>'fecha','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('ensamble','Ensamble') !!}
            {!! Form::select('ensamble',['Tanque'=>'Tanque','Prensa'=>'Prensa','Perfileria'=>'Perfileria','Adicional'=>'Adicional','Mecanizado'=>'Mecanizado','Rad MZ'=>'Rad MZ','Rad TB'=>'Rad TB','Daño de máquina'=>'Daño de máquina'],null,['id'=>'ensamble','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('cantidad','Cantidad') !!}
            {!! Form::text('cantidad',null,['id'=>'cantidad','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('medida','Medida') !!}
            {!! Form::text('medida',null,['id'=>'medida','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('material','Material') !!}
            {!! Form::select('material',$materiales,$model->material_id,['id'=>'material','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('quien_solicito','Quien solicitó') !!}
            {!! Form::select('quien_solicito',$operarios,null,['id'=>'quien_solicito','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('cliente','Cliente interno') !!}
            {!! Form::select('cliente',$clientes,$model->cliente_id,['id'=>'cliente','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('quien_entrego','Quien entregó') !!}
            {!! Form::select('quien_entrego',$operarios,null,['id'=>'quien_entrego','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-xs-12">
            {!! Form::label('observacion','Observacion') !!}
            {!! Form::textarea('observacion',null,['id'=>'observacion','class'=>'form-control','rows'=>'3']) !!}
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