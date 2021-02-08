@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">ORDENES DE COMPRA - NUEVO REGISTRO</p>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-nueva-orden-compra'])
            </div>
            {!! Form::open(['id'=>'form-crear-orden-compra']) !!}
                @include('orden_compra.form')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/orden_compra/crear.js')}}"></script>
@stop


