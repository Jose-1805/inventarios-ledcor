<?php
        $clientes = \InventariosLedcor\Models\Cliente::orderBy('nombre')->pluck('nombre','id');
        $proyectos = \InventariosLedcor\Models\Proyecto::orderBy('nombre')->pluck('nombre','id');
        if(!isset($orden_compra))$orden_compra = new \InventariosLedcor\Models\OrdenCompra();
?>
<div class="col-xs-12 no-padding">
        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('numero','Número (*)',['class'=>'control-label']) !!}
            {!! Form::text('numero',null,['id'=>'numero','class'=>'form-control','maxlength'=>50,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese unicamente letras']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
                {!! Form::label('cliente','Cliente (*)') !!}
                {!! Form::select('cliente',$clientes,$orden_compra->cliente_id,['id'=>'cliente','class'=>'form-control']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
                {!! Form::label('proyecto','Proyecto (*)') !!}
                {!! Form::select('proyecto',$proyectos,$orden_compra->proyecto_id,['id'=>'proyecto','class'=>'form-control']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group datepicker">
                {!! Form::label('fecha','Fecha(*)') !!}
                @if(isset($orden_compra->exists))
                        <input type="date" name="fecha" id="fecha"class="form-control" value="{{$orden_compra->fecha}}">
                @else
                        <input type="date" name="fecha" id="fecha"class="form-control" >
                @endif
        </div>

        <div class="col-md-6 col-lg-4 form-group">
                {!! Form::label('posicion','Posicion (*)',['class'=>'control-label']) !!}
                {!! Form::text('posicion',null,['id'=>'posicion','class'=>'form-control']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
                {!! Form::label('codigo_mecanizado','Código mecanizado (*)',['class'=>'control-label']) !!}
                {!! Form::text('codigo_mecanizado',null,['id'=>'codigo_mecanizado','class'=>'form-control']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
                {!! Form::label('descripcion','Descripción (*)',['class'=>'control-label']) !!}
                {!! Form::text('descripcion',null,['id'=>'descripcion','class'=>'form-control']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
                {!! Form::label('cantidad_requerida','Cantidad requerida (*)',['class'=>'control-label']) !!}
                {!! Form::text('cantidad_requerida',null,['id'=>'cantidad_requerida','class'=>'form-control']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
                {!! Form::label('fecha_entrega_requerida','Fecha de entrega requerida (*)',['class'=>'control-label']) !!}
                {!! Form::date('fecha_entrega_requerida',null,['id'=>'fecha_entrega_requerida','class'=>'form-control']) !!}
        </div>

        <div class="col-xs-12 form-group">
                {!! Form::label('observacion','Observación)',['class'=>'control-label']) !!}
                {!! Form::textarea('observacion',null,['id'=>'observacion','class'=>'form-control','rows'=>'3']) !!}
        </div>


        <div class="col-xs-12 margin-top-40">
            <a href="#!" class="cursor_pointer btn-submit btn btn-primary right" id="btn-guardar-orden-compra">Guardar</a>
        </div>

</div>