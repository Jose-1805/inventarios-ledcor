<?php
    if(!isset($model))$model = new InventariosLedcor\Models\Calculo();
?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">@if($model->exists) EDITAR @else NUEVO @endif CALCULO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-calculos'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Calculo'),'method'=>'POST','url'=>url('/calculo'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-calculos']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Calculo'),'method'=>'POST','url'=>url('/calculo'),'class'=>'no_submit','data-alertas'=>'alertas-calculos']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        {!! Form::hidden('id',$model->id) !!}

        <div class="form-group col-md-4">
            {!! Form::label('numero','N° calculo') !!}
            {!! Form::text('numero',null,['id'=>'numero','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('ensamble','Ensamble') !!}
            {!! Form::select('ensamble',['Fondo'=>'Fondo','Tanque'=>'Tanque','Tk Exp.'=>'Tk Exp.','Tapa'=>'Tapa','Prensa'=>'Prensa','Gabinete'=>'Gabinete','Radiador'=>'Radiador','Mecanizado'=>'Mecanizado','Adicional'=>'Adicional'],null,['id'=>'ensamble','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('fert','FERT') !!}
            {!! Form::text('fert',null,['id'=>'fert','class'=>'form-control']) !!}
        </div>
        
        <div class="form-group col-xs-12 text-right">
            <button type="submit" class="btn btn-success btn-submit btn-submit-general">
                <i class="fa fa-save"></i> Guardar
            </button>
        </div>
        {!! Form::close() !!}

        @if($model->exists)
            <div class="col-xs-12" style="overflow-x: auto;">
                <table class="table table-hover dataTable" id="tabla">
                    <thead>
                    <tr>
                        <th>Posición</th>
                        <th>Plano</th>
                        <th>Ensamble</th>
                        <th>Nombre</th>
                        <th>Espesor</th>
                        <th>Long 1</th>
                        <th>Long 2</th>
                        <th>Cen - corte</th>
                        <th>Peso net</th>
                        <th>Masa</th>
                        <th>Unidad</th>
                        <th>Cod - material</th>
                        <th>Especif</th>
                        <th>Descripción</th>
                        <th>Observaciones</th>
                        <th>Proceso</th>
                        <th style="min-width: 120px;text-align: center !important;">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="form-group col-xs-12 text-right margin-top-20">
                <button type="button" class="btn btn-primary" id="btn-nuevo-detalle-manual">
                    <i class="fa fa-save"></i> Nuevo detalle manual
                </button>
            </div>

            <div class="modal fade" id="modal_detalle_manual" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Detalle manual</h4>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-success" id="btn-guardar-detalle-manual">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

@if($model->exists)
@section('js')
    @parent
    <script src="{{asset('js/calculo/detalle_manual.js')}}" type="text/javascript"></script>

    <script type="text/javascript">
        $(function(){
            setCalculo('{{$model->id}}');
            cargarTablaDetalleManual();
        });
    </script>
@endsection
@endif