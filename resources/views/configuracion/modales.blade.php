<div id="modal-contrasena" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="mySmallModalLabel">Cambiar contraseña</h4>
            </div>
            <div class="modal-body row">
                <div class="col-xs-12">
                    @include('layouts.alertas',['id_contenedor'=>'alertas-cambiar-password'])
                </div>
                {!! Form::open(['id'=>'form-cambio-password']) !!}
                    <div class="col-xs-12 form-group">
                        {!! Form::label('password','Contraseña nueva') !!}
                        {!! Form::password('password',['id'=>'password','class'=>'form-control']) !!}
                    </div>
                    <div class="col-xs-12 form-group">
                        {!! Form::label('password_confirm','Confirme su Contraseña') !!}
                        {!! Form::password('password_confirm',['id'=>'password_confirm','class'=>'form-control']) !!}
                    </div>
                    <div class="col-xs-12 form-group">
                        {!! Form::label('password_old','Contraseña antigua') !!}
                        {!! Form::password('password_old',['id'=>'password_old','class'=>'form-control']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                <a class="btn btn-sm btn-default" data-dismiss="modal">Cancelar</a>
                <a class="btn btn-sm btn-primary" id="btn-cambiar-contrasena">Guardar</a>
            </div>
        </div>
    </div>
</div>