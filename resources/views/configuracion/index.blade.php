@extends('layouts.app')

@section('css')
    @parent

    <link href="{{asset('css/configuracion.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">CONFIGURACIONES</p>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-configuraciones'])
            </div>

            <a class="opcion-configuracion col-xs-6 col-sm-4 col-md-3 col-lg-2" href="#!" data-toggle="modal" data-target="#modal-contrasena">
                <div class="col-xs-12 text-center padding-bottom-10 padding-top-10">
                    <i class="fa fa-unlock-alt fa-3x" style="padding-bottom: 4px;"></i>
                </div>
                <p class="text-center col-xs-12 truncate no-padding">Contraseña</p>
            </a>
        </div>
    </div>

    @include('configuracion.modales')
@endsection

@section('js')
    @parent
    <script src="{{asset('js/configuracion/index.js')}}"></script>
@stop