@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SGCL-FC01 - LISTADO Y VERIFICACIÓN DE CORTE METALMECÁNICA</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-cortes'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('/corte/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
            <a href="#!" id="btn-imprimir" type="button" class="btn btn-success btn-circle margin-top-10"><i class="fa fa-print font-large"></i></a>
        </div>
        <div class="">
            <div class="row">
                <div class="form-group col-md-4 col-lg-3 col-md-offset-9">
                    <label for="ensamble">Ensamble</label>
                    {!! Form::select('ensamble',[''=>'Seleccione un ensamble','Tanque'=>'Tanque','Prensa'=>'Prensa','Perfileria'=>'Perfileria','Adicional'=>'Adicional','Mecanizado'=>'Mecanizado','Rad MZ'=>'Rad MZ','Rad TB'=>'Rad TB','Daño de máquina'=>'Daño de máquina'],null,['id'=>'ensamble','class'=>'item-filtro form-control']) !!}
                </div>
            </div>
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>N° fabricación inicial</th>
                    <th>N° fabricación final</th>
                    <th>Ensamble</th>
                    <th>N° calculo</th>
                    <th>FERT</th>
                    <th>Cantidad Tk</th>
                    <th>Proyecto</th>
                    <th>Elaborado por</th>
                    <th>Peso tanque</th>
                    <th>Peso prensa</th>
                    <th>Peso caja/gabinete</th>
                    <th>Peso otros</th>
                    <th>Observación</th>
                    <th>Verificación de calidad</th>
                    <th>Selección</th>
                    <th style="min-width: 120px;text-align: center !important;">Opciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
    </div>

    <div id="modal-imprimir-documentos" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Imprimir documentos</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        @include('layouts.alertas',['id_contenedor'=>'alertas-imprimir-documentos'])
                    </div>
                    <div id="contenido-imprimir-documentos">

                    </div>
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-default" data-dismiss="modal">Cerrar</a>
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
    <script src="{{asset('js/corte/corte.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            cargarTablaCortes();
        });
    </script>
@endsection