@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">OPERARIOS - EDITAR REGISTRO</p>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-editar-usuario'])
            </div>
            {!! Form::model($usuario,['id'=>'form-editar-usuario']) !!}
                {!! Form::hidden('id',$usuario->id,['id'=>'id']) !!}
                @include('operario.form')
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('js/operario/editar.js')}}"></script>
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
                    initialPreview: [
                        @if($usuario->imagen)
                            "<img src='{{url('/archivo/'.str_replace('/','-',$usuario->imagen->ubicacion).'-'.$usuario->imagen->nombre)}}' class='col-xs-12'>",
                        @endif
                    ]
                }
            );
        })
    </script>
@stop