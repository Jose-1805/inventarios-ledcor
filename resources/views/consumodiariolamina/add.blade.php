<?php
    if(!isset($model))$model = new InventariosLedcor\Models\ConsumoDiarioLamina();

    $laminas = \InventariosLedcor\Models\EntradaLaminaAlmacen::select('entrada_lamina_almacen.*')
        ->orderBy('consecutivo_lamina')->get();
    $cortes = \InventariosLedcor\Models\Corte::orderBy('no_fabricacion_inicial')->pluck('no_fabricacion_inicial','id')->toArray();
    $operarios = \InventariosLedcor\User::select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(users.nombres," ",users.apellidos) as nombre'))
        ->join('roles','rol_id','=','roles.id')
        ->where('roles.operarios','si')
        ->orderBy('nombre')->pluck('nombre','id');
?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">SGCL-FC24 @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-consumodiariolaminas'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Consumodiariolamina'),'method'=>'POST','url'=>url('/inventario/consumomaterial/lamina'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-consumodiariolaminas']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Consumodiariolamina'),'method'=>'POST','url'=>url('/inventario/consumomaterial/lamina'),'class'=>'no_submit','data-alertas'=>'alertas-consumodiariolaminas']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        {!! Form::hidden('id',$model->id) !!}

        <p class="font-weight-bold font-large col-xs-12 margin-bottom-20">Kilos faltantes: <span id="kilos_faltantes"></span></p>
        <div class="form-group col-md-4">
            {!! Form::label('entrada_lamina_almacen','Consecutivo lámina') !!}
            <select id="entrada_lamina_almacen" name="entrada_lamina_almacen" class="form-control">
                @foreach($laminas as $l)
                    <option value="{{$l->id}}" data-peso="{{$l->peso_lamina_validado}}" @if($l->id == $model->entrada_lamina_almacen_id) selected @endif>{{$l->consecutivo_lamina}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('retal','Consecutivo retal') !!}
            <div id="contenedor-select-retal">
                {!! Form::select('retal',[''=>'Seleccione un consecutivo'],null,['id'=>'retal','class'=>'form-control']) !!}
            </div>
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('fecha','Fecha') !!}
            {!! Form::date('fecha',null,['id'=>'fecha','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('maquina','Maquina') !!}
            {!! Form::select('maquina',['Fasti'=>'Fasti', 'Müller'=>'Müller', 'Durma'=>'Durma', 'Forming Roll'=>'Forming Roll'],null,['id'=>'maquina','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('ensamble','Ensamble') !!}
            {!! Form::select('ensamble',['Fondo'=>'Fondo','Tanque'=>'Tanque','Tk Exp.'=>'Tk Exp.','Tapa'=>'Tapa','Prensa'=>'Prensa','Gabinete'=>'Gabinete','Radiador'=>'Radiador','Mecanizado'=>'Mecanizado','Adicional'=>'Adicional'],null,['id'=>'ensamble','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('corte','N° de fabricación') !!}
            {!! Form::select('corte',$cortes,$model->corte_id,['id'=>'corte','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('consumo','Consumo') !!}
            {!! Form::text('consumo',null,['id'=>'consumo','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('desperdicio','Desperdicio') !!}
            {!! Form::text('desperdicio',null,['id'=>'desperdicio','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('operario','Operario') !!}
            {!! Form::select('operario',$operarios,$model->operario_id,['id'=>'operario','class'=>'form-control']) !!}
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
    <script>
        $(function () {
            $('#entrada_lamina_almacen').change(function () {
                $('#kilos_faltantes').html($(this).find('option:selected').data('peso'));

                    var params = {_token:$('#general_token').val(),lamina:$(this).val(),name:'retal'};
                    var url = $('#general_url').val()+'/inventario/consumomaterial/lamina/select-consecutivo-retal';
                    $.post(url,params)
                        .done(function (data) {
                            $('#contenedor-select-retal').html(data);
                        })
            })

            $('#entrada_lamina_almacen').change();
        })
    </script>
@endsection