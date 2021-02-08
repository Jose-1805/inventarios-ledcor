var cols = [
    {data:'posicion',name:'posicion'},
    {data:'plano',name:'plano'},
    {data:'ensamble',name:'ensamble'},
    {data:'nombre',name:'nombre'},
    {data:'espesor',name:'espesor'},
    {data:'longitud_1',name:'longitud_1'},
    {data:'longitud_2',name:'longitud_2'},
    {data:'centro_corte',name:'centro_corte'},
    {data:'peso_neto',name:'peso_neto'},
    {data:'masa',name:'masa'},
    {data:'unidad',name:'unidad'},
    {data:'codigo_material',name:'codigo_material'},
    {data:'especificacion',name:'especificacion'},
    {data:'descripcion',name:'descripcion'},
    {data:'observaciones',name:'observaciones'},
    {data:'proceso',name:'proceso'},
    {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
];
var calculo = null;
$(function () {
    $('#btn-nuevo-detalle-manual').click(function () {
        cargarFormularioDetalleManual();
    })
    
    $('#btn-guardar-detalle-manual').click(function () {
        guardarDetalleManual();
    })

    $('body').on('click','.btn-editar-detalle-manual',function () {
        var id = $(this).data('detalle');
        if(id)cargarFormularioDetalleManual(id);
    })
})

function setCols(cols) {
    this.cols = cols;
}

function setCalculo(calculo) {
    this.calculo = calculo;
}

function cargarTablaDetalleManual() {
    var tabla = $('#tabla').dataTable({ "destroy": true });
    tabla.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    });

    tabla.on( 'preXhr.dt', function (e, configuración, json) {
        json.calculo = calculo;
    });

    tabla = $('#tabla').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $('#general_url').val()+'/calculo-lista-detalle',
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            $(nRow).attr('id','row_'+aData.id);
            setTimeout(function () {
            },300);
        },
    });
}

function cargarFormularioDetalleManual(id = null) {
    abrirBlockUiCargando('Cargando ');
    var params = {_token:$('#general_token').val(),id:id,calculo:calculo};
    var url = $('#general_url').val()+'/calculo-form-detalle-manual';
    $.post(url,params)
        .done(function (data){
           $('#modal_detalle_manual').find('.modal-body').html(data);
            cerrarBlockUiCargando();
            $('#modal_detalle_manual').modal('show');
        });
}

function guardarDetalleManual() {
    abrirBlockUiCargando('Guardando');
    var params = $('#form_detalle_manual').serialize();
    var url = $('#general_url').val()+'/calculo/store-detalle-manual';
    $.post(url,params)
        .done(function () {
            cargarTablaDetalleManual();
            $('#modal_detalle_manual').modal('hide');
            cerrarBlockUiCargando();
        }).fail(function (jqXHR,state,error) {
            abrirAlerta('alertas_form_detalle_manual',"danger",JSON.parse(jqXHR.responseText).errors,null,'body');
            cerrarBlockUiCargando();
        })
}