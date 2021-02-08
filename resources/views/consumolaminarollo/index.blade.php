@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SGCL-FC02 - LÁMINA EN PLANCHAS- METALMECÁNICA</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-consumolaminarollos'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('inventario/consumomaterial/laminarollo/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
        </div>
        <div class="">
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>Consecutivo rollo</th>
                    <th>Maquina</th>
                    <th>Material</th>
                    <th>Espesor</th>
                    <th>Orden de compra</th>
                    <th>N° identidicación rollo</th>
                    <th>Fecha</th>
                    <th>Proyecto</th>
                    <th>N° de fabricación</th>
                    <th>Calculo</th>
                    <th>Fert</th>
                    <th>Cantidad</th>
                    <th>Ancho rollo</th>
                    <th>Medida</th>
                    <th>Peso Und plancha cort</th>
                    <th>Peso total plancha cort</th>
                    <th>Maquina destino</th>
                    <th>Operario corta</th>
                    <th>Operario recibe</th>
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
                {data: 'consecutivo_rollo', name: 'consecutivo_rollo'},
                {data: 'maquina', name: 'maquina'},
                {data: 'material', name: 'material'},
                {data: 'espesor', name: 'espesor'},
                {data: 'orden_compra', name: 'orden_compra'},
                {data: 'no_identificacion_rollo', name: 'no_identificacion_rollo'},
                {data: 'fecha', name: 'fecha'},
                {data: 'proyecto', name: 'proyecto'},
                {data: 'no_fabricacion', name: 'no_fabricacion'},
                {data: 'calculo', name: 'calculo'},
                {data: 'fert', name: 'fert'},
                {data: 'cantidad', name: 'cantidad'},
                {data: 'ancho_rollo', name: 'ancho_rollo'},
                {data: 'medida', name: 'medida'},
                {data: '', name: ''},
                {data: '', name: ''},
                {data: 'maquina_destino', name: 'maquina_destino'},
                {data: 'quien_corta', name: 'quien_corta'},
                {data: 'quien_recibe', name: 'quien_recibe'},
                {data: 'observacion', name: 'observacion'},
                {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
            ];

            tabla = $('#tabla').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: "{{url('inventario/consumomaterial/laminarollo-lista')}}",
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