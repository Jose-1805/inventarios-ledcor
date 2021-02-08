var detalle_cantidad = null;
$(function () {
    cargarTablaDetalles();

    $('#btn-nuevo-material').click(function () {
        var params = {_token:$('#general_token').val(),solicitud:$('#solicitud_id').val()};
        var url = $('#general_url').val()+'/inventario/solicitudmaterial/form-detalle';
        abrirBlockUiCargando('Cargando ');
        $.post(url,params)
            .done(function (data) {
                $('#contenedor-form-material').html(data);
                cerrarBlockUiCargando();
                $('#modal-material').modal('show');
            })
    })

    $('body').on('click','#btn-guardar-material',function () {
        var params = $('#form-solicitudmaterial').serialize();
        var url = $('#general_url').val()+'/inventario/solicitudmaterial/save-detalle';
        abrirBlockUiCargando('Guardando ');
        $.post(url,params)
            .done(function (data){
                cerrarBlockUiCargando();
                $('#form-solicitudmaterial')[0].reset();
                $('#modal-material').modal('hide');
                cargarTablaDetalles();
            }).fail(function (jqXHR,state,error) {
                cerrarBlockUiCargando();
                abrirAlerta('alertas-material','danger',JSON.parse(jqXHR.responseText).errors,null,null);
            });
    })

    $('body').on('click','.btn-editar-detalle',function () {
        var detalle = $(this).data('detalle');
        var params = {_token:$('#general_token').val(),solicitud:$('#solicitud_id').val(),detalle:detalle};
        var url = $('#general_url').val()+'/inventario/solicitudmaterial/form-detalle';
        abrirBlockUiCargando('Cargando ');
        $.post(url,params)
            .done(function (data) {
                $('#contenedor-form-material').html(data);
                cerrarBlockUiCargando();
                $('#modal-material').modal('show');
            })
    })

    $('body').on('click','.btn-cantidad-detalle',function () {
        detalle_cantidad = $(this).data('detalle');
        $('#modal-detalle-cantidad').modal('show');
    })
    
    $('#btn-ok-cantidad-detalle').click(function () {
        if(detalle_cantidad){
            var params = {_token:$('#general_token').val(),cantidad:$('#cantidad_entregada').val(),detalle:detalle_cantidad};
            var url = $('#general_url').val()+'/inventario/solicitudmaterial/set-cantidad-entregada';
            
            abrirBlockUiCargando('Guardando ');
            $.post(url,params)
                .done(function (data) {
                    cerrarBlockUiCargando();
                    $('#modal-detalle-cantidad').modal('hide');
                    abrirAlerta('alertas-solicitudmaterials','success',['Cantidad actualizada con éxito'],null,null);
                    cargarTablaDetalles();
                })
                .fail(function (jqXHR,error,state) {
                    cerrarBlockUiCargando();
                    abrirAlerta('alertas-detalle-cantidad','danger',JSON.parse(jqXHR.responseText).errors,null,null);
                })
        }
    })

    $('body').on('change','#familia',function () {
        var params = {_token:$('#general_token').val(),familia:$(this).val(),name:'material'};
        var url = $('#general_url').val()+'/inventario/material-select-familia';
        $.post(url,params)
            .done(function (data) {
                $('#contenedor-select-material').html(data);
            })
    })
})

function cargarTablaDetalles(){
    var tabla = $('#tabla').dataTable({ "destroy": true });
    tabla.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    $('#tabla').on('preXhr.dt', function ( e, settings, data ) {
            data.solicitud = $('#solicitud_id').val();
        })

    var cols = [
        {data: 'material', name: 'material'},
        {data: 'cantidad', name: 'cantidad'},
        {data: 'um', name: 'um'},
        {data: 'cantidad_entregada', name: 'cantidad_entregada'},
        {data: 'lote', name: 'lote'},
        {data: 'observaciones', name: 'observaciones'},
        {data: 'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
    ];

    tabla = $('#tabla').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax:  $('#general_url').val()+'/inventario/solicitudmaterial-lista-detalle',
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            $(nRow).attr('id',''+aData.id);
            setTimeout(function () {
            },300);
        },
    });
}