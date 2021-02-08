<?php
    if(!isset($id_contenedor))$id_contenedor="alertas";
?>
<div class="row" id="{{$id_contenedor}}">
    <div class="alert <?php if(!session()->has('msj_success')) {?>hide<?php } ?> col-xs-12 alert-success" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            <?php
                if(session()->has('msj_success')){
            ?>
                {!! session()->get('msj_success')[0] !!}
            <?php
                }
            ?>
        </div>
    </div>

    <div class="alert <?php if(!session()->has('msj_info')) {?>hide<?php } ?> col-xs-12 alert-info" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            <?php
                if(session()->has('msj_info')){
            ?>
                {!! session()->get('msj_info')[0] !!}
            <?php
                }
            ?>
        </div>
    </div>

    <div class="alert <?php if(!session()->has('msj_warning')) {?>hide<?php } ?> col-xs-12 alert-warning" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            <?php
                if(session()->has('msj_warning')){
            ?>
                {!! session()->get('msj_warning')[0] !!}
            <?php
                }
            ?>
        </div>
    </div>

    <div class="alert <?php if(!session()->has('msj_danger')) {?>hide<?php } ?> col-xs-12 alert-danger" role="alert">
        <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
        <div class="mensaje">
            <?php
                if(session()->has('msj_danger')){
            ?>
                {!! session()->get('msj_danger')[0] !!}
            <?php
                }
            ?>
        </div>
    </div>
</div>
<?php
    session()->forget(['msj_success','msj_info','msj_warning','msj_danger']);
?>