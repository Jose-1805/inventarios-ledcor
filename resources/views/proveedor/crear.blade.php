@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">PROVEEDORES - NUEVO REGISTRO</p>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-nuevo-proveedor'])
            </div>
            {!! Form::open(['id'=>'form-crear-proveedor']) !!}
                @include('proveedor.form')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/proveedor/crear.js')}}"></script>
@stop


