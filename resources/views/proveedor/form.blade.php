<div class="col-xs-12 no-padding">

        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('nombre','Nombre (*)',['class'=>'control-label']) !!}
            {!! Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','maxlength'=>150,'pattern'=>'^[A-z ñ]{1,}$','data-error'=>'Ingrese unicamente letras']) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('alias','Alias (*)',['class'=>'control-label']) !!}
            {!! Form::text('alias',null,['id'=>'alias','class'=>'form-control','maxlength'=>50]) !!}
        </div>

        <div class="col-md-6 col-lg-4 form-group">
            {!! Form::label('direccion','Dirección (*)') !!}
            {!! Form::text('direccion',null,['id'=>'direccion','class'=>'form-control','maxlength'=>250]) !!}
        </div>

        <div class="col-xs-12 margin-top-40">
            <a href="#!" class="cursor_pointer btn-submit btn btn-primary right" id="btn-guardar-proveedor">Guardar</a>
        </div>

</div>