@php
    $disabled_linea = false;
    if($model->exists)$disabled_linea = 'disabled';
@endphp
{!! Form::hidden('confirmar_precedencia','no',['id'=>'confirmar_precedencia']) !!}
<div class="form-group col-md-4">
    {!! Form::label('linea','Linea') !!}
    {!! Form::select('linea',['LDT'=>'LDT','MDT'=>'MDT','SDT'=>'SDT','Adicionales'=>'Adicionales','Mecanizados'=>'Mecanizados','Daño de máquina'=>'Daño de máquina'],null,['id'=>'linea','class'=>'form-control','disabled'=>$disabled_linea]) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('tipo_item','Tipo Item') !!}
    {!! Form::select('tipo_item',['Corte'=>'Corte','Radiadores'=>'Radiadores','Adicionales'=>'Adicionales','Mecanizados'=>'Mecanizados'],null,['id'=>'tipo_item','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('subensamble','Subensamble') !!}
    {!! Form::select('subensamble',['Tanque'=>'Tanque','Prensa'=>'Prensa','Perfileria'=>'Perfileria','Adicional'=>'Adicional','Mecanizado'=>'Mecanizado','Rad MZ'=>'Rad MZ','Rad TB'=>'Rad TB','Daño de máquina'=>'Daño de máquina'],null,['id'=>'subensamble','class'=>'form-control','disabled'=>$disabled_linea]) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('tipo_tk','Tipo Tk') !!}
    {!! Form::select('tipo_tk',['MON'=>'MON','PM'=>'PM','TRI'=>'TRI','TRI ESP'=>'TRI ESP','PERF'=>'PERF','PRENSA'=>'PRENSA','ADIC'=>'ADIC','MEC'=>'MEC'],null,['id'=>'tipo_tk','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('no_preliminar_inicial','No Preliminar Inicial') !!}
    {!! Form::text('no_preliminar_inicial',null,['id'=>'no_preliminar_inicial','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('no_preliminar_final','No Preliminar Final') !!}
    {!! Form::text('no_preliminar_final',null,['id'=>'no_preliminar_final','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('no_fabricacion_inicial','N° fabricación inicial') !!}
    {!! Form::text('no_fabricacion_inicial',null,['id'=>'no_fabricacion_inicial','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('no_fabricacion_final','N° fabricación final') !!}
    {!! Form::text('no_fabricacion_final',null,['id'=>'no_fabricacion_final','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('calculo_fert','Calculo FERT') !!}
    {!! Form::text('calculo_fert',null,['id'=>'calculo_fert','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('orden_fabricacion_trafo','Orden Fabricacion Trafo') !!}
    {!! Form::text('orden_fabricacion_trafo',null,['id'=>'orden_fabricacion_trafo','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('cantidad_tk','Cantidad Tk') !!}
    {!! Form::number('cantidad_tk',null,['id'=>'cantidad_tk','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('proyecto','Proyecto') !!}
    {!! Form::select('proyecto',$proyectos,$model->proyecto_id,['id'=>'proyecto','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('KVA','KVA') !!}
    {!! Form::number('KVA',null,['id'=>'KVA','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('estado','Estado') !!}
    {!! Form::select('estado',$estados,$model->estado_id,['id'=>'estado','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('progreso','Progreso (%)') !!}
    {!! Form::number('progreso',null,['id'=>'progreso','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4">
    {!! Form::label('proveedor','Solicitado por') !!}
    {!! Form::select('proveedor',$proveedores,$model->proveedor_id,['id'=>'proveedor','class'=>'form-control']) !!}
</div>

<div class="form-group col-md-4 margin-top-30">
    {!! Form::label('reproceso','Reproceso') !!}
    <input type="checkbox" name="reproceso" value="si" @if($model->reproceso == 'si') checked @endif>
</div>