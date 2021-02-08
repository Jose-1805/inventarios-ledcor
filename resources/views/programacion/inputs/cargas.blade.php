<div class="col-xs-12">
    @include('layouts.alertas',['id_contenedor'=>'alertas-anexos'])
</div>
<div class="col-md-6">
    {!! Form::open(['id'=>'form_archivos']) !!}
        {!! Form::hidden('programacion',$model->id,['id'=>'programacion']) !!}
        <div class="form-group">
            {!! Form::label('archivo','Archivo') !!}
            {!! Form::file('archivo',null,['id'=>'archivo']) !!}
        </div>
        <a href="#!" class="btn btn-success" id="btn-save-anexo">Guardar</a>
    {!! Form::close() !!}
</div>
<div class="col-md-6 table-bordered padding-10">
    <p class="titulo_secundario">Archivos anéxos</p>
    <div id="archivos_anexos"></div>
</div>

