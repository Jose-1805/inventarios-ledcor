@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">PROYECTOS - EDITAR REGISTRO</p>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-editar-proyecto'])
            </div>
            {!! Form::model($proyecto,['id'=>'form-editar-proyecto']) !!}
                {!! Form::hidden('id',$proyecto->id,['id'=>'id']) !!}
                @include('proyecto.form')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/proyecto/editar.js')}}"></script>
@stop