$(function () {
    $('#material').change(function () {
        var material = $(this).val();

        var params = {_token:$('#general_token').val(),material:material,name:'solicitud'};
        var url = $('#general_url').val()+'/inventario/solicitudmaterial/get-select';

        abrirBlockUiElemento($('#contenedor_solicitud'),'Cargando',true);

        $.post(url,params,function (data) {
            $('#contenedor_solicitud').html(data);
            cerrarBlockUiElemento($('#contenedor_solicitud'));
        })
    })
})