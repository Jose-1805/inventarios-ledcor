<table class="table dataTable">
    <thead>
        <th>N° Fab Inicial</th>
        <th>N° Fab Final</th>
        <th>Ensamble</th>
        <th>Selección</th>
    </thead>
    <tbody>
        @foreach($cortes as $c)
            <tr>
                <td>{{$c->no_fabricacion_inicial}}</td>
                <td>{{$c->no_fabricacion_final}}</td>
                <td>{{$c->ensamble}}</td>
                <td class="text-center">
                    <input type="checkbox" name="corte_imprimir_{{$c->id}}" id="corte_imprimir_{{$c->id}}" data-corte="{{$c->id}}" class="corte_imprimir">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="col-xs-12 margin-bottom-30 margin-top-20 no-padding">
    <div class="col-xs-6 padding-5"><a href="#!" class="btn btn-primary col-xs-12" id="btn-certificado-calidad">Certificado de calidad</a></div>
    <div class="col-xs-6 padding-5"><a href="#!" class="btn btn-primary col-xs-12" id="btn-registro-hermeticidad">Registro de hermeticidad</a></div>
    <div class="col-xs-6 padding-5"><a href="#!" class="btn btn-primary col-xs-12" id="btn-liberacion-mdt">Liberación MDT</a></div>
    <div class="col-xs-6 padding-5"><a href="#!" class="btn btn-primary col-xs-12" id="btn-liberacion-tanques">Liberación tanques</a></div>
</div>