$(function () {
    $('#btn-guardar-proveedor').click(function () {
        guardarProveedor();
    });
})

function guardarProveedor(){

    var params = new FormData(document.getElementById('form-crear-proveedor'));
    var url = $("#general_url").val()+"/proveedor/store";

    abrirBlockUiCargando('Guardando ');

    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
                $("#form-crear-proveedor")[0].reset();
                abrirAlerta("alertas-nuevo-proveedor","success",['Proveedor creado con éxito'],null,'body');
                cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-nuevo-proveedor","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        }
    });
}