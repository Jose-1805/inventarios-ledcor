var id_select = null;
$(function () {
    $('body').on('click','.btn-eliminar-proyecto',function () {
        id_select = $(this).data('user');
    })

    $('#btn-action-eliminar-proyecto').click(function () {
        eliminarProyecto();
    })
})

function eliminarProyecto() {
    var paramams = {id:id_select,_token:$('#general_token').val()};
    var url = $('#general_url').val()+'/proyecto/delete';

    abrirBlockUiCargando('Eliminando ...');

    $.post(url,paramams)
    .done(function (data) {
        abrirAlerta("alertas-proyecto","success",['Proyecto eliminado con éxito'],null,'body');
        $('#row_'+id_select).remove();
        id_select = null;
        $('#modal-eliimnar-proyecto').modal('hide');
        cerrarBlockUiCargando();
    })
    .fail(function (jqXHR,state,error) {
        abrirAlerta("alertas-proyecto","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
        cerrarBlockUiCargando();
    })
}