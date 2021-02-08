<div class="row">
<?php
    if(!isset($detalle))$detalle = new InventariosLedcor\Models\SolicitudMaterial();
    $familias = \InventariosLedcor\Models\Material::select('familia')->orderBy('familia')->groupBy('familia')->pluck('familia','familia')->toArray();
?>

{!! Form::model($detalle,['id'=>'form-solicitudmaterial','class'=>'no_submit']) !!}

    {!! Form::hidden('id',$detalle->id) !!}
    {!! Form::hidden('solicitud',$solicitud->id) !!}

    <div class="form-group col-md-4">
        {!! Form::label('familia','Familia') !!}
        {!! Form::select('familia',$familias,null,['id'=>'familia','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-4">
        {!! Form::label('material','Material') !!}
        <div id="contenedor-select-material">
            {!! Form::select('material',['Seleccione un material'],null,['id'=>'material','class'=>'form-control']) !!}
        </div>
    </div>

    <div class="form-group col-md-4">
        {!! Form::label('um','Unidad solicitud') !!}
        {!! Form::select('um',['Kg'=>'Kg','m'=>'m'],$detalle->um,['id'=>'um','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-4">
        {!! Form::label('cantidad','Cantidad') !!}
        {!! Form::number('cantidad',null,['id'=>'cantidad','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-md-4">
        {!! Form::label('lote','Lote') !!}
        {!! Form::text('lote',null,['id'=>'lote','class'=>'form-control']) !!}
    </div>

    <div class="form-group col-xs-12">
        {!! Form::label('observaciones','Observaciones') !!}
        {!! Form::textarea('observaciones',null,['id'=>'observaciones','class'=>'form-control','rows'=>'3']) !!}
    </div>

    <div class="form-group col-xs-12 text-right">
        <a class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</a>
        <a href="#!" class="btn btn-success btn-submit" id="btn-guardar-material">
            <i class="fa fa-save"></i> Guardar
        </a>
    </div>
{!! Form::close() !!}
</div>
<script>
    $(function () {
        $('#familia').change();
    })
</script>