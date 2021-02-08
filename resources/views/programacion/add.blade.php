<?php
    if(!isset($model))$model = new InventariosLedcor\Models\Programacion();
    $proyectos = \InventariosLedcor\Models\Proyecto::orderBy('nombre')->pluck('nombre','id');
    $estados = \InventariosLedcor\Models\Estado::pluck('nombre','id');
    $proveedores = \InventariosLedcor\Models\Proveedor::orderBy('nombre')->pluck('nombre','id');
    if($model->exists){
        $estado = $model->estado;
        $estados = \InventariosLedcor\Models\Estado::where('estados.precedencia','>=',$estado->precedencia)->pluck('nombre','id');
    }
?>
@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">PROGRAMACION - @if($model->exists) EDITAR @else NUEVO @endif REGISTRO</p>

        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-programacions'])
        </div>

            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#general" id="btn_general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
                    <li role="presentation"><a href="#fisico" id="btn_fisico" aria-controls="fisico" role="tab" data-toggle="tab">Físico</a></li>
                    <li role="presentation"><a href="#planeacion" id="btn_planeacion" aria-controls="planeacion" role="tab" data-toggle="tab">Planeación</a></li>
                    @if($model->exists)
                        <li role="presentation"><a href="#descargas" id="btn_descargas" aria-controls="descargas" role="tab" data-toggle="tab">Cargas</a></li>
                    @endif
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    @if(isset($model))
                        {!! Form::model($model,['id'=>strtolower('form-Programacion'),'method'=>'POST','url'=>url('/programacion'.( isset($model) ? "/" . $model->id : "")),'class'=>'no_submit tab-content','data-alertas'=>'alertas-programacions']) !!}
                    @else
                        {!! Form::open(['id'=>strtolower('form-Programacion'),'method'=>'POST','url'=>url('/programacion'),'class'=>'no_submit tab-content','data-alertas'=>'alertas-programacions']) !!}
                    @endif

                    {!! Form::hidden('id',$model->id) !!}

                        @if (isset($model) && $model->exists)
                            <input type="hidden" name="_method" value="PATCH">
                        @endif

                        <div role="tabpanel" class="tab-pane padding-top-30 active" id="general">
                            @include('programacion.inputs.general')
                            <div class="col-xs-12 text-right padding-top-20" style="border-top: 1px solid #c3c3c3;">
                                <a href="#!" class="btn btn-info" onclick="document.getElementById('btn_fisico').click();">Siguiente</a>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane padding-top-30" id="fisico">
                            @include('programacion.inputs.fisico')
                            <div class="col-xs-12 text-right padding-top-20" style="border-top: 1px solid #c3c3c3;">
                                <a href="#!" class="btn btn-default" onclick="document.getElementById('btn_general').click();">Anterior</a>
                                <a href="#!" class="btn btn-info" onclick="document.getElementById('btn_planeacion').click();">Siguiente</a>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane padding-top-30" id="planeacion">
                            @include('programacion.inputs.planeacion')
                            <div class="col-xs-12 text-right padding-top-20" style="border-top: 1px solid #c3c3c3;">
                                <a href="#!" class="btn btn-default" onclick="document.getElementById('btn_fisico').click();">Anterior</a>
                                <button type="submit" class="btn btn-success btn-submit" id="btn-save-programacion">
                                    <i class="fa fa-save"></i> Guardar
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                    @if($model->exists)
                        <div role="tabpanel" class="tab-pane padding-top-30" id="descargas">
                            @include('programacion.inputs.cargas')
                        </div>
                    @endif
                </div>
            </div>
    </div>

    <div id="modal-confirmar-precedencia" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Confirmar</h4>
                </div>
                <div class="modal-body">
                    <p>La precedencia del estado seleccionado indica saltos en el orden normal de los estados, al guardar la programación no podrá actualizar a un estado anterior</p>
                    <p>¿Está seguro guardar la información?</p>
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-sm btn-primary" data-dismiss="modal">No</a>
                            <a class="btn btn-sm btn-danger" id="btn-ok-confirmar-precedencia">Si</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/programacion/add.js')}}"></script>
    @if($model->exists)
        <script>
            $(function () {
                cargarAnexos({{$model->id}});
            })
        </script>
    @endif
@endsection