@php
$familia = '';
$contador = 0;
@endphp

<p><strong>N° de solicitud: </strong>{{$solicitud->numero}}</p>
<p><strong>Fecha de solicitud: </strong>{{$solicitud->fecha}}</p>

@foreach($materiales as $m)
@if($m->familia != $familia)
@if($contador == 0)
<p class="margin-top-20">Materiales para tipo de familia <strong>{{$m->familia}}</strong></p>
<table class="table dataTable" style="border: 1px solid #dddddd !important; min-width: 100% !important;">
<thead style="background-color: #fafafa !important; border: none !important;display: table-header-group;vertical-align: middle;">
<th style="padding: 10px 10px !important;border: 1px solid #dddddd !important;">Código material</th>
<th style="padding: 10px 10px !important;border: 1px solid #dddddd !important;">Texto breve</th>
<th style="padding: 10px 10px !important;border: 1px solid #dddddd !important;">Cantidad solicitada</th>
<th style="padding: 10px 10px !important;border: 1px solid #dddddd !important;">Lote</th>
<th style="padding: 10px 10px !important;border: 1px solid #dddddd !important;">Observaciones</th>
</thead>

<tbody>
@else
</tbody>
</table>
<p class="margin-top-20">Materiales para tipo de familia <strong>{{$m->familia}}</strong></p>
<table class="table dataTable" style="border: 1px solid #dddddd !important; min-width: 100% !important;">
<thead style="background-color: #fafafa !important; border: none !important;display: table-header-group;vertical-align: middle;">
<th style="padding: 10px 10px !important;border: 1px solid #dddddd !important;">Código material</th>
<th style="padding: 10px 10px !important;border: 1px solid #dddddd !important;">Texto breve</th>
<th style="padding: 10px 10px !important;border: 1px solid #dddddd !important;">Cantidad solicitada</th>
<th style="padding: 10px 10px !important;border: 1px solid #dddddd !important;">Lote</th>
<th style="padding: 10px 10px !important;border: 1px solid #dddddd !important;">Observaciones</th>
</thead>

<tbody>
@endif

@php($contador++)
@php($familia = $m->familia)
@endif

<tr style="background-color: #ffffff;">
<td style="border: 1px solid #dddddd !important;padding: 10px 10px !important;">{{$m->codigo}}</td>
<td style="border: 1px solid #dddddd !important;padding: 10px 10px !important;">{{$m->texto_breve}}</td>
<td style="border: 1px solid #dddddd !important;padding: 10px 10px !important;">{{$m->cantidad_solicitud}}</td>
<td style="border: 1px solid #dddddd !important;padding: 10px 10px !important;">{{$m->lote_solicitud}}</td>
<td style="border: 1px solid #dddddd !important;padding: 10px 10px !important;">{{$m->observaciones_solicitud}}</td>
</tr>

@endforeach
</tbody>
</table>