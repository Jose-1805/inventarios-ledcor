@extends('layouts.app')

@section('content')
    <div class="container white padding-50">
        <div class="row">
            <p class="titulo_principal margin-bottom-20">PROYECTOS</p>

            <div class="contenedor-opciones-vista">
                @if(Auth::user()->tieneFuncion(6, 1, $privilegio_superadministrador))
                    <a href="{{url('/proyecto/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
                @endif
            </div>

            <div class="col-xs-12">
                @include('layouts.alertas',['id_contenedor'=>'alertas-proyecto'])
            </div>

            <table id="tabla-proyectos" class="table-hover">
                <thead>
                <th>Nombre</th>
                <th>Cliente</th>
                <th>Fecha inicio</th>
                @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones(6,[2,3],false,$privilegio_superadministrador))
                    <th class="text-center">Opciones</th>
                @endif
                </thead>
            </table>
        </div>
    </div>

    <div id="modal-eliimnar-proyecto" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mySmallModalLabel">Eliminar</h4>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro de eliminar este proyecto?</p>
                    <div class="row text-right">
                        <div class="col-xs-12">
                            <a class="btn btn-sm btn-primary" data-dismiss="modal">No</a>
                            <a class="btn btn-sm btn-danger" id="btn-action-eliminar-proyecto">Si</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent
    <script src="{{asset('/js/proyecto/index.js')}}"></script>
    <script>
        var tiene_opciones = false;

        @if(\Illuminate\Support\Facades\Auth::user()->tieneFunciones(6,[2,3],false,$privilegio_superadministrador))
            tiene_opciones = true;
        @endif

        $(function () {
            var tabla_proyectos = $('#tabla-proyectos').dataTable({ "destroy": true });
            tabla_proyectos.fnDestroy();
            $.fn.dataTable.ext.errMode = 'none';
            $('#tabla-proyectos').on('error.dt', function(e, settings, techNote, message) {
                console.log( 'DATATABLES ERROR: ', message);
            })

            if(tiene_opciones){
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'cliente', name: 'cliente'},
                    {data: 'fecha_inicio', name: 'fecha_inicio'},
                    {data: 'opciones', name: 'opciones', orderable: false, searchable: false,"className": "text-center"}
                ];
            }else{
                var cols = [
                    {data: 'nombre', name: 'nombre'},
                    {data: 'cliente', name: 'cliente'},
                    {data: 'fecha_inicio', name: 'fecha_inicio'},
                ]
            }

            tabla_proyectos = $('#tabla-proyectos').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: $("#general_url").val()+"/proyecto/lista",
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


