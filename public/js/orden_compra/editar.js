$(function () {
    $('#btn-guardar-orden-compra').click(function () {
        guardarOrdenCompra();
    });
})

function guardarOrdenCompra(){

    var params = new FormData(document.getElementById('form-editar-orden-compra'));
    var url = $("#general_url").val()+"/orden-compra/update";

    abrirBlockUiCargando('Guardando');
    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            abrirAlerta("alertas-editar-orden-compra","success",['Orden de compra editada con éxito'],null,'body');
            cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-editar-orden-compra","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        }
    });
}