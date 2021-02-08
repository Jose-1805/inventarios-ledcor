@extends('layouts.app')

@section('content')

<div class="container white padding-50">
    <div class="row">
        <p class="titulo_principal margin-bottom-20">ESTADOS</p>
        <div class="col-xs-12">
            @include('layouts.alertas',['id_contenedor'=>'alertas-estados'])
        </div>
        <div class="contenedor-opciones-vista">
            <a href="{{url('estado/create')}}" type="button" class="btn btn-primary btn-circle"><i class="fa fa-plus"></i></a>
        </div>
        <div class="">
            <table class="table table-hover dataTable" id="tabla">
              <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precedencia</th>
                    <th>Linea</th>
                    <th>Tipo item</th>
                    <th>Subensamble</th>
                    <th>Tipo TK</th>
                    <th>Email</th>
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
                {data: 'nombre', name: 'nombre'},
                {data: 'precedencia', name: 'precedencia'},
                {data: 'linea', name: 'linea'},
                {data: 'tipo_item', name: 'tipo_item'},
                {data: 'subensamble', name: 'subensamble'},
                {data: 'tipo_tk', name: 'tipo_tk'},
                {data: 'email', name: 'email'},
                {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
            ];

            tabla = $('#tabla').DataTable({
                lenguage: idioma_tablas,
                processing: true,
                serverSide: true,
                ajax: "{{url('estado-lista')}}",
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