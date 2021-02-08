@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">PROVEEDORES</p>

            <div class="contenedor-opciones-vista">
                @if(Auth::user()->tieneFuncion(8, 1, $privilegio_superadministrador))
                    <a href="{{url('/proveedor/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                @endif
            </div>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-proveedor'])
            </div>

            <table id="tabla-proveedores" class="table-hover">
                <thead>
                <th>Nombre</th>
                <th>Alias</th>
                <th>Dirección</th>
                @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones(8,[2,3],false,$privilegio_superadministrador))
                    <th class="text-center">Opciones</th>
                @endif
                </thead>
            </table>
        </div>
    </div>

    <div id="modal-eliimnar-proveedor" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Eliminar</h4>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar este proveedor?</p>
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-sm btn-primary" data-dismiss="modal">No</a>
                            <a class="btn btn-sm btn-danger" id="btn-action-eliminar-proveedor">Si</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('/js/proveedor/index.js')}}"></script>
    <script>
        var tiene_opciones = false;

        @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones(8,[2,3],false,$privilegio_superadministrador))
            tiene_opciones = true;
        @endif

        $(function () {
            var tabla_proveedores = $('#tabla-proveedores').dataTable({ "destroy": true });
            tabla_proveedores.fnDestroy();
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabla-proveedores').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'DATATABLES ERROR: ', message);
            })

            if(tiene_opciones){
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'alias', name: 'alias'},
                    {data: 'direccion', name: 'direccion'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'alias', name: 'alias'},
                    {data: 'direccion', name: 'direccion'},
                ]
            }

            tabla_proveedores = $('#tabla-proveedores').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: $("#general_url").val()+"/proveedor/lista",
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


