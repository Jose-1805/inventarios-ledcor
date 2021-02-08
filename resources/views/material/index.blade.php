@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">MATERIALES</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-materials'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('inventario/material/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
        </div>
        <div class="">
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>Familia</th>
                    <th>Unidad medida</th>
                    <th>Presentación</th>
                    <th>Codigo</th>
                    <th>Texto breve</th>
                    <th>Código plano</th>
                    <th>Valor unidad</th>
                    <th>Espesor mm</th>
                    <th>Unidad solicitud</th>
                    <th>Cantidad</th>
                    <th style="min-width: 120px;text-align: center !important;">Opciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection



@section('js')
    @parent
    <script type="text/javascript">
        var theGrid = null;
        $(function(){
            var tabla = $('#tabla').dataTable({ "destroy": true });
            tabla.fnDestroy();
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabla').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'DATATABLES ERROR: ', message);
            })

            var cols = [
                {data: 'familia', name: 'familia'},
                {data: 'unidad_medida', name: 'unidad_medida'},
                {data: 'presentacion', name: 'presentacion'},
                {data: 'codigo', name: 'codigo'},
                {data: 'texto_breve', name: 'texto_breve'},
                {data: 'codigo_plano', name: 'codigo_plano'},
                {data: 'valor_unidad', name: 'valor_unidad'},
                {data: 'espesor_mm', name: 'espesor_mm'},
                {data: 'unidad_solicitud', name: 'unidad_solicitud'},
                {data: 'cantidad', name: 'cantidad'},
                {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
            ];

            tabla = $('#tabla').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: "{{url('inventario/material-lista')}}",
                columns: cols,
                fnRowCallback: function (nRow, aData, iDisplayIndex) {
                    $(nRow).attr('id','row_'+aData.id);
                    setTimeout(function () {
                    },300);
                },
            });
        });
    </script>
@endsection