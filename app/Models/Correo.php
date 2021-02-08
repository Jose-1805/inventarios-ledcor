<?php

namespace InventariosLedcor\Models;

use InventariosLedcor\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Correo extends Model
{
    protected $table = 'correos';
    protected $fillable = [
        'tipo',
        'fecha_programada',
        'estado',
        'asunto',
        'titulo',
        'mensaje',
        'boton',
        'texto_boton',
        'url_boton',
        'correos_destinatarios'
    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'correos_users', 'correo_id', 'user_id');
    }


    /**
     * Valida y registra la información de un correo en la db
     *
     * @param $tipo => tipo de correo 'programado', 'prioritario'
     * @param null $fecha_programada => Fecha de envio si el tipo es programado
     * @param string $asunto => texto
     * @param string $titulo => texto
     * @param string $mensaje => html
     * @param bool $boton => si el correo debe tener un botón
     * @param string $texto_boton
     * @param string $url_boton
     * @param array $remitentes => array con ids de remitentes del correo
     * @return array => ['success'=>true] -> correo registrado con éxito ******* ['success'=>false,'error'=>''] -> correo con errores y detalle del error
     */
    private static function crear($tipo, $fecha_programada = null, $asunto = '', $titulo = '', $mensaje = '', $boton = false, $texto_boton = '', $url_boton = '', Collection $remitentes)
    {
        //validacion de correo de remitentes
        foreach ($remitentes as $remitente) {
            if(!filter_var($remitente->email,FILTER_VALIDATE_EMAIL)){
                return [
                    'success' => false,
                    'error' => 'El email "'.$remitente->email.'" no contiene un formato correcto.'
                ];
            }
        }


        $correo = new Correo();
        //validacion de tipo de correo
        if ($tipo != 'programado' && $tipo != 'prioritario') {
            return [
                'success' => false,
                'error' => 'El tipo de correo debe estar entre los valores (programado o prioritario)'
            ];
        }
        $correo->tipo = $tipo;

        //validacion de fecha
        if ($tipo == 'programado') {
            if ($fecha_programada == null) {
                return [
                    'success' => false,
                    'error' => 'La fecha de envio programado es obligatoria cuando el tipo de correo es "programado"'
                ];
            }
            $hoy = strtotime(date('Y-m-d'));
            $fecha_programada_time = strtotime($fecha_programada);
            if ($hoy > $fecha_programada_time) {
                return [
                    'success' => false,
                    'error' => 'La fecha de envío programado no debe ser menor a la fecha actual'
                ];
            }

            $correo->fecha_programada = $fecha_programada;
        }

        //mensaje obligatotio
        if ($mensaje == '') {
            return [
                'success' => false,
                'error' => 'El mensaje del correo es obligatorio'
            ];
        }

        $correo->mensaje = $mensaje;

        if($asunto != null)
            $correo->asunto = $asunto;

        if($titulo != null)
            $correo->titulo = $titulo;

        if($boton){
            $correo->boton = 'si';
            $correo->texto_boton = $texto_boton;
            $correo->url_boton = $url_boton;
        }

        //validacion de remitentes
        if (!count($remitentes)) {
            return [
                'success' => false,
                'error' => 'La información de los remitentes es obligatoria'
            ];
        }


        DB::beginTransaction();
        $correo->save();
        $text_remitentes = '';
        foreach ($remitentes as $remitente) {
                if($remitente->exists)
                    $correo->usuarios()->save($remitente);
                else
                    $text_remitentes .= $remitente->email.';';
        }
        if($text_remitentes != ''){
            $correo->correos_destinatarios = trim($text_remitentes,';');
            $correo->save();
        }
        DB::commit();
        return ['success'=>true];
    }

    public static function prueba(User $usuario){

        $tipo = 'prioritario';
        //$tipo = 'programado';
        $asunto = 'Prueba';
        $titulo = 'PRUEBA';


        $mensaje = view('emails.contenidos.prueba')
            ->with('usuario',$usuario)
            ->render();

        return self::crear($tipo,date('Y-m-d'),$asunto,$titulo,$mensaje,false,null,null,new Collection([$usuario]));
    }

    public static function solicitudMaterial($solicitud,$materiales,$para,$cc,$asunto){

        $tipo = 'prioritario';
        //$tipo = 'programado';
        $titulo = 'Solicitud de material';


        $mensaje = view('solicitudmaterial.contenido_mail')
            ->with('solicitud',$solicitud)
            ->with('materiales',$materiales)
            ->render();

        $usuario = new User();
        $usuario->email = $para;

        $usuario_cc = new User();
        $usuario_cc->email = $para;

        return self::crear($tipo,date('Y-m-d'),$asunto,$titulo,$mensaje,false,null,null,new Collection([$usuario,$usuario_cc]));
    }
}