$(function () {
    $('#btn-guardar-proyecto').click(function () {
        guardarProyecto();
    });
})

function guardarProyecto(){

    var params = new FormData(document.getElementById('form-crear-proyecto'));
    var url = $("#general_url").val()+"/proyecto/store";

    abrirBlockUiCargando('Guardando ');

    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
                $("#form-crear-proyecto")[0].reset();
                abrirAlerta("alertas-nuevo-proyecto","success",['Proyecto creado con éxito'],null,'body');
                cerrarBlockUiCargando();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-nuevo-proyecto","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        }
    });
}