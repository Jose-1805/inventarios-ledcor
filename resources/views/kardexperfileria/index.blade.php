@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SGCL-FC22 - KARDEX PERFILERÍA</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-kardexperfileria'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('inventario/ingresomaterial/kardexperfileria/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
        </div>
        <div class="">
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>material</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Entrega A</th>
                    <th>Recibe A</th>
                    <th>Proveedor</th>
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
                {data: 'material', name: 'material'},
                {data: 'cantidad', name: 'cantidad'},
                {data: 'fecha', name: 'fecha'},
                {data: 'entrega_a', name: 'entrega_a'},
                {data: 'recibe_a', name: 'recibe_a'},
                {data: 'proveedor', name: 'proveedor'},
                {data: 'observacion', name: 'observacion'},
                {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
            ];

            tabla = $('#tabla').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: "{{url('inventario/ingresomaterial/kardexperfileria-lista')}}",
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