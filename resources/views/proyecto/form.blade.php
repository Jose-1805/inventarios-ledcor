<?php
        $clientes = \InventariosLedcor\Models\Cliente::orderBy('nombre')->pluck('nombre','id');
        if(!isset($proyecto))$proyecto = new \InventariosLedcor\Models\Proyecto();
?>
<div class="col-xs-12 no-padding">

        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('nombre','Nombre (*)',['class'=>'control-label']) !!}
            {!! Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese unicamente letras']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
                {!! Form::label('cliente','Cliente (*)') !!}
                {!! Form::select('cliente',$clientes,$proyecto->cliente_id,['id'=>'cliente','class'=>'form-control']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group datepicker">
                {!! Form::label('fecha_inicio','Fecha de inicio (*)') !!}
                @if(isset($proyecto->exists))
                        <input type="date" name="fecha_inicio" id="fecha_inicio"class="form-control" value="{{$proyecto->fecha_inicio}}">
                @else
                        <input type="date" name="fecha_inicio" id="fecha_inicio"class="form-control" >
                @endif
        </div>

        <div class="col-xs-12 margin-top-40">
            <a href="#!" class="cursor_pointer btn-submit btn btn-primary right" id="btn-guardar-proyecto">Guardar</a>
        </div>

</div>