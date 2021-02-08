@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">PROVEEDORES - EDITAR REGISTRO</p>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-editar-proveedor'])
            </div>
            {!! Form::model($proveedor,['id'=>'form-editar-proveedor']) !!}
                {!! Form::hidden('id',$proveedor->id,['id'=>'id']) !!}
                @include('proveedor.form')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/proveedor/editar.js')}}"></script>
@stop