<div class="form-group col-md-4">
    {!! Form::label('baterias_tk','Baterias Tk') !!}
    {!! Form::number('baterias_tk',null,['id'=>'baterias_tk','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('no_elem','N° Elemento') !!}
    {!! Form::number('no_elem',null,['id'=>'no_elem','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('ancho_rad','Ancho Rad') !!}
    {!! Form::select('ancho_rad',['326'=>'326','52'=>'52'],null,['id'=>'ancho_rad','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('longitud_rad','Longitud Rad') !!}
    {!! Form::number('longitud_rad',null,['id'=>'longitud_rad','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('peso_teorico_prensas','Peso teorico prensas') !!}
    {!! Form::text('peso_teorico_prensas',null,['id'=>'peso_teorico_prensas','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('peso_teorico_tk','Peso teorico Tk') !!}
    {!! Form::text('peso_teorico_tk',null,['id'=>'peso_teorico_tk','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('peso_teorico_cajas','Peso teorico cajas') !!}
    {!! Form::text('peso_teorico_cajas',null,['id'=>'peso_teorico_cajas','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('peso_teorico_radiadores','Peso teorico radiadores') !!}
    {!! Form::text('peso_teorico_radiadores',null,['id'=>'peso_teorico_radiadores','class'=>'form-control']) !!}
</div>