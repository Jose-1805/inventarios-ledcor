<?php
    if(!isset($model))$model = new InventariosLedcor\Models\Corte();

    $calculos = [''=>'Seleccione un calculo']+\InventariosLedcor\Models\Calculo::orderBy('fert')->pluck('fert','id')->toArray();
    $proyectos = \InventariosLedcor\Models\Proyecto::orderBy('nombre')->pluck('nombre','id');
    $usuarios = \InventariosLedcor\User::select('users.id',\Illuminate\Support\Facades\DB::raw('CONCAT(users.nombres," ",users.apellidos) as nombre'))
        ->join('roles','rol_id','=','roles.id')
        ->where('roles.operarios','si')
        ->orderBy('nombre')->pluck('nombre','id');
?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">

        <p class="titulo_principal margin-bottom-20">SGCL-FC01 @if($model->exists) EDITAR @else NUEVO @endif LISTADO DE CORTE</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-cortes'])
        </div>

        @if(isset($model))
            {!! Form::model($model,['id'=>strtolower('form-Corte'),'method'=>'POST','url'=>url('/corte'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit','data-alertas'=>'alertas-cortes']) !!}
        @else
            {!! Form::open(['id'=>strtolower('form-Corte'),'method'=>'POST','url'=>url('/corte'),'class'=>'no_submit','data-alertas'=>'alertas-cortes']) !!}
        @endif

        @if (isset($model) && $model->exists)
            <input type="hidden" name="_method" value="PATCH">
        @endif

        {!! Form::hidden('id',$model->id) !!}

        <div class="form-group col-md-4">
            {!! Form::label('calculo','Calculo') !!}
            {!! Form::select('calculo',$calculos,$model->calculo_id,['id'=>'calculo','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('ensamble','Ensamble') !!}
            {!! Form::select('ensamble',['Tanque'=>'Tanque','Prensa'=>'Prensa','Perfileria'=>'Perfileria','Adicional'=>'Adicional','Mecanizado'=>'Mecanizado','Rad MZ'=>'Rad MZ','Rad TB'=>'Rad TB','Daño de máquina'=>'Daño de máquina'],null,['id'=>'ensamble','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('cantidad_tk','Cantidad Tk') !!}
            {!! Form::number('cantidad_tk',null,['id'=>'cantidad_tk','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('proyecto','Proyecto') !!}
            {!! Form::select('proyecto',$proyectos,$model->proyecto_id,['id'=>'proyecto','class'=>'form-control']) !!}
        </div>
        <div class="form-group col-md-4">
            {!! Form::label('no_fabricacion_inicial','N° fabricacion inicial') !!}
            {!! Form::text('no_fabricacion_inicial',null,['id'=>'no_fabricacion_inicial','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('no_fabricacion_final','N° fabricacion final') !!}
            {!! Form::text('no_fabricacion_final',null,['id'=>'no_fabricacion_final','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('user','Elaborado por') !!}
            {!! Form::select('user',$usuarios,$model->user_id,['id'=>'user','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('peso_tanque','Peso tanque') !!}
            {!! Form::text('peso_tanque',null,['id'=>'peso_tanque','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('peso_prensa','Peso prensa') !!}
            {!! Form::text('peso_prensa',null,['id'=>'peso_prensa','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('peso_caja','Peso caja') !!}
            {!! Form::text('peso_caja',null,['id'=>'peso_caja','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('peso_otro_item','Peso otro item') !!}
            {!! Form::text('peso_otro_item',null,['id'=>'peso_otro_item','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('fecha_listado','Fecha listado') !!}
            {!! Form::date('fecha_listado',null,['id'=>'fecha_listado','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4">
            {!! Form::label('observacion','Observaciones') !!}
            {!! Form::text('observacion',null,['id'=>'observacion','class'=>'form-control']) !!}
        </div>

        <div class="form-group col-md-4 margin-top-30">
            {!! Form::label('verificacion_calidad','Verificación de calidad') !!}
            <input type="checkbox" name="verificacion_calidad" value="si" @if($model->verificacion_calidad == 'si') checked @endif>
        </div>

        @if(!$model->exists || ($model->exists && $model->permitirEdicion()))
            <div class="form-group col-xs-12 text-right">
                <button type="submit" class="btn btn-success btn-submit btn-submit-general">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        @endif
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
                        <th>Cantidad</th>
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

            @if($model->permitirEdicion())
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
        @endif

    </div>
</div>
@endsection

@section('js')
    @parent
    @if($model->exists)
        <script src="{{asset('js/corte/detalle_manual.js')}}" type="text/javascript"></script>
        <script type="text/javascript">
            $(function(){
                setCorte('{{$model->id}}');
                cargarTablaDetalleManual();
            });
        </script>
    @endif

    <script src="{{asset('js/corte/add.js')}}" type="text/javascript"></script>
@endsection