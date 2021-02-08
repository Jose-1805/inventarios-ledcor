@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SGCL-FC11 - INGRESO DE LÁMINA</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-inventariolamina'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('inventario/ingresomaterial/lamina/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
        </div>
        <div class="">
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Material</th>
                    <th>Consecutivo lámina</th>
                    <th>Espesor lote</th>
                    <th>Peso lámina</th>
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
                {data: 'material', name: 'material'},
                {data: 'consecutivo_lamina', name: 'consecutivo_lamina'},
                {data: 'espesor_lote', name: 'espesor_lote'},
                {data: 'peso_lamina_validado', name: 'peso_lamina_validado'},
                {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
            ];

            tabla = $('#tabla').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: "{{url('inventario/ingresomaterial/lamina-lista')}}",
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