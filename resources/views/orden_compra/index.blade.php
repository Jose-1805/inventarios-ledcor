@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">ORDENES DE COMPRA</p>

            <div class="contenedor-opciones-vista">
                @if(Auth::user()->tieneFuncion(7, 1, $privilegio_superadministrador))
                    <a href="{{url('/orden-compra/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                @endif
            </div>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-orden-compra'])
            </div>

            <table id="tabla-ordenes-compras" class="table-hover">
                <thead>
                <th>N° Orden de compra</th>
                <th>Fecha OC</th>
                <th>Posición</th>
                <th>Código mecanizado</th>
                <th>Descripción</th>
                <th>Cantidad requerida</th>
                <th>Fecha entrega requerida</th>
                <th>Observación</th>
                @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones(7,[2,3],false,$privilegio_superadministrador))
                    <th class="text-center">Opciones</th>
                @endif
                </thead>
            </table>
        </div>
    </div>

    <div id="modal-eliimnar-orden-compra" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Eliminar</h4>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar esta orden de compra?</p>
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-sm btn-primary" data-dismiss="modal">No</a>
                            <a class="btn btn-sm btn-danger" id="btn-action-eliminar-orden-compra">Si</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('/js/orden_compra/index.js')}}"></script>
    <script>
        var tiene_opciones = false;

        @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones(7,[2,3],false,$privilegio_superadministrador))
            tiene_opciones = true;
        @endif

        $(function () {
            var tabla_ordenes_compras = $('#tabla-ordenes-compras').dataTable({ "destroy": true });
            tabla_ordenes_compras.fnDestroy();
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabla-ordenes-compras').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'DATATABLES ERROR: ', message);
            })

            if(tiene_opciones){
                var cols = [
                    {data: 'numero', name: 'numero'},
                    {data: 'fecha', name: 'fecha'},
                    {data: 'posicion', name: 'posicion'},
                    {data: 'codigo_mecanizado', name: 'codigo_mecanizado'},
                    {data: 'descripcion', name: 'descripcion'},
                    {data: 'cantidad_requerida', name: 'cantidad_requerida'},
                    {data: 'fecha_entrega_requerida', name: 'fecha_entrega_requerida'},
                    {data: 'observacion', name: 'observacion'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'numero', name: 'numero'},
                    {data: 'fecha', name: 'fecha'},
                    {data: 'posicion', name: 'posicion'},
                    {data: 'codigo_mecanizado', name: 'codigo_mecanizado'},
                    {data: 'descripcion', name: 'descripcion'},
                    {data: 'cantidad_requerida', name: 'cantidad_requerida'},
                    {data: 'fecha_entrega_requerida', name: 'fecha_entrega_requerida'},
                    {data: 'observacion', name: 'observacion'},
                ]
            }

            tabla_ordenes_compras = $('#tabla-ordenes-compras').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: $("#general_url").val()+"/orden-compra/lista",
                columns: cols,
                fnRowCallback: function (nRow, aData, iDisplayIndex) {
                    $(nRow).attr('id','row_'+aData.id);
                    setTimeout(function () {
                    },300);
                },
            });
        })
    </script>
@stop


