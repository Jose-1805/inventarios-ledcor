<?php
    if(!isset($model))$model = new InventariosLedcor\Models\ConsumoLaminaRollo();

    $rollos = \InventariosLedcor\Models\InventarioLaminaRollo::orderBy('consecutivo_rollo')->select('consecutivo_rollo','id','peso_validado')->get();
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

        <p class="titulo_principal margin-bottom-20">SGCL-FC02 - @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-consumolaminarollos'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Consumolaminarollo'),'method'=>'POST','url'=>url('/inventario/consumomaterial/laminarollo'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-consumolaminarollos']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Consumolaminarollo'),'method'=>'POST','url'=>url('/inventario/consumomaterial/laminarollo'),'class'=>'no_submit','data-alertas'=>'alertas-consumolaminarollos']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        {!! Form::hidden('id',$model->id) !!}
        <p class="font-weight-bold font-large col-xs-12 margin-bottom-20">Kilos faltantes: <span id="kilos_faltantes"></span></p>
        <div class="form-group col-md-4">
            {!! Form::label('inventario_lamina_rollo','Consecutivo rollo') !!}
            <select id="inventario_lamina_rollo" name="inventario_lamina_rollo" class="form-control">
                @foreach($rollos as $r)
                    <option value="{{$r->id}}" data-peso="{{$r->peso_validado}}" @if($r->id == $model->inventario_lamina_rollo_id) selected @endif>{{$r->consecutivo_rollo}}</option>
                @endforeach
            </select>
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
            {!! Form::label('maquina','Maquina corta') !!}
            {!! Form::select('maquina',['Fasti'=>'Fasti', 'Müller'=>'Müller', 'Durma'=>'Durma', 'Forming Roll'=>'Forming Roll'],null,['id'=>'maquina','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('cantidad','Cantidad') !!}
            {!! Form::number('cantidad',null,['id'=>'cantidad','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('medida','Medida') !!}
            {!! Form::number('medida',null,['id'=>'medida','class'=>'form-control']) !!}
        </div>

        @if($model->exists)
            @php
                $inventario = $model->inventarioLaminaRollo;
                $peso_un_plan_cort = $inventario->espesor_validado * $inventario->ancho_rollo * 0.00000786;
                $peso_tot_plan_cort = $peso_un_plan_cort * $model->cantidad;
            @endphp
            <div class="form-group col-md-4">
                {!! Form::label('peso_un_plan','Peso un plan cort') !!}
                {!! Form::text('peso_un_plan',$peso_un_plan_cort,['id'=>'peso_un_plan','class'=>'form-control']) !!}
            </div>

            <div class="form-group col-md-4">
                {!! Form::label('peso_tot_plan','Peso tot plan cort') !!}
                {!! Form::text('peso_tot_plan',$peso_tot_plan_cort,['id'=>'peso_tot_plan','class'=>'form-control']) !!}
            </div>
        @endif

        <div class="form-group col-md-4">
            {!! Form::label('maquina_destino','Maquina destino') !!}
            {!! Form::select('maquina_destino',['Trumpf'=>'Trumpf','Arima'=>'Arima','Edel'=>'Edel','Dobladora'=>'Dobladora','Otra'=>'Otra'],null,['id'=>'maquina_destino','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('corte','N° de fabricación') !!}
            {!! Form::select('corte',$cortes,$model->corte_id,['id'=>'corte','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('quien_corta','Quien corta') !!}
            {!! Form::select('quien_corta',$operarios,$model->quien_corta,['id'=>'quien_corta','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('quien_recibe','Quien recibe') !!}
            {!! Form::select('quien_recibe',$operarios,$model->quien_recibe,['id'=>'quien_recibe','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-8">
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
            $('#inventario_lamina_rollo').change(function () {
                $('#kilos_faltantes').html($(this).find('option:selected').data('peso'));
            })

            $('#inventario_lamina_rollo').change();
        })
    </script>
@endsection
