@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">PROGRAMACIÓN</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-programacions'])
        </div>
        <div class="contenedor-opciones-vista">
            <a title="Nuevo registro" href="{{url('/programacion/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
            <a title="Copiar" href="#!" id="btn-copiar" type="button" class="btn btn-success btn-circle margin-top-10"><i class="fa fa-copy"></i></a>
            <a title="Formato de importación" href="{{url('/programacion-formato-importacion')}}" type="button" class="btn btn-success btn-circle margin-top-10"><i class="fa fa-download"></i></a>
            <a title="Importar" href="#!" type="button" data-toggle="modal" data-target="#modal-importar-programacion" class="btn btn-success btn-circle margin-top-10"><i class="fa fa-upload"></i></a>
            <a title="Seguimiento" href="#!" id="btn-seguimiento" type="button" class="btn btn-success btn-circle margin-top-10"><i class="fa fa-list-alt"></i></a>
        </div>
        <div class="">
            <div class="row">
                <div class="form-group col-sm-2">
                    <label for="estado">Estado</label>
                    {!! Form::select('estado',[''=>'Seleccione un estado']+\InventariosLedcor\Models\Estado::pluck('nombre','id')->toArray(),null,['id'=>'estado','class'=>'item-filtro form-control']) !!}
                </div>
                <div class="form-group col-sm-3">
                    <label for="fecha_inicial">Fecha plan inicial</label>
                    {!! Form::date('fecha_inicial',null,['id'=>'fecha_inicial','class'=>'item-filtro form-control']) !!}
                </div>
                <div class="form-group col-sm-3">
                    <label for="fecha_final">Fecha plan final</label>
                    {!! Form::date('fecha_final',null,['id'=>'fecha_final','class'=>'item-filtro form-control']) !!}
                </div>
                <div class="form-group col-sm-2">
                    {!! Form::label('linea','Linea') !!}
                    {!! Form::select('linea',[''=>'Todos','LDT'=>'LDT','MDT'=>'MDT','SDT'=>'SDT','Adicionales'=>'Adicionales','Mecanizados'=>'Mecanizados','Daño de máquina'=>'Daño de máquina'],null,['id'=>'linea','class'=>'item-filtro form-control']) !!}
                </div>
                <div class="form-group col-sm-2">
                    {!! Form::label('subensamble','Subensamble') !!}
                    {!! Form::select('subensamble',[''=>'Todos','Tanque'=>'Tanque','Prensa'=>'Prensa','Perfileria'=>'Perfileria','Adicional'=>'Adicional','Mecanizado'=>'Mecanizado','Rad MZ'=>'Rad MZ','Rad TB'=>'Rad TB','Daño de máquina'=>'Daño de máquina'],null,['id'=>'subensamble','class'=>'item-filtro form-control']) !!}
                </div>
            </div>
            <table class="table table-hover dataTable cell-selectable" id="tabla">
              <thead>
                <tr>
                    <th>Linea</th>
                    <th>Tipo item</th>
                    <th>Subensamble</th>
                    <th>Tipo Tk</th>
                    <th>No preliminar Inicial</th>
                    <th>No preliminar Final</th>
                    <th>No fabricación Inicial</th>
                    <th>No fabricación Final</th>
                    <th>Orden fabricación trafo</th>
                    <th>Cantidad Tk</th>
                    <th>KVA</th>
                    <th>Calculo</th>
                    <th>Proyecto</th>
                    <th>Fecha plan</th>
                    <th>Estado</th>
                    <th style="min-width: 120px;text-align: center !important;">Opciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
    </div>

    <div id="modal-importar-programacion" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Importar</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        @include('layouts.alertas',['id_contenedor'=>'alertas-importacion'])
                    </div>
                    {!! Form::open(['id'=>'form-importacion']) !!}
                        <input type="file" name="archivo" id="archivo">
                    {!! Form::close() !!}
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</a>
                            <a class="btn btn-sm btn-success" id="btn-ok-importar-programacion">Importar</a>
                        </div>
                    </div>
                    {!! Form::hidden('programacion_seguimiento',null,['id'=>'programacion_seguimiento']) !!}
                </div>
            </div>
        </div>
    </div>

    <div id="modal-seguimiento" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Registrar seguimiento</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        @include('layouts.alertas',['id_contenedor'=>'alertas-seguimiento'])
                    </div>
                    {!! Form::open(['id'=>'form-seguimiento']) !!}
                        <div class="form-group">
                            {!! Form::label('nota','Nota') !!}
                            {!! Form::textarea('nota',null,['id'=>'nota','class'=>'form-control','rows'=>'3']) !!}
                            {!! Form::hidden('prg',null,['id'=>'prg']) !!}
                        </div>
                    {!! Form::close() !!}
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</a>
                                <a class="btn btn-sm btn-success" id="btn-ok-seguimiento">Guardar</a>
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
    <script type="text/javascript" src="{{asset('/js/programacion/programacion.js')}}"></script>
@endsection