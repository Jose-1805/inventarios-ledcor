var rol_seleccionado = null;
$(function () {
    cargarRoles();
    //cargarFunciones();

    $('body').on('click','.btn-privilegios-rol',function () {
        rol_seleccionado = $(this).data('rol');
        cargarPrivilegios();
    })

    $('body').on('click','.btn-editar-rol',function () {
        rol_seleccionado = $(this).data('rol');
        cargarFormEditar();
    })

    $("#btn-nuevo-rol").click(function () {
        nuevoRol();
    })

    $("#btn-guardar-editar-rol").click(function () {
        editarRol();
    })

    $('body').on('click','.btn-seleccionar',function () {
        $(this).parent().children('table').find('input[type="checkbox"]').prop('checked','checked');
    })

    $('body').on('click','.btn-deseleccionar',function () {
        $(this).parent().children('table').find('input[type="checkbox"]').prop('checked','');
    })

    $('body').on('click','.column-selector',function () {
        var data_class = $(this).data('class');
        var elemento = $(this);
        var action_success = false;
        $(this).parent().parent().parent().children('tbody').find('.column-'+data_class).each(function (i,el) {
            if(!$(el).prop('checked')){
                $(elemento).parent().parent().parent().children('tbody').find('.column-'+data_class).prop('checked','checked');
                action_success = true;
                return true;
            }
        })
        if(!action_success)
            $(this).parent().parent().parent().children('tbody').find('.column-'+data_class).prop('checked','');
    })


})


function cargarRoles() {
    var elemento = $("#contenedor-roles");
    abrirBlockUiElemento(elemento);
    var url = $('#general_url').val()+'/rol/vista-roles';
    var params = {_token:$('#general_token').val()};

    $.post(url,params,function (data) {
        $(elemento).html(data);
        cerrarBlockUiElemento(elemento);
    })
}

function cargarPrivilegios() {
    var elemento = $("#contenedor-privilegios");
    abrirBlockUiElemento(elemento);
    var url = $('#general_url').val()+'/rol/vista-privilegios';
    var params = {_token:$('#general_token').val(),rol:rol_seleccionado};

    $.post(url,params,function (data) {
        $(elemento).html(data);
        cerrarBlockUiElemento(elemento);
    })
}

function nuevoRol() {
    var params = $("#form-rol").serialize();
    var url = $("#general_url").val()+"/rol/crear";

    abrirBlockUiCargando('Guardando ');
    
    $.post(url,params)
    .done(function (data) {
        $("#form-rol")[0].reset();
        $("#modal-nuevo-rol").modal('hide');
        cerrarBlockUiCargando();
        cargarRoles();
    })
    .fail(function (jqXHR,state,error) {
        abrirAlerta("alertas-nuevo-rol","danger",JSON.parse(jqXHR.responseText).errors,null,"modal-nuevo-rol");
        cerrarBlockUiCargando();
    })
}

function cargarFormEditar(){
    var params = {'_token':$('#general_token').val(),'rol':rol_seleccionado};
    var url = $("#general_url").val()+"/rol/form";

    abrirBlockUiCargando('Cargando ');

    $.post(url,params)
    .done(function (data) {
        $("#contenedor-editar-rol").html(data);
        $("#modal-editar-rol").modal('show');
        cerrarBlockUiCargando();
    })
    .fail(function (jqXHR,state,error) {
        //abrirAlerta("alertas-nuevo-rol","danger",JSON.parse(jqXHR.responseText).errors,null,"modal-nuevo-rol");
        alert('Ocurrio un error inesperado !!');
        cerrarBlockUiCargando();
    })
}

function editarRol() {
    var params = $("#form-editar-rol").serialize();
    var url = $("#general_url").val()+"/rol/editar";

    abrirBlockUiCargando('Guardando ');

    $.post(url,params)
        .done(function (data) {
            if(data.success) {
                $("#contenedor-editar-rol").html('');
                $("#modal-editar-rol").modal('hide');
                cargarRoles();
                cargarPrivilegios();
                cerrarBlockUiCargando();
            }else{
                window.location.reload();
            }
        })
        .fail(function (jqXHR,state,error) {
            abrirAlerta("alertas-editar-rol","danger",JSON.parse(jqXHR.responseText).errors,null,"modal-editar-rol");
            cerrarBlockUiCargando();
        })
}