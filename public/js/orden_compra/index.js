var id_select = null;
$(function () {
    $('body').on('click','.btn-eliminar-orden-compra',function () {
        id_select = $(this).data('user');
    })

    $('#btn-action-eliminar-orden-compra').click(function () {
        eliminarOrdenCompra();
    })
})

function eliminarOrdenCompra() {
    var paramams = {id:id_select,_token:$('#general_token').val()};
    var url = $('#general_url').val()+'/orden-compra/delete';

    abrirBlockUiCargando('Eliminando ...');

    $.post(url,paramams)
    .done(function (data) {
        abrirAlerta("alertas-orden-compra","success",['Orden de compra eliminada con éxito'],null,'body');
        $('#row_'+id_select).remove();
        id_select = null;
        $('#modal-eliimnar-orden-compra').modal('hide');
        cerrarBlockUiCargando();
    })
    .fail(function (jqXHR,state,error) {
        abrirAlerta("alertas-orden-compra","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
        cerrarBlockUiCargando();
    })
}