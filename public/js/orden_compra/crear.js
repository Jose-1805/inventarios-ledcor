$(function () {
    $('#btn-guardar-orden-compra').click(function () {
        guardarOrdenCompra();
    });
})

function guardarOrdenCompra(){

    var params = new FormData(document.getElementById('form-crear-orden-compra'));
    var url = $("#general_url").val()+"/orden-compra/store";

    abrirBlockUiCargando('Guardando ');

    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
                $("#form-crear-orden-compra")[0].reset();
                abrirAlerta("alertas-nueva-orden-compra","success",['Orden de compra creada con éxito'],null,'body');
                cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-nueva-orden-compra","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        }
    });
}