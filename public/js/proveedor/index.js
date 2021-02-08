var id_select = null;
$(function () {
    $('body').on('click','.btn-eliminar-proveedor',function () {
        id_select = $(this).data('user');
    })

    $('#btn-action-eliminar-proveedor').click(function () {
        eliminarProveedor();
    })
})

function eliminarProveedor() {
    var paramams = {id:id_select,_token:$('#general_token').val()};
    var url = $('#general_url').val()+'/proveedor/delete';

    abrirBlockUiCargando('Eliminando ...');

    $.post(url,paramams)
    .done(function (data) {
        abrirAlerta("alertas-proveedor","success",['Proveedor eliminado con éxito'],null,'body');
        $('#row_'+id_select).remove();
        id_select = null;
        $('#modal-eliimnar-proveedor').modal('hide');
        cerrarBlockUiCargando();
    })
    .fail(function (jqXHR,state,error) {
        abrirAlerta("alertas-proveedor","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
        cerrarBlockUiCargando();
    })
}