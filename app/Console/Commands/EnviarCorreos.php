<?php

namespace InventariosLedcor\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use InventariosLedcor\Mail\General;
use InventariosLedcor\Models\Correo;
use InventariosLedcor\User;

class EnviarCorreos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar-correos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envio de correos almacenados en la base de datos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $registro = false;

        if($registro) {
            echo 'Registrando correo';
            $user = User::find(11);
            Correo::prueba($user);
        }else {

            //Se envian todos los correos prioritarios
            $correos = Correo::where('estado', 'pendiente')->where('tipo', 'prioritario')->get();
            echo count($correos) . ' Prioritarios ...';
            foreach ($correos as $correo) {
                //remitentes relacionados por tablas de la base de datos
                $remitentes = $correo->usuarios;

                //se establecen los remitentes registrados unicamente con correos
                //en el registro del correo
                if ($correo->correos_destinatarios) {
                    $correos_destinatarios = explode(';', $correo->correos_destinatarios);
                    foreach ($correos_destinatarios as $c) {
                        $user = new User();
                        $user->email = $c;
                        $remitentes->push($user);
                    }
                }
                Mail::to($remitentes)->send(new General($correo));
                $correo->estado = 'enviado';
                $correo->save();
            }

            //se envian todos los correos programados
            $correos = Correo::where('estado', 'pendiente')->where('tipo', 'programado')->where('fecha_programada', '<=', date('Y-m-d'))->get();
            echo count($correos) . ' Programados ...';
            foreach ($correos as $correo) {
                //remitentes relacionados por tablas de la base de datos
                $remitentes = $correo->usuarios;

                //se establecen los remitentes registrados unicamente con correos
                //en el registro del correo
                if ($correo->correos_destinatarios) {
                    $correos_destinatarios = explode(';', $correo->correos_destinatarios);
                    foreach ($correos_destinatarios as $c) {
                        $user = new User();
                        $user->email = $c;
                        $remitentes->push($user);
                    }
                }
                Mail::to($remitentes)->send(new General($correo));
                $correo->estado = 'enviado';
                $correo->save();
            }
        }
    }
}
