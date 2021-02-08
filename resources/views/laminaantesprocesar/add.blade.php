<?php
    if(!isset($model))$model = new InventariosLedcor\Models\LaminaAntesProcesar();

    $materiales = \InventariosLedcor\Models\Material::where('presentacion','Plancha')
        ->orderBy('texto_breve')->pluck('texto_breve','id')->toArray();

    $solicitudes = [];

    if($model->exists){
        $solicitudes = InventariosLedcor\Models\Solicitud::where('solicitudes.id',$model->solicitud_id)->pluck('numero','id')->toArray();
    }

    $ordenes_compras = \InventariosLedcor\Models\OrdenCompra::orderBy('numero')->pluck('numero','id');
    $operarios = \InventariosLedcor\User::select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(users.nombres," ",users.apellidos) as nombre'))
        ->join('roles','rol_id','=','roles.id')
        ->where('roles.operarios','si')
        ->orderBy('nombre')->pluck('nombre','id');
?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">SGCL-FC18 - @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-laminaantesprocesars'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Laminaantesprocesar'),'method'=>'POST','url'=>url('/inventario/ingresomaterial/laminaantesprocesar'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-laminaantesprocesars']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Laminaantesprocesar'),'method'=>'POST','url'=>url('/inventario/ingresomaterial/laminaantesprocesar'),'class'=>'no_submit','data-alertas'=>'alertas-laminaantesprocesars']) !!}
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
            {!! Form::label('cantidad','Cantidad') !!}
            {!! Form::number('cantidad',null,['id'=>'cantidad','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('material','Material') !!}
            {!! Form::select('material',$materiales,$model->material_id,['id'=>'material','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('espesor_mm','Espesor mm') !!}
            {!! Form::text('espesor_mm',null,['id'=>'espesor_mm','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('peso_por_lamina','Peso lamina') !!}
            {!! Form::text('peso_por_lamina',null,['id'=>'peso_por_lamina','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('orden_compra','Orden de compra') !!}
            {!! Form::select('orden_compra',$ordenes_compras,$model->orden_compra_id,['id'=>'orden_compra','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('lote','Lote') !!}
            {!! Form::text('lote',null,['id'=>'lote','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('peso_guacal','Peso guacal') !!}
            {!! Form::text('peso_guacal',null,['id'=>'peso_guacal','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('operario','Operario') !!}
            {!! Form::select('operario',$operarios,$model->operario_id,['id'=>'operario','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('solicitud','N° solicitud') !!}
            <div id="contenedor_solicitud">
                {!! Form::select('solicitud',$solicitudes,$model->solicitud_id,['id'=>'solicitud','class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('largo','Largo') !!}
            {!! Form::text('largo',null,['id'=>'largo','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('ancho','Ancho') !!}
            {!! Form::text('ancho',null,['id'=>'ancho','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('observacion','Observaciones') !!}
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

@section('js')
    @parent
    <script src="{{asset('js/inventario_lamina_antes_procesar/add.js')}}"></script>
    @if(!$model->exists)
        <script>
            $(function () {
                $('#material').change();
            })
        </script>
    @endif
@endsection