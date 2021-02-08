$(function () {
    $('#btn-guardar-cliente').click(function () {
        guardarCliente();
    });
})

function guardarCliente(){

    var params = new FormData(document.getElementById('form-crear-cliente'));
    var url = $("#general_url").val()+"/cliente/store";

    abrirBlockUiCargando('Guardando ');

    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
                $("#form-crear-cliente")[0].reset();
                abrirAlerta("alertas-nuevo-cliente","success",['Cliente creado con éxito'],null,'body');
                cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-nuevo-cliente","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        }
    });
}