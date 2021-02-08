@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SOLICITUD DE MATERIALES - ENVIAR CORREO</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-mail'])
        </div>
        <div class="">
            {!! Form::open(['id'=>'form-mail']) !!}
                <div class="row">
                    {!! Form::hidden('solicitud',$solicitud->id) !!}
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('para','Para') !!}
                            {!! Form::text('para',config('params.emails.para'),['id'=>'para','class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('cc','CC') !!}
                            {!! Form::text('cc',config('params.emails.cc'),['id'=>'cc','class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('asunto','Asunto') !!}
                            {!! Form::text('asunto','Solicitud de Materiales No '.$solicitud->numero.' - '.$solicitud->fecha,['id'=>'asunto','class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-8">
                        {!! Form::label('contenido','Contenido') !!}
                        <div style="" class="table-bordered padding-10">
                            @include('solicitudmaterial.contenido_mail',['materiales'=>$materiales,'solicitud'=>$solicitud])
                        </div>
                    </div>
                </div>

                <div class="form-group col-xs-12 text-right no-padding">
                    <a href="#!" class="btn btn-success btn-submit" id="btn-guardar-mail">
                        <i class="fa fa-send"></i> Enviar
                    </a>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('js')
    @parent
    <script type="text/javascript" src="{{asset('/js/solicitud_material/mail.js')}}"></script>
@endsection