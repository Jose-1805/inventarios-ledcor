@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SGCL-FC18 RECEPCIÓN DE LÁMINA ANTES DE PROCESAR</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-laminaantesprocesars'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('inventario/ingresomaterial/laminaantesprocesar/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
        </div>
        <div class="">
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>Fecha recibido</th>
                    <th>Cantidad (láminas)</th>
                    <th>Descripción del material</th>
                    <th>Espesor (mm)</th>
                    <th>Peso por lámina</th>
                    <th>Orden de compra</th>
                    <th>Lote</th>
                    <th>Peso guacal</th>
                    <th>Operario</th>
                    <th>Observaciones</th>
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
                {data: 'cantidad', name: 'cantidad'},
                {data: 'texto_breve', name: 'texto_breve'},
                {data: 'espesor_mm', name: 'espesor_mm'},
                {data: 'peso_por_lamina', name: 'peso_por_lamina'},
                {data: 'orden_compra', name: 'orden_compra'},
                {data: 'lote', name: 'lote'},
                {data: 'peso_guacal', name: 'peso_guacal'},
                {data: 'operario', name: 'operario'},
                {data: 'observacion', name: 'observacion'},
                {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
            ];

            tabla = $('#tabla').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: "{{url('inventario/ingresomaterial/laminaantesprocesar-lista')}}",
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