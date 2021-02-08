@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">USUARIOS - NUEVO REGISTRO</p>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-nuevo-usuario'])
            </div>
            {!! Form::open(['id'=>'form-crear-usuario']) !!}
                @include('usuario.form')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/usuario/crear.js')}}"></script>

    <script>
        $(function () {
            $("#imagen").fileinput(
                {
                    previewSettings: {
                        image:{width:"auto", height:"160px"},
                    },
                    allowedFileTypes:['image'],
                    AllowedFileExtensions:['jpg','jpeg','png'],
                    removeFromPreviewOnError:true,
                    showCaption: false,
                    showUpload: false,
                    showClose:false,
                    maxFileSize : 500,
                }
            );
        })
    </script>
@stop


