@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SGCL-FC13 - CONTROL DE INGRESO DE LÁMINA EN ROLLO</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-inventariolaminarollos'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('inventario/ingresomaterial/laminarollo/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
        </div>
        <div class="">
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>Fecha recibido</th>
                    <th>Peso del rollo</th>
                    <th>Lote</th>
                    <th>N° de identificación del rollo</th>
                    <th>Fecha del rollo</th>
                    <th>Ancho del rollo</th>
                    <th>Proveedor</th>
                    <th>Norma</th>
                    <th>Orden de compra</th>
                    <th>Operario</th>
                    <th>Observación</th>
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
                {data: 'fecha_recibido', name: 'fecha_recibido'},
                {data: 'peso_validado', name: 'peso_validado'},
                {data: 'lote', name: 'lote'},
                {data: 'no_identificacion_rollo', name: 'no_identificacion_rollo'},
                {data: 'fecha_rollo', name: 'fecha_rollo'},
                {data: 'ancho_rollo', name: 'ancho_rollo'},
                {data: 'proveedor', name: 'proveedor'},
                {data: 'norma', name: 'norma'},
                {data: 'orden_compra', name: 'orden_compra'},
                {data: 'operario', name: 'operario'},
                {data: 'observacion', name: 'observacion'},
                {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
            ];

            tabla = $('#tabla').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: "{{url('inventario/ingresomaterial/laminarollo-lista')}}",
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