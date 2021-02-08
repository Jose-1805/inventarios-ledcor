@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">CLIENTES - EDITAR REGISTRO</p>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-editar-cliente'])
            </div>
            {!! Form::model($cliente,['id'=>'form-editar-cliente']) !!}
                {!! Form::hidden('id',$cliente->id,['id'=>'id']) !!}
                @include('cliente.form')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/cliente/editar.js')}}"></script>
@stop