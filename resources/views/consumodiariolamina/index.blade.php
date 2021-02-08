@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SGCL-FC24 - CONTROL DIARIO CONSUMO DE LÀMINA</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-consumodiariolaminas'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('inventario/consumomaterial/lamina/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
        </div>
        <div class="">
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Consecutivo làmina</th>
                    <th>Espesor (mm)</th>
                    <th>Material</th>
                    <th>Tanque</th>
                    <th>Prensa</th>
                    <th>Calculo</th>
                    <th>Nª de fabricaciòn</th>
                    <th>Proyecto</th>
                    <th>Consumo KG</th>
                    <th>Desperdicio KG</th>
                    <th>Operario</th>
                    <th>Observaciòn</th>
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
                {data: 'fecha', name: 'fecha'},
                {data: 'consecutivo_lamina', name: 'consecutivo_lamina'},
                {data: 'espesor', name: 'espesor'},
                {data: 'material', name: 'material'},
                {data: 'peso_tanque', name: 'peso_tanque'},
                {data: 'peso_prensa', name: 'peso_prensa'},
                {data: 'calculo', name: 'calculo'},
                {data: 'no_fabricacion', name: 'no_fabricacion'},
                {data: 'proyecto', name: 'proyecto'},
                {data: 'consumo', name: 'consumo'},
                {data: 'desperdicio', name: 'desperdicio'},
                {data: 'operario', name: 'operario'},
                {data: 'observacion', name: 'observacion'},
                {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
            ];

            tabla = $('#tabla').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: "{{url('inventario/consumomaterial/lamina-lista')}}",
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