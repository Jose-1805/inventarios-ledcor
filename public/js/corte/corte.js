var cortes_seleccionados = [];
var cortes_imprimir_seleccionados = [];
$(function () {
    $('body').on('change','.item-filtro',function () {
        cargarTablaCortes();
    })

    cargarTablaCortes();

    $('body').on('change','.check-corte',function () {
        var corte = $(this).data('corte');
        if($(this).prop('checked')){
            cortes_seleccionados.push(corte);
        }else{
            cortes_seleccionados.forEach(function(el,i){
                if(el == corte){
                    cortes_seleccionados.splice(i,1);
                }
            });
        }
    })

    $('body').on('change','.corte_imprimir',function () {
        var corte = $(this).data('corte');
        if($(this).prop('checked')){
            cortes_imprimir_seleccionados.push(corte);
        }else{
            cortes_imprimir_seleccionados.forEach(function(el,i){
                if(el == corte){
                    cortes_imprimir_seleccionados.splice(i,1);
                }
            });
        }
    })

    $('#btn-imprimir').click(function () {
        if(cortes_seleccionados.length){
            var params = {_token:$('#general_token').val(),'cortes':cortes_seleccionados};
            var url = $('#general_url').val()+'/corte/vista-imprimir-documentos';
            abrirBlockUiCargando('Cargando');
            $.post(url,params,function (data) {
                $('#contenido-imprimir-documentos').html(data);
                $('#modal-imprimir-documentos').modal('show');
                cortes_imprimir_seleccionados = [];
                cerrarBlockUiCargando();
            })
        }else{
            abrirAlerta('alertas-cortes','danger',['Para imprimir documentos seleccione por lo menos un corte']);
        }
    })

    $('body').on('click','#btn-certificado-calidad',function () {
        var seleccionados = [];
        $('.corte_imprimir').each(function (i, el) {
            if ($(el).prop('checked')) seleccionados.push($(el).data('corte'));
        })


        if (!seleccionados.length) {
            abrirAlerta('alertas-imprimir-documentos','danger',['Seleccione por lo menos un corte']);
        }else {
            for(i = 0;i<seleccionados.length;i++){
                window.open($('#general_url').val()+'/corte/certificado-calidad/'+seleccionados[i],'_blank');
            }
        }
    });

    $('body').on('click','#btn-registro-hermeticidad',function () {
        var seleccionados = [];
        $('.corte_imprimir').each(function (i, el) {
            if ($(el).prop('checked')) seleccionados.push($(el).data('corte'));
        })


        if (!seleccionados.length) {
            abrirAlerta('alertas-imprimir-documentos','danger',['Seleccione por lo menos un corte']);
        }else {
            for(i = 0;i<seleccionados.length;i++){
                window.open($('#general_url').val()+'/corte/registro-hermeticidad/'+seleccionados[i],'_blank');
            }
        }
    });

    $('body').on('click','#btn-liberacion-mdt',function () {
        var seleccionados = [];
        $('.corte_imprimir').each(function (i, el) {
            if ($(el).prop('checked')) seleccionados.push($(el).data('corte'));
        })


        if (!seleccionados.length) {
            abrirAlerta('alertas-imprimir-documentos','danger',['Seleccione por lo menos un corte']);
        }else {
            for(i = 0;i<seleccionados.length;i++){
                window.open($('#general_url').val()+'/corte/liberacion-mdt/'+seleccionados[i],'_blank');
            }
        }
    });

    $('body').on('click','#btn-liberacion-tanques',function () {
        var seleccionados = [];
        $('.corte_imprimir').each(function (i, el) {
            if ($(el).prop('checked')) seleccionados.push($(el).data('corte'));
        })


        if (!seleccionados.length) {
            abrirAlerta('alertas-imprimir-documentos','danger',['Seleccione por lo menos un corte']);
        }else {
            for(i = 0;i<seleccionados.length;i++){
                window.open($('#general_url').val()+'/corte/liberacion-tanque/'+seleccionados[i],'_blank');
            }
        }
    });
})

function cargarTablaCortes(){
    cortes_seleccionados = [];
    var tabla = $('#tabla').dataTable({ "destroy": true });
    tabla.fnDestroy();
    $.fn.dataTable.ext.errMode = 'none';
    $('#tabla').on('error.dt', function(e, settings, techNote, message) {
        console.log( 'DATATABLES ERROR: ', message);
    })

    $('#tabla').on('preXhr.dt', function ( e, settings, data ) {
            data.ensamble = $('#ensamble').val();
        } )

    var cols = [
        {data: 'no_fabricacion_inicial', name: 'no_fabricacion_inicial'},
        {data: 'no_fabricacion_final', name: 'no_fabricacion_final'},
        {data: 'ensamble', name: 'ensamble'},
        {data: 'calculo', name: 'calculo'},
        {data: 'fert', name: 'fert'},
        {data: 'cantidad_tk', name: 'cantidad_tk'},
        {data: 'proyecto', name: 'proyecto'},
        {data: 'elaborado_por', name: 'elaborado_por'},
        {data: 'peso_tanque', name: 'peso_tanque'},
        {data: 'peso_prensa', name: 'peso_prensa'},
        {data: 'peso_caja', name: 'peso_caja'},
        {data: 'peso_otro_item', name: 'peso_otro_item'},
        {data: 'observacion', name: 'observacion'},
        {data: 'verificacion_calidad', name: 'verificacion_calidad',searchable: false,"className": "text-center"},
        {data: 'seleccion', name: 'seleccion', "className": "text-center"},
        {data:'opciones',name:'opciones',orderable: false, searchable: false,"className": "text-center"}
    ];

    tabla = $('#tabla').DataTable({
        lenguage: idioma_tablas,
        processing: true,
        serverSide: true,
        ajax: $('#general_url').val()+"/corte-lista",
        columns: cols,
        fnRowCallback: function (nRow, aData, iDisplayIndex) {
            $(nRow).attr('id',aData.id);
            setTimeout(function () {
            },300);
        },
    });
}