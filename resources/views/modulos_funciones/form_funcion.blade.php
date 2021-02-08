<?php
        if(!isset($funcion))$funcion = new \InventariosLedcor\Models\Funcion();
?>
<div class="row">
        <div class="form-group col-xs-12">
            {!! Form::label('nombre','Nombre') !!}
            {!! Form::text('nombre',$funcion->nombre,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre de la función']) !!}
            {!! Form::hidden('funcion',$funcion->id,['id'=>'funcion']) !!}
        </div>
        <div class="form-group col-xs-12">
            <?php
                    $disabled = '';
                    if($funcion->exists)
                        $disabled = 'disabled';
            ?>
            {!! Form::label('identificador','Identificador') !!}
            {!! Form::text('identificador',$funcion->identificador,['id'=>'identificador','class'=>'form-control num-int-positivo','placeholder'=>'Número entero para identificar la función (no editable)',$disabled]) !!}
        </div>
</div>