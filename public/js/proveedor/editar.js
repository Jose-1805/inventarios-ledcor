$(function () {
    $('#btn-guardar-proveedor').click(function () {
        guardarProveedor();
    });
})

function guardarProveedor(){

    var params = new FormData(document.getElementById('form-editar-proveedor'));
    var url = $("#general_url").val()+"/proveedor/update";

    abrirBlockUiCargando('Guardando');
    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            abrirAlerta("alertas-editar-proveedor","success",['Proveedor editado con éxito'],null,'body');
            cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-editar-proveedor","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        }
    });
}