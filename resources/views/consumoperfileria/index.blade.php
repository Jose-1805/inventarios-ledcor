@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SGCL-FC19 - CONTROL DE PERFILERIA</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-consumoperfileria'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('inventario/consumomaterial/perfileria/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
        </div>
        <div class="">
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Calculo</th>
                    <th>N° de fabricación</th>
                    <th>Ensamble</th>
                    <th>Cantidad</th>
                    <th>Medida</th>
                    <th>Material</th>
                    <th>Entrego</th>
                    <th>Solicito</th>
                    <th>Cliente</th>
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
                {data: 'fecha', name: 'fecha'},
                {data: 'calculo', name: 'calculo'},
                {data: 'no_fabricacion', name: 'no_fabricacion'},
                {data: 'ensamble', name: 'ensamble'},
                {data: 'cantidad', name: 'cantidad'},
                {data: 'medida', name: 'medida'},
                {data: 'material', name: 'material'},
                {data: 'quien_entrego', name: 'quien_entrego'},
                {data: 'quien_solicito', name: 'quien_solicito'},
                {data: 'cliente', name: 'cliente'},
                {data: 'observacion', name: 'observacion'},
                {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
            ];

            tabla = $('#tabla').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: "{{url('inventario/consumomaterial/perfileria-lista')}}",
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