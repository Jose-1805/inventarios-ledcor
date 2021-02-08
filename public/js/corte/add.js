$(function () {
    $('#no_fabricacion_inicial').keyup(function () {
        var params = {_token:$('#general_token').val(),no_fabricacion_inicial:$(this).val()};
        var url = $('#general_url').val()+'/corte/data-programacion';
        $.post(url,params)
            .done(function (data) {
                if(data.success){
                    $('#no_fabricacion_final').val(data.programacion.no_fabricacion_final);
                    $('#ensamble option[value="'+data.programacion.subensamble+'"]').prop('selected','selected');
                    console.log(data.programacion.calculo_fert);
                    $('#calculo option').each(function (i,el) {
                        if($(el).html() == data.programacion.calculo_fert)
                            $(el).prop('selected','selected');
                    })
                    $('#cantidad_tk').val(data.programacion.cantidad_tk);
                    $('#proyecto option[value="'+data.programacion.proyecto_id+'"]').prop('selected','selected');
                    if(data.programacion.calculo)
                        $('#calculo option[value="'+data.programacion.calculo+'"]').prop('selected','selected');
                }
            })
    })
})