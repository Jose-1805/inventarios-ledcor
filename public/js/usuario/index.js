var id_select = null;
$(function () {
    $('body').on('click','.btn-eliminar-usuario',function () {
        id_select = $(this).data('user');
    })

    $('#btn-action-eliminar-usuario').click(function () {
        eliminarUsuario();
    })
})

function eliminarUsuario() {
    var paramams = {id:id_select,_token:$('#general_token').val()};
    var url = $('#general_url').val()+'/usuario/delete';

    abrirBlockUiCargando('Eliminando ...');

    $.post(url,paramams)
    .done(function (data) {
        abrirAlerta("alertas-usuario","success",['Usuario eliminado con éxito'],null,'body');
        $('#row_'+id_select).remove();
        id_select = null;
        $('#modal-eliimnar-usuario').modal('hide');
        cerrarBlockUiCargando();
    })
    .fail(function (jqXHR,state,error) {
        abrirAlerta("alertas-usuario","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
        cerrarBlockUiCargando();
    })
}