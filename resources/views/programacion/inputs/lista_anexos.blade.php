@if(count($anexos))
    @foreach($anexos as $a)
        <a class="col-xs-12" href="{{url('archivo/'.str_replace('/','-',$a->ubicacion.'-'.$a->nombre))}}" target="_blank">{{$a->nombre}}</a>
    @endforeach
@else
    <p class="text-center">No se encontraron anexos</p>
@endif