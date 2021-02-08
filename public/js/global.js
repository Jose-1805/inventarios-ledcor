var idioma_tablas = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
};
var btn_eliminar_elemento_lista = null;
var peticion_en_proceso = false;
$(function () {
    //evita que se cierren las alertas como lo hace bootstrap (quitando la clase de la alert) y oculta con la clase hide la alerta
    $('body').on('click','.alert .close',function () {
        $(this).parent().addClass('hide');
    })

    //Cuando se presione enter dentro de un formulario se realiza click sobre el elemento que contenga la clase btn-submit
    $("body").on('keyup','form',function (e) {
        if(e.keyCode == 13 && e.target.nodeName != 'TEXTAREA'){
            $(this).find('.btn-submit').click();
        }
    })

    //evita que se realice el submit de un form
    $('form.no_submit').submit(function (e) {
        e.preventDefault();
    })

    /**
     * ENVIO GENERAL DE FORMULARIOS
     */
    $('body').on('click','.btn-submit-general',function () {
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
                    if (data.reload) {
                        window.location.reload()
                    } else if (data.href) {
                        window.location.href = data.href;
                    } else {
                        $(elemento)[0].reset();
                        abrirAlerta(alertas, "success", ['Tarea realizada con éxito'], null, 'body');
                        cerrarBlockUiCargando();
                    }
                    peticion_en_proceso = false;
                },
                error: function (jqXHR, error, state) {
                    abrirAlerta(alertas, "danger", JSON.parse(jqXHR.responseText).errors, null, 'body');
                    cerrarBlockUiCargando();
                    peticion_en_proceso = false;
                }
            });
        }
    })

    $('body').on('click','.btn-eliminar-elemento-lista',function (){
        btn_eliminar_elemento_lista = $(this);
    });

    $('body').on('click','#btn-ok-eliminar-elemento-lista',function (){
        eliminarElementoLista();
    });

    $(window).scroll(function () {
        if($(window).scrollTop() >= 160){
            $('.contenedor-opciones-vista').addClass('contenedor-opciones-vista-fixed');
        }else{
            $('.contenedor-opciones-vista').removeClass('contenedor-opciones-vista-fixed');
        }
    });

    $('body').on('click','table.cell-selectable tbody tr',function () {
        $(this).parent().children('tr').removeClass('info');

        if(!$(this).hasClass('selected')){
            $(this).parent().children('tr').removeClass('selected');
            $(this).addClass('info');
            $(this).addClass('selected');
        }else{
            $(this).removeClass('selected');
        }
    })
})

function eliminarElementoLista() {
    abrirBlockUiCargando('Eliminando ');
    //se busca el primer tr al que pertenezca el botón
    var buscar = true;
    var elemento = $(btn_eliminar_elemento_lista);
    while (buscar){
        elemento = $(elemento).parent();
        if($(elemento).prop('tagName') == 'TR') {
            buscar = false;
        }
    }
    var url = $(btn_eliminar_elemento_lista).data('url');
    var id = $(btn_eliminar_elemento_lista).data('elemento-lista');
    btn_eliminar_elemento_lista = null;

    var params = {id:id,_token:$('#general_token').val()};
    $.post(url, params).done(function() {
        $(elemento).remove();
        cerrarBlockUiCargando();
        $('#modal-eliminar-elemento-lista').modal('hide');
    });
}
/**
 * Funcion para mostrar las alertas del sistema
 * @param id_contenedor => contenedor de las alertas
 * @param tipo => info - success - warning - danger
 * @param data => array con la información
 * @param duracion => duracion en segundos
 * @param id_contenedor_scroll => id del contenedor que posee el scroll que debe quedar en top = 0
 */
function abrirAlerta(id_contenedor,tipo, data, duracion = null,id_contenedor_scroll = false){
    var html = "";
    $.each(data, function(key,value){
        html += "• "+value+"<br/>";
    });
    $("#"+id_contenedor+" .alert").addClass("hide");
    $("#"+id_contenedor+" .alert-"+tipo+" .mensaje").html(html);
    $("#"+id_contenedor+" .alert-"+tipo).removeClass("hide");

    if(duracion != null && $.isNumeric(duracion)){
        setTimeout(function () {
            $("#"+id_contenedor+" .alert-"+tipo).addClass("hide");
        },(duracion*1000));
    }

    if(id_contenedor_scroll != false)
        $("#"+id_contenedor_scroll).stop().animate({scrollTop:0}, '5000', 'swing');
}

/**
 * Abre dialog de bloqueo de pantalla
 * Debe incluir framework de diseñño MATERIALIZECSS o las clases de color contenidas en él
 *
 * @param mensaje => mensaje a mostrar, si se pasa el valor undefined muestra el mensaje por defecto
 * @param load => si debe mostrar icono de carga o no
 */
function abrirBlockUiCargando(mensaje = "Cargando",load = true) {
    var html = '<img src="'+$('#general_url').val()+'/imagenes/sistema/logo.png" style="width: 100px !important;" /><h4 class="white-text">'+mensaje;
    if(load)
        html += ' <i class="fa fa-spin fa-circle-o-notch white-text"></i>';
    html += '</h4>';
    $.blockUI({ message: html });
}


function cerrarBlockUiCargando() {
    $.unblockUI();
}


function abrirBlockUiElemento(elemento, mensaje = "Cargando",load = true) {
    var html = '<h4 class="white-text">'+mensaje;
    if(load)
        html += ' <i class="fa fa-spin fa-circle-o-notch white-text"></i>';
    html += '</h4>';
    $(elemento).block({ message: html });
}

function cerrarBlockUiElemento(elemento) {
    $(elemento).unblock();
}