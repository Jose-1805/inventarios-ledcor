@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">ORDENES DE COMPRA - EDITAR REGISTRO</p>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-editar-orden-compra'])
            </div>
            {!! Form::model($orden_compra,['id'=>'form-editar-orden-compra']) !!}
                {!! Form::hidden('id',$orden_compra->id,['id'=>'id']) !!}
                @include('orden_compra.form')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/orden_compra/editar.js')}}"></script>
@stop