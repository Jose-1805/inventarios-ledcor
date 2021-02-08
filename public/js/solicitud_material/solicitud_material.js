$(function () {

    $('body').on('change','.item-filtro',function () {
        cargarTablaSolicitudes();
    })

    cargarTablaSolicitudes();

    $('#btn-enviar-correo').click(function () {
        var element_select = $('table.cell-selectable').find('.selected').eq(0);
        if($(element_select).length){
            var solicitud = $(element_select).attr('id');

            var url = $('#general_url').val()+'/inventario/solicitudmaterial/mail/'+solicitud;
            window.location.href = url;
        }else{
            abrirAlerta('alertas-solicitudmaterials','danger',['Para enviar los datos de la solicitud debe seleccionar una fila de la tabla'],null,null);
        }
    })
    
    $('#btn-ok-nueva-solicitud').click(function () {
        var params = {_token:$('#general_token').val()};
        var url = $('#general_url').val()+'/inventario/solicitudmaterial/store-solicitud';
        abrirBlockUiCargando('Guardando ');

        $.post(url,params)
            .done(function (data) {
                if(data.success && data.solicitud){
                    window.location.href = $('#general_url').val()+'/inventario/solicitudmaterial/detalle/'+data.solicitud;
                }
            })
            .fail(function (jqXHR,state,error) {
                cerrarBlockUiCargando();
                abrirAlerta('alertas-nueva-solicitud','danger',JSON.parse(jqXHR.responseText).errors,null,null);
            })
    })
})

function cargarTablaSolicitudes(){
    var tabla = $('#tabla').dataTable({ "destroy": true });
    tabla.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    $('#tabla').on('preXhr.dt', function ( e, settings, data ) {
            data.cantidad = $('#cantidad').val();
            data.fecha_inicial = $('#fecha_inicial').val();
            data.fecha_final = $('#fecha_final').val();
        })

    var cols = [
        {data: 'numero', name: 'numero'},
        {data: 'fecha', name: 'fecha'},
        {data: 'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
    ];

    tabla = $('#tabla').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax:  $('#general_url').val()+'/inventario/solicitudmaterial-lista',
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            $(nRow).attr('id',''+aData.id);
            setTimeout(function () {
            },300);
        },
    });
}