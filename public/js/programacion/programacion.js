$(function () {

    $('body').on('change','.item-filtro',function () {
        cargarTablaProgramaciones();
    })

    $('#btn-copiar').click(function () {
        var element_select = $('table.cell-selectable').find('.selected').eq(0);
        if($(element_select).length){
            var params = {_token:$('#general_token').val(),programacion:$(element_select).attr('id')};
            var url = $('#general_url').val()+'/programacion/copiar';
            abrirBlockUiCargando('Copiando ');
            $.post(url,params)
                .done(function (data) {
                    if(data.success){
                        if(data.programacion){
                            window.location.href = $('#general_url').val()+'/programacion/'+data.programacion+'/edit';
                        }
                    }else{
                        cerrarBlockUiCargando();
                        abrirAlerta('alertas-programacions','danger',['Ocurrio un error inesperado, por favor recargue la página e intente de nuevo'],null,null);
                    }
                })
                .fail(function (jqXHR,state,error) {
                    cerrarBlockUiCargando();
                    abrirAlerta('alertas-programacions','danger',JSON.parse(jqXHR.responseText),null,null);
                })
        }else{
            abrirAlerta('alertas-programacions','danger',['Para realizar una copia seleccione una fila de la tabla'],null,null);
        }
    })

    cargarTablaProgramaciones();

    $('#btn-ok-importar-programacion').click(function () {
        var params = new FormData(document.getElementById('form-importacion'));
        var url = $('#general_url').val()+'/programacion/importar';
        var method = 'POST';
        var alertas = 'alertas-importacion';
        abrirBlockUiCargando('Guardando ');

        $.ajax({
            url: url,
            data: params,
            cache: false,
            contentType: false,
            processData: false,
            type: method,
            success: function (data) {
                abrirAlerta('alertas-programacions', "success", ['Inportación procesada con éxito'], null, 'body');
                $('#form-importacion')[0].reset();
                $('#modal-importar-programacion').modal('hide');
                cargarTablaProgramaciones();
                cerrarBlockUiCargando();
            },
            error: function (jqXHR, error, state) {
                abrirAlerta(alertas, "danger", JSON.parse(jqXHR.responseText).errors, null, 'body');
                cerrarBlockUiCargando();
            }
        });
    })

    $('#btn-seguimiento').click(function () {
        var element_select = $('table.cell-selectable').find('.selected').eq(0);
        if($(element_select).length){
            $('#prg').val($(element_select).attr('id'));
            $('#modal-seguimiento').modal('show');
        }else{
            abrirAlerta('alertas-programacions','danger',['Para registrar un seguimiento seleccione una fila de la tabla'],null,null);
        }
    })

    $('#btn-ok-seguimiento').click(function () {
            var params = $('#form-seguimiento').serialize();
            var url = $('#general_url').val()+'/programacion/store-seguimiento';
            abrirBlockUiCargando('Guardando ');
            $.post(url,params)
                .done(function (data) {
                    abrirAlerta('alertas-programacions','success',['Seguimiento registrado con éxito.'],null,null);
                    cerrarBlockUiCargando();
                    $('#form-seguimiento')[0].reset();
                    $('#modal-seguimiento').modal('hide');
                })
                .fail(function (jqXHR,state,error) {
                    cerrarBlockUiCargando();
                    abrirAlerta('alertas-seguimiento','danger',JSON.parse(jqXHR.responseText).errors,null,null);
                })
    })
})

function cargarTablaProgramaciones(){
    var tabla = $('#tabla').dataTable({ "destroy": true });
    tabla.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    $('#tabla').on('preXhr.dt', function ( e, settings, data ) {
            data.estado = $('#estado').val();
            data.fecha_inicial = $('#fecha_inicial').val();
            data.fecha_final = $('#fecha_final').val();
            data.linea = $('#linea').val();
            data.subensamble = $('#subensamble').val();
        })

    var cols = [
        {data: 'linea', name: 'linea'},
        {data: 'tipo_item', name: 'tipo_item'},
        {data: 'subensamble', name: 'subensamble'},
        {data: 'tipo_tk', name: 'tipo_tk'},
        {data: 'no_preliminar_inicial', name: 'no_preliminar_inicial'},
        {data: 'no_preliminar_final', name: 'no_preliminar_final'},
        {data: 'no_fabricacion_inicial', name: 'no_fabricacion_inicial'},
        {data: 'no_fabricacion_final', name: 'no_fabricacion_final'},
        {data: 'orden_fabricacion_trafo', name: 'orden_fabricacion_trafo'},
        {data: 'cantidad_tk', name: 'cantidad_tk'},
        {data: 'KVA', name: 'KVA'},
        {data: 'calculo', name: 'calculo'},
        {data: 'proyecto', name: 'proyecto'},
        {data: 'fecha_plan', name: 'fecha_plan'},
        {data: 'estado', name: 'estado'},
        {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
    ];

    tabla = $('#tabla').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $('#general_url').val()+"/programacion-lista",
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            $(nRow).attr('id',aData.id);
            setTimeout(function () {
            },300);
        },
    });
}