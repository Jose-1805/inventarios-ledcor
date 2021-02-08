<?php
    if(!isset($model))$model = new InventariosLedcor\Models\KardexPerfileria();
    $proveedores = \InventariosLedcor\Models\Proveedor::orderBy('nombre')->pluck('nombre','id');
    $materiales = \InventariosLedcor\Models\Material::orderBy('codigo')->pluck('codigo','id')->toArray();
    $operarios = \InventariosLedcor\User::select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(users.nombres," ",users.apellidos) as nombre'))
        ->join('roles','rol_id','=','roles.id')
        ->where('roles.operarios','si')
        ->orderBy('nombre')->pluck('nombre','id');

?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">SGCL-FC22 @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-kardexperfileria'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Kardexperfilerium'),'method'=>'POST','url'=>url('/inventario/ingresomaterial/kardexperfileria'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-kardexperfileria']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Kardexperfilerium'),'method'=>'POST','url'=>url('/inventario/ingresomaterial/kardexperfileria'),'class'=>'no_submit','data-alertas'=>'alertas-kardexperfileria']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        {!! Form::hidden('id',$model->id) !!}

        <div class="form-group col-md-4">
            {!! Form::label('fecha','Fecha recibido') !!}
            {!! Form::date('fecha',null,['id'=>'fecha','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('cantidad','Cantidad') !!}
            {!! Form::text('cantidad',null,['id'=>'cantidad','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('material','Material') !!}
            {!! Form::select('material',$materiales,$model->material_id,['id'=>'material','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('entrega_a','Entrega A') !!}
            {!! Form::select('entrega_a',$operarios,$model->entrega_a,['id'=>'entrega_a','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('recibe_a','Recibe A') !!}
            {!! Form::select('recibe_a',$operarios,$model->recibe_a,['id'=>'recibe_a','class'=>'form-control']) !!}
        </div>

        <?php
            //dd($proveedores);
        ?>
        <div class="form-group col-md-4">
            {!! Form::label('proveedor_','Proveedor') !!}
            {!! Form::select('proveedor_',$proveedores,$model->proveedor_id,['id'=>'proveedor_','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-12">
            {!! Form::label('observacion','Observaciones') !!}
            {!! Form::text('observacion',null,['id'=>'observacion','class'=>'form-control']) !!}
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