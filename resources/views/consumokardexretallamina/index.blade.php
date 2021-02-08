@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">SGCL-FC08 - KARDEX RETAL DE LÀMINA METALMECÁNICA</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-consumokardexretallaminas'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('inventario/consumomaterial/kardexretallamina/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
        </div>
        <div class="">
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Consecutivo lámina</th>
                    <th>Espesor</th>
                    <th>Tipo lámina</th>
                    <th>Cantidad</th>
                    <th>Largo</th>
                    <th>Ancho</th>
                    <th>Peso</th>
                    <th>¿Quien lo generó?</th>
                    <th>Fecha de ingreso</th>
                    <th>¿Quien lo gastó?</th>
                    <th>Forma retal</th>
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
                {data: 'tipo_lamina', name: 'tipo_lamina'},
                {data: 'cantidad', name: 'cantidad'},
                {data: 'largo', name: 'largo'},
                {data: 'ancho', name: 'ancho'},
                {data: 'peso', name: 'peso'},
                {data: 'quien_genero', name: 'quien_genero'},
                {data: 'fecha_ingreso', name: 'fecha_ingreso'},
                {data: 'quien_gasto', name: 'quien_gasto'},
                {data: 'forma_retal', name: 'forma_retal'},
                {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
            ];

            tabla = $('#tabla').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: "{{url('inventario/consumomaterial/kardexretallamina-lista')}}",
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