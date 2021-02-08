$(function () {
    $('#btn-guardar-usuario').click(function () {
        guardarUsuario();
    });
})

function guardarUsuario(){

    var params = new FormData(document.getElementById('form-editar-usuario'));
    var url = $("#general_url").val()+"/operario/update";

    abrirBlockUiCargando('Guardando');
    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            abrirAlerta("alertas-editar-usuario","success",['Operario editado con éxito'],null,'body');
            cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-editar-usuario","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        }
    });
}