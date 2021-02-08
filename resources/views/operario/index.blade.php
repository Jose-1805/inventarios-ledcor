@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">OPERARIOS</p>

            <div class="contenedor-opciones-vista">
                @if(Auth::user()->tieneFuncion(4, 1, $privilegio_superadministrador))
                    <a href="{{url('/operario/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                @endif
            </div>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-usuario'])
            </div>

            <table id="tabla-usuarios" class="table-hover">
                <thead>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Función</th>
                <th>Fecha ingreso</th>
                @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones(4,[2,3],false,$privilegio_superadministrador))
                    <th class="text-center">Opciones</th>
                @endif
                </thead>
            </table>
        </div>
    </div>

    <div id="modal-eliimnar-usuario" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Eliminar</h4>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar este operario?</p>
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-sm btn-primary" data-dismiss="modal">No</a>
                            <a class="btn btn-sm btn-danger" id="btn-action-eliminar-usuario">Si</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('/js/operario/index.js')}}"></script>
    <script>
        var tiene_opciones = false;

        @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones(4,[2,3],false,$privilegio_superadministrador))
            tiene_opciones = true;
        @endif

        $(function () {
            var tabla_usuarios = $('#tabla-usuarios').dataTable({ "destroy": true });
            tabla_usuarios.fnDestroy();
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabla-usuarios').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'DATATABLES ERROR: ', message);
            })

            if(tiene_opciones){
                var cols = [
                    {data: 'nombres', name: 'nombres'},
                    {data: 'apellidos', name: 'apellidos'},
                    {data: 'funcion', name: 'funcion'},
                    {data: 'fecha_ingreso', name: 'fecha_ingreso'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'nombres', name: 'nombres'},
                    {data: 'apellidos', name: 'apellidos'},
                    {data: 'funcion', name: 'funcion'},
                    {data: 'fecha_ingreso', name: 'fecha_ingreso'},
                ]
            }

            tabla_usuarios = $('#tabla-usuarios').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: $("#general_url").val()+"/operario/lista",
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


