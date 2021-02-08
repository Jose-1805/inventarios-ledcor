$(function () {
    $('#btn-guardar-mail').click(function () {
        abrirBlockUiCargando('Enviando ');

        var params = $('#form-mail').serialize();
        var url = $('#general_url').val()+'/inventario/solicitudmaterial/send-mail';
        
        $.post(url,params,function (data) {
            $('#para').val('');
            cerrarBlockUiCargando();
            abrirAlerta('alertas-mail','success',['Correo registrado con éxito'],null,null);
        }).fail(function (jqXHR,error,state) {
            cerrarBlockUiCargando();
            abrirAlerta('alertas-mail','danger',JSON.parse(jqXHR.responseText).errors,null,null);
        })
    })
})