<?php
    $materiales = \InventariosLedcor\Models\Material::orderBy('texto_breve')->pluck('texto_breve','id')->toArray();
?>
@include('layouts.alertas',['id_contenedor'=>'alertas_form_detalle_manual'])
{!! Form::model($detalle,['id'=>'form_detalle_manual','class'=>'no_submit row']) !!}

    <input type="hidden" name="corte" value="{{$corte->id}}">
    @if(isset($detalle) && $detalle->exists)
        <input type="hidden" name="detalle" value="{{$detalle->id}}">
    @endif

    <div class="form-group col-md-6">
        {!! Form::label('posicion','Posición') !!}
        {!! Form::number('posicion',null,['id'=>'posicion','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('plano','Plano') !!}
        {!! Form::text('plano',null,['id'=>'plano','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('ensamble','Ensamble') !!}
        {!! Form::select('ensamble',['Tanque'=>'Tanque', 'Prensa'=>'Prensa', 'Perfileria'=>'Perfileria', 'Adicional'=>'Adicional', 'Mecanizado'=>'Mecanizado', 'Rad MZ'=>'Rad MZ', 'Rad TB'=>'Rad TB', 'Daño de máquina'=>'Daño de máquina'],null,['id'=>'ensamble','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('nombre','Nombre') !!}
        {!! Form::text('nombre',null,['id'=>'nombre','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('cantidad','Cantidad') !!}
        {!! Form::number('cantidad',null,['id'=>'cantidad','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('longitud_1','Longitud 1') !!}
        {!! Form::text('longitud_1',null,['id'=>'longitud_1','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('longitud_2','Longitud 2') !!}
        {!! Form::text('longitud_2',null,['id'=>'longitud_2','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('centro_corte','Centro de corte') !!}
        {!! Form::text('centro_corte',null,['id'=>'centro_corte','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('peso_neto','Peso neto') !!}
        {!! Form::text('peso_neto',null,['id'=>'peso_neto','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('masa','Masa') !!}
        {!! Form::text('masa',null,['id'=>'masa','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('material','Material') !!}
        {!! Form::select('material',$materiales,$detalle->material_id,['id'=>'material','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-6">
        {!! Form::label('proceso','Proceso') !!}
        {!! Form::select('proceso',['T'=>'T', 'D'=>'D', 'NULL'=>'NULL'],null,['id'=>'proceso','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-xs-12">
        {!! Form::label('observaciones','Observaciones') !!}
        {!! Form::textarea('observaciones',null,['id'=>'observaciones','class'=>'form-control','rows'=>'3']) !!}
    </div>
{!! Form::close() !!}