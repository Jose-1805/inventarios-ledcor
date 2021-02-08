$(function () {
    $('#btn-guardar-proyecto').click(function () {
        guardarProyecto();
    });
})

function guardarProyecto(){

    var params = new FormData(document.getElementById('form-editar-proyecto'));
    var url = $("#general_url").val()+"/proyecto/update";

    abrirBlockUiCargando('Guardando');
    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            abrirAlerta("alertas-editar-proyecto","success",['Proyecto editado con éxito'],null,'body');
            cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-editar-proyecto","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        }
    });
}