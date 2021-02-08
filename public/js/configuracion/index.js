$(function () {
    $('#btn-cambiar-contrasena').click(function () {
        cambiarPassword();
    })
    $('#btn-desbloquear-dispositivo').click(function () {
        desbloquearDispositivo();
    })
    $('#btn-cambiar-imagen').click(function () {
        imagenEmpresario();
    })
})

function cambiarPassword() {
    var params = $("#form-cambio-password").serialize();
    var url = $("#general_url").val() + "/configuracion/cambiar-password";

    abrirBlockUiCargando('Guardando ');

    $.post(url, params)
        .done(function (data) {
            $("#form-cambio-password")[0].reset();
            abrirAlerta("alertas-configuraciones", "success", ['Contraseña actualizada con éxito.'], null, 'body');
            $('#modal-contrasena').modal('hide');
            cerrarBlockUiCargando();
        })
        .fail(function (jqXHR, state, error) {
            abrirAlerta("alertas-cambiar-password", "danger", JSON.parse(jqXHR.responseText).errors, null, null);
            cerrarBlockUiCargando();
        })
}

function desbloquearDispositivo() {
    var params = {_token:$('#general_token').val()};
    var url = $("#general_url").val() + "/configuracion/desbloquear-dispositivo";

    abrirBlockUiCargando('Desbloqueando ');

    $.post(url, params)
        .done(function (data) {
            abrirAlerta("alertas-configuraciones", "success", ['Dispositivo móvil desbloqueado con éxito.'], null, 'body');
            $('#modal-desbloquear-dispositivo').modal('hide');
            cerrarBlockUiCargando();
        })
        .fail(function (jqXHR, state, error) {
            abrirAlerta("alertas-configuraciones", "danger", JSON.parse(jqXHR.responseText).errors, null, null);
            $('#modal-desbloquear-dispositivo').modal('hide');
            cerrarBlockUiCargando();
        })
}

function imagenEmpresario() {
    var params = new FormData(document.getElementById('form-imagen-empresario'));
    var url = $("#general_url").val()+"/configuracion/imagen-empresario";

    abrirBlockUiCargando('Actualizando');
    $.ajax({
        url: url,
        data: params,
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function(data){
            window.location.reload();
        },
        error: function (jqXHR, error, state) {
            abrirAlerta("alertas-imagen-empresario","danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        }
    });
}