var peticion_en_proceso = false;
$(function () {
    $('#subensamble').change(function () {
        //visibles para Radiadores
        $('#baterias_tk').parent().addClass('hide');
        $('#baterias_tk').prop('disabled','disabled');
        $('#no_elem').parent().addClass('hide');
        $('#no_elem').prop('disabled','disabled');
        $('#ancho_rad').parent().addClass('hide');
        $('#ancho_rad').prop('disabled','disabled');
        $('#longitud_rad').parent().addClass('hide');
        $('#longitud_rad').prop('disabled','disabled');
        $('#peso_teorico_radiadores').parent().addClass('hide');
        $('#peso_teorico_radiadores').prop('disabled','disabled');
        $('#fecha_plan_formado_radiador').parent().addClass('hide');
        $('#fecha_plan_formado_radiador').prop('disabled','disabled');
        $('#fecha_entrega_formado').parent().addClass('hide');
        $('#fecha_entrega_formado').prop('disabled','disabled');

        //visible para tanques
        $('#peso_teorico_tk').parent().addClass('hide');
        $('#peso_teorico_tk').prop('disabled','disabled');
        $('#peso_teorico_cajas').parent().addClass('hide');
        $('#peso_teorico_cajas').prop('disabled','disabled');

        //visible para prensa
        $('#peso_teorico_prensas').parent().addClass('hide');
        $('#peso_teorico_prensas').prop('disabled','disabled');

        if($(this).val() == 'Rad MZ' || $(this).val() == 'Rad TB') {
            //visibles para Radiadores
            $('#baterias_tk').parent().removeClass('hide');
            $('#baterias_tk').prop('disabled', false);
            $('#no_elem').parent().removeClass('hide');
            $('#no_elem').prop('disabled', false);
            $('#ancho_rad').parent().removeClass('hide');
            $('#ancho_rad').prop('disabled', false);
            $('#longitud_rad').parent().removeClass('hide');
            $('#longitud_rad').prop('disabled', false);
            $('#peso_teorico_radiadores').parent().removeClass('hide');
            $('#peso_teorico_radiadores').prop('disabled', false);

            $('#fecha_plan_formado_radiador').parent().removeClass('hide');
            $('#fecha_plan_formado_radiador').prop('disabled',false);
            $('#fecha_entrega_formado').parent().removeClass('hide');
            $('#fecha_entrega_formado').prop('disabled',false);
        }

        if($(this).val() == 'Tanque') {
            //visible para tanques
            $('#peso_teorico_tk').parent().removeClass('hide');
            $('#peso_teorico_tk').prop('disabled', false);
            $('#peso_teorico_cajas').parent().removeClass('hide');
            $('#peso_teorico_cajas').prop('disabled', false);
        }

        if($(this).val() == 'Prensa') {
            //visible para prensa
            $('#peso_teorico_prensas').parent().removeClass('hide');
            $('#peso_teorico_prensas').prop('disabled', false);
        }
    });
    
    $('#subensamble').change();

    $('#btn-save-anexo').click(function () {
        var params = new FormData(document.getElementById('form_archivos'));
        var url = $('#general_url').val()+'/programacion/store-anexo';
        abrirBlockUiCargando('Guardando ');

        $.ajax({
            url: url,
            data: params,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                cerrarBlockUiCargando();
                cargarAnexos($('#programacion').val());
            },
            error: function (jqXHR, error, state) {
                abrirAlerta('alertas-anexos',"danger",JSON.parse(jqXHR.responseText).errors,null,'body');
                cerrarBlockUiCargando();
            }
        });
    })
    
    $('#btn_descargas').click(function () {
        $('.tab-pane').removeClass('active');
        $('#descargas').addClass('active');
    })

    $('body').on('click','#btn-save-programacion',function () {
        if(!peticion_en_proceso) {
            peticion_en_proceso = true;
            //se busca el primer formulario al que pertenezca el botón
            var buscar = true;
            var elemento = $(this);
            while (buscar) {
                elemento = $(elemento).parent();
                if ($(elemento).prop('tagName') == 'FORM') {
                    buscar = false;
                }
            }

            var params = new FormData(document.getElementById($(elemento).attr('id')));
            var url = $(elemento).prop('action');
            var method = $(elemento).prop('method');
            var alertas = $(elemento).data('alertas');
            abrirBlockUiCargando('Guardando ');

            $.ajax({
                url: url,
                data: params,
                cache: false,
                contentType: false,
                processData: false,
                type: method,
                success: function (data) {
                    console.log(data);
                    if(data.success == false){
                        if(data.error_precedencia){
                            cerrarBlockUiCargando();
                            $('#modal-confirmar-precedencia').modal('show');
                        }
                    }else {

                        if (data.reload) {
                            window.location.reload()
                        } else if (data.href) {
                            window.location.href = data.href;
                        } else {
                            $(elemento)[0].reset();
                            $('#confirmar_precedencia').val('no');
                            abrirAlerta(alertas, "success", ['Tarea realizada con éxito'], null, 'body');
                            cerrarBlockUiCargando();
                        }
                    }
                    peticion_en_proceso = false;
                },
                error: function (jqXHR, error, state) {
                    abrirAlerta(alertas, "danger", JSON.parse(jqXHR.responseText).errors, null, 'body');
                    cerrarBlockUiCargando();
                    $('#confirmar_precedencia').val('no');
                    peticion_en_proceso = false;
                }
            });
        }
    })
    
    $('#btn-ok-confirmar-precedencia').click(function () {
        $('#confirmar_precedencia').val('si');
        $('#modal-confirmar-precedencia').modal('hide');
        $('#btn-save-programacion').click();
    })

    $('#no_preliminar_inicial').keyup(function () {
        $('#no_fabricacion_inicial').val($(this).val());
    })

    $('#no_preliminar_final').keyup(function () {
        $('#no_fabricacion_final').val($(this).val());
    })
})

function cargarAnexos(programacion){
    var url = $('#general_url').val()+'/programacion/anexos';
    var params = {_token:$('#general_token').val(),programacion:programacion};
    var element_load = $('#archivos_anexos').parent();
    abrirBlockUiElemento(element_load,'Cargando');
    $.post(url,params)
        .done(function (data) {
            $('#archivos_anexos').html(data);
            cerrarBlockUiElemento(element_load);
        })
}