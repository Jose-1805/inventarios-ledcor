@extends('layouts.app')

@section('content')

    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">DETALLE DE SOLICITUD DE MATERIALES</p>
            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-solicitudmaterials'])
            </div>
            <div class="">
                {!! Form::hidden('solicitud_id',$solicitud->id,['id'=>'solicitud_id']) !!}
                <div class="row">
                    <div class="form-group col-md-3 col-md-offset-6 col-lg-2 col-lg-offset-8 text-right">
                        <strong>Número de solicitud</strong>
                        <p class="font-x-large">{{$solicitud->numero}}</p>
                    </div>
                    <div class="form-group col-md-3 col-lg-2 text-right">
                        <strong>Fecha de solicitud</strong>
                        <p class="font-x-large">{{$solicitud->fecha}}</p>
                    </div>
                </div>
                <table class="table table-hover dataTable" id="tabla">
                    <thead>
                    <tr>
                        <th>Material</th>
                        <th>Cantidad</th>
                        <th>Unidad solicitud</th>
                        <th>Cantidad entregada</th>
                        <th>Lote</th>
                        <th>Observaciones</th>
                        <th style="min-width: 120px;text-align: center !important;">Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div class="text-right">
                    <a class="btn btn-primary" id="btn-nuevo-material"><i class="fa fa-save"></i> Nuevo material</a>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-material" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Material</h4>
                </div>
                <div class="modal-body">
                    <div class="col-xs-12">
                        @include('layouts.alertas',['id_contenedor'=>'alertas-material'])
                    </div>
                    <div id="contenedor-form-material"></div>
                </div>
            </div>
        </div>
    </div>



    <div id="modal-detalle-cantidad" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Cantidad entregada</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            @include('layouts.alertas',['id_contenedor'=>'alertas-detalle-cantidad'])
                        </div>
                        <div class="col-xs-12">
                            {!! Form::text('cantidad_entregada',null,['id'=>'cantidad_entregada','class'=>'form-control']) !!}
                        </div>
                        <div class="col-xs-12 text-right margin-top-10">
                            <a class="btn btn-success" id="btn-ok-cantidad-detalle">Guardar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{asset('/js/solicitud_material/detalle.js')}}"></script>
@endsection