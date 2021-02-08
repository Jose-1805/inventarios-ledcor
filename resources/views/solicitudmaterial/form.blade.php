<?php
    if(!isset($id))$id = 'form-nueva-solicitud';
    if(!isset($solicitud)) $solicitud = new \InventariosLedcor\Models\Solicitud();
?>
{!! Form::model($solicitud,['id'=>$id]) !!}
    {!! Form::hidden('id',$solicitud->id) !!}
    <div class="form-group">
        {!! Form::label('numero','Número') !!}
        {!! Form::text('numero',null,['id'=>'numero','class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('fecha','Fecha') !!}
        {!! Form::date('fecha',null,['id'=>'fecha','class'=>'form-control']) !!}
    </div>
{!! Form::close() !!}