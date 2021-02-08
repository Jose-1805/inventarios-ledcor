<?php
    if(!isset($model))$model = new InventariosLedcor\Models\InventarioLaminaRollo();
    $proveedores = \InventariosLedcor\Models\Proveedor::orderBy('nombre')->pluck('nombre','id');
    $materiales = \InventariosLedcor\Models\Material::where('presentacion','ROLLO')
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

        <p class="titulo_principal margin-bottom-20">SGCL-FC13 - @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-inventariolaminarollos'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Inventariolaminarollo'),'method'=>'POST','url'=>url('/inventario/ingresomaterial/laminarollo'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-inventariolaminarollos']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Inventariolaminarollo'),'method'=>'POST','url'=>url('/inventario/ingresomaterial/laminarollo'),'class'=>'no_submit','data-alertas'=>'alertas-inventariolaminarollos']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        {!! Form::hidden('id',$model->id) !!}

        <div class="form-group col-md-4">
            {!! Form::label('material','Material') !!}
            {!! Form::select('material',$materiales,$model->material_id,['id'=>'material','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('fecha_recibido','Fecha recibido') !!}
            {!! Form::date('fecha_recibido',null,['id'=>'fecha_recibido','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('solicitud','N° solicitud') !!}
            <div id="contenedor_solicitud">
                {!! Form::select('solicitud',$solicitudes,$model->solicitud_id,['id'=>'solicitud','class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('peso_validado','Peso validado') !!}
            {!! Form::text('peso_validado',null,['id'=>'peso_validado','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('espesor_validado','Espesor validado') !!}
            {!! Form::text('espesor_validado',null,['id'=>'espesor_validado','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('peso_sin_validar','Peso sin validar') !!}
            {!! Form::text('peso_sin_validar',null,['id'=>'peso_sin_validar','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('lote','Lote') !!}
            {!! Form::text('lote',null,['id'=>'lote','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('no_identificacion_rollo','No. identificación rollo') !!}
            {!! Form::text('no_identificacion_rollo',null,['id'=>'no_identificacion_rollo','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('fecha_rollo','Fecha rollo') !!}
            {!! Form::date('fecha_rollo',null,['id'=>'fecha_rollo','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('proveedor','Proveedor') !!}
            {!! Form::select('proveedor',$proveedores,$model->proveedor_id,['id'=>'proveedor','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('norma','Norma') !!}
            {!! Form::text('norma',null,['id'=>'norma','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('ancho_rollo','Ancho rollo') !!}
            {!! Form::number('ancho_rollo',null,['id'=>'ancho_rollo','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('orden_compra','Orden compra') !!}
            {!! Form::select('orden_compra',$ordenes_compras,$model->orden_compra_id,['id'=>'orden_compra','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('consecutivo_rollo','Consecutivo rollo') !!}
            {!! Form::text('consecutivo_rollo',null,['id'=>'consecutivo_rollo','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('operario','Operario') !!}
            {!! Form::select('operario',$operarios,$model->operario_id,['id'=>'operario','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-8">
            {!! Form::label('observacion','Observación') !!}
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
    <script src="{{asset('js/inventario_lamina_rollo/add.js')}}"></script>
    @if(!$model->exists)
        <script>
            $(function () {
                $('#material').change();
            })
        </script>
    @endif
@endsection