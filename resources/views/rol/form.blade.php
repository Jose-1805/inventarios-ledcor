<?php
        if(!isset($rol))$rol = new \InventariosLedcor\Models\Rol();
?>
<div class="row">
        <div class="form-group col-xs-12 col-md-6">
            {!! Form::label('nombre','Nombre') !!}
            {!! Form::text('nombre',$rol->nombre,['id'=>'nombre','class'=>'form-control','placeholder'=>'Nombre del rol']) !!}
            {!! Form::hidden('rol',$rol->id,['id'=>'rol']) !!}
        </div>

        <div class="col-xs-12">
                @if(!$rol->exists && \InventariosLedcor\Models\Rol::where('operarios','si')->count() == 0 || ($rol->exists && $rol->operarios == 'si'))
                        <div class="form-group">
                                <div class="checkbox">
                                        <label>
                                                <input type="checkbox" name="operarios" value="si" {{ $rol->operarios == 'si' ? 'checked' : '' }} {{$rol->exists ? 'disabled="disabled"':''}}> Rol asignable a operarios
                                        </label>
                                </div>
                        </div>
                @endif
                <p>Selecciones los privilegios permitidos para el rol</p>
                <a class="btn btn-default btn-seleccionar">Seleccionar todo</a>
                <a class="btn btn-default btn-deseleccionar">Deseleccionar todo</a>
                <table class="table">
                        <thead>
                                <th >Módulos</th>
                                @foreach(\InventariosLedcor\Models\Funcion::get() as $f)
                                        <th data-class="{{$f->id}}" class="text-center cursor_pointer column-selector" title="Todas las casillas">{{$f->nombre}}</th>
                                @endforeach
                        </thead>
                        <tbody>
                                @foreach(\InventariosLedcor\Models\Modulo::orderBy('nombre')->get() as $m)
                                        @if($m->funciones()->get()->count() && $m->estado == 'Activo')
                                        <tr>
                                                <td>{{$m->etiqueta}}</td>
                                                @foreach(\InventariosLedcor\Models\Funcion::get() as $f)
                                                        <th class="text-center">
                                                                @if($m->tieneFuncion($f->id))
                                                                <label>
                                                                        <input type="checkbox" name="privilegios[]" class="column-{{$f->id}}" value="{{$m->identificador.','.$f->identificador}}" @if($rol->exists && $rol->tieneFuncion($m->identificador,$f->identificador)) checked="checked" @endif>
                                                                </label>
                                                                @endif
                                                        </th>
                                                @endforeach

                                        </tr>
                                        @endif
                                @endforeach
                        </tbody>
                </table>
        </div>
</div>