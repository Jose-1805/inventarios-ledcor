<?php
    $rol = null;
    if(isset($usuario) && $usuario->exists)
        $rol = $usuario->rol->id;
?>
<div class="col-xs-12 no-padding">

    <div class="col-md-3">
        <p class="titulo_secundario">Imagen (foto)</p>
        <input id="imagen" name="imagen" type="file" class="file-loading">
    </div>

    <div class="col-md-9">
        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('tipo_identificacion','Tipo de identificación (*)') !!}
            {!! Form::select('tipo_identificacion',['C.C'=>'C.C','NIT'=>'NIT'],null,['id'=>'tipo_identificacion','class'=>'form-control']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('identificacion','No. de identificación (*)') !!}
            {!! Form::text('identificacion',null,['id'=>'identificacion','class'=>'form-control','maxlength'=>'15']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('nombres','Nombres (*)',['class'=>'control-label']) !!}
            {!! Form::text('nombres',null,['id'=>'nombres','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese unicamente letras']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('apellidos','Apellidos (*)',['class'=>'control-label']) !!}
            {!! Form::text('apellidos',null,['id'=>'apellidos','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese unicamente letras']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('email','Correo electrónico (*)') !!}
            {!! Form::text('email',null,['id'=>'email','class'=>'form-control']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group datepicker">
            {!! Form::label('fecha_ingreso','Fecha de ingreso (*)') !!}
            @if(isset($usuario))
                <input type="date" name="fecha_ingreso" id="fecha_ingreso"class="form-control" value="{{$usuario->fecha_ingreso}}">
            @else
                <input type="date" name="fecha_ingreso" id="fecha_ingreso"class="form-control" >
            @endif
        </div>

        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('funcion','Funcion (*)') !!}
            {!! Form::select('funcion',['corte'=>'Corte','tubos'=>'Tubos','radiadores'=>'Radiadores'],null,['id'=>'funcion','class'=>'form-control']) !!}
        </div>

        <div class="col-xs-12 margin-top-40">
            <a href="#!" class="cursor_pointer btn-submit btn btn-primary right" id="btn-guardar-usuario">Guardar</a>
        </div>
    </div>

</div>