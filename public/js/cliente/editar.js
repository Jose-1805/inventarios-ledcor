$(function () {
    $('#btn-guardar-cliente').click(function () {
        guardarCliente();
    });
})

function guardarCliente(){

    var params = new FormData(document.getElementById('form-editar-cliente'));
    var url = $("#general_url").val()+"/cliente/update";

    abrirBlockUiCargando('Guardando');
    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            abrirAlerta("alertas-editar-cliente","success",['Cliente editado con éxito'],null,'body');
            cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-editar-cliente","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        }
    });
}