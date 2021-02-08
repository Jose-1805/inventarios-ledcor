<?php

namespace InventariosLedcor\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use InventariosLedcor\Models\Correo;

class General extends Mailable
{
    use Queueable, SerializesModels;
    public $correo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Correo $correo)
    {
        $this->correo = $correo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->correo->asunto)
            ->markdown('emails.general');
    }
}
