@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SOLICITUD DE MATERIALES</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-solicitudmaterials'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="#!" type="button" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#modal-nueva-solicitud"><i class="fa fa-plus"></i></a>
            <a href="#!" type="button" class="btn btn-success btn-circle margin-top-10" id="btn-enviar-correo"><i class="fa fa-envelope"></i></a>
        </div>
        <div class="">
            <div class="row">
                <div class="form-group col-md-4 col-lg-3 col-md-offset-3">
                    <label for="cantidad">Cantidad</label>
                    {!! Form::select('cantidad',['todo'=>'todo','cero'=>'0'],null,['id'=>'cantidad','class'=>'item-filtro form-control']) !!}
                </div>
                <div class="form-group col-md-4 col-lg-3">
                    <label for="fecha_inicial">Fecha inicial</label>
                    {!! Form::date('fecha_inicial',null,['id'=>'fecha_inicial','class'=>'item-filtro form-control']) !!}
                </div>
                <div class="form-group col-md-4 col-lg-3">
                    <label for="fecha_final">Fecha final</label>
                    {!! Form::date('fecha_final',null,['id'=>'fecha_final','class'=>'item-filtro form-control']) !!}
                </div>
            </div>
            <table class="table table-hover dataTable cell-selectable" id="tabla">
              <thead>
                <tr>
                    <th>N° solicitud</th>
                    <th>Fecha</th>
                    <th style="min-width: 120px;text-align: center !important;">Opciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
    </div>
    <div id="modal-nueva-solicitud" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Nueva solicitud</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        @include('layouts.alertas',['id_contenedor'=>'alertas-nueva-solicitud'])
                    </div>
                    {{-- @include('solicitudmaterial.form') --}}
                    <p>¿Está seguro de crear una nueva solicitud de material?</p>
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</a>
                            <a class="btn btn-sm btn-success" id="btn-ok-nueva-solicitud">Guardar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-editar-solicitud" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Editar solicitud</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        @include('layouts.alertas',['id_contenedor'=>'alertas-editar-solicitud'])
                    </div>
                    <div id="contenedor-form-editar-solicitud"></div>
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</a>
                            <a class="btn btn-sm btn-success" id="btn-ok-editar-solicitud">Guardar</a>
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
    <script type="text/javascript" src="{{asset('/js/solicitud_material/solicitud_material.js')}}"></script>
@endsection