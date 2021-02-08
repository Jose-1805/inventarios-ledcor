var id_select = null;
$(function () {
    $('body').on('click','.btn-eliminar-cliente',function () {
        id_select = $(this).data('user');
    })

    $('#btn-action-eliminar-cliente').click(function () {
        eliminarCliente();
    })
})

function eliminarCliente() {
    var paramams = {id:id_select,_token:$('#general_token').val()};
    var url = $('#general_url').val()+'/cliente/delete';

    abrirBlockUiCargando('Eliminando ...');

    $.post(url,paramams)
    .done(function (data) {
        abrirAlerta("alertas-cliente","success",['Cliente eliminado con éxito'],null,'body');
        $('#row_'+id_select).remove();
        id_select = null;
        $('#modal-eliimnar-cliente').modal('hide');
        cerrarBlockUiCargando();
    })
    .fail(function (jqXHR,state,error) {
        abrirAlerta("alertas-cliente","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
        cerrarBlockUiCargando();
    })
}