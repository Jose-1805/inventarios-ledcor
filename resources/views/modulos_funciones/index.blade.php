@extends('layouts.app')

@section('content')
        <div class="container white padding-50">
            <div class="row">
                <p class="titulo_principal margin-bottom-20">MÓDULOS Y FUNCIONES</p>

                <div class="col-md-6 no-padding" id="contenedor-modulos" style="min-height: 50px;">

                </div>

                <div class="col-md-4">
                    <div class="row" >
                        <div class="col-xs-12 ">
                            <div class="col-xs-12 no-padding" id="contenedor-funciones" style="min-height: 50px;">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <?php $disabled = ''; ?>
                    @if(!Auth::user()->tieneFuncion(1,1,$privilegio_superadministrador))
                            <?php $disabled = 'disabled'; ?>
                    @endif
                    <a class="btn btn-block btn-primary" data-toggle="modal" @if($disabled == '') data-target="#modal-nuevo-modulo" @endif{{$disabled}}>Nuevo Módulo</a>
                    <a class="btn btn-block btn-primary" data-toggle="modal" @if($disabled == '') data-target="#modal-nueva-funcion" @endif{{$disabled}}>Nueva Función</a>
                </div>
            </div>
        </div>

        @include('modulos_funciones.modales')
@endsection

@section('js')
    @parent
    <script src="{{asset('js/modulos_funciones/modulos_funciones.js')}}"></script>
@stop


