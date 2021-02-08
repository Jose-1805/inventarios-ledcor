<?php
        if(!isset($modulo))$modulo = new \InventariosLedcor\Models\Modulo();
?>
<div class="row">
        <div class="form-group col-md-6">
            {!! Form::label('nombre','Nombre') !!}
            {!! Form::text('nombre',$modulo->nombre,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre para identificar el módulo (no editable)']) !!}
            {!! Form::hidden('modulo',$modulo->id,['id'=>'modulo']) !!}
        </div>
        <div class="form-group col-md-6">
            <?php
                $disabled = '';
                if($modulo->exists)
                    $disabled = 'disabled';
            ?>
            {!! Form::label('identificador','Identificador') !!}
            {!! Form::text('identificador',$modulo->identificador,['id'=>'identificador','class'=>'form-control num-int-positivo','placeholder'=>'Número entero para identificar el módulo (no editable)',$disabled]) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('etiqueta','Etiqueta') !!}
            {!! Form::text('etiqueta',$modulo->etiqueta,['id'=>'etiqueta','class'=>'form-control','placeholder'=>'Texto para mostrar en la interfaz gráfica']) !!}
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('url','Url') !!}
            <div class="input-group">
                <div class="input-group-addon">{{url('/')}}</div>
                {!! Form::text('url',$modulo->url,['id'=>'url','class'=>'form-control','placeholder'=>'/ejemplo-url']) !!}
            </div>
        </div>
        <div class="form-group col-md-6">
            {!! Form::label('estado','Estado') !!}
            {!! Form::select('estado',['Activo'=>'Activo','Inactivo'=>'Inactivo'],$modulo->estado,['id'=>'estado','class'=>'form-control']) !!}
        </div>
</div>