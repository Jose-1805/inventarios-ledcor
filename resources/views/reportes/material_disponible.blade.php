@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">REPORTE DE MATERIAL DISPONIBLE</p>
        <div class="">
            <div class="row">
                <div class="form-group col-md-4 col-lg-3 col-md-offset-6">
                    <label for="fecha_inicial">Fecha plan inicial</label>
                    {!! Form::date('fecha_inicial',null,['id'=>'fecha_inicial','class'=>'item-filtro form-control']) !!}
                </div>
                <div class="form-group col-md-4 col-lg-3">
                    <label for="fecha_final">Fecha plan final</label>
                    {!! Form::date('fecha_final',null,['id'=>'fecha_final','class'=>'item-filtro form-control']) !!}
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
</div>
@endsection



@section('js')
    @parent
    <script type="text/javascript" src="{{asset('/js/programacion/programacion.js')}}"></script>
@endsection