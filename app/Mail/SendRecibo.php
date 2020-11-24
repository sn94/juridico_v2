<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

  


class SendRecibo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


     private $titulo= null;
     private $remitente=  null;
     private $destinatario= null;
     private $mensaje= null;

    public function __construct( $correo)
    {
        $this->titulo= $correo->titulo;
        $this->remitente= $correo->remitente;
        $this->destinatario= $correo->destinatario;
        $this->mensaje=  $correo->mensaje;
    }

    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject(   $this->titulo)->from( env("MAIL_USERNAME"))
                ->view('recibos_free.recibo_sent_by_email',  
                 [ 'REMITENTE'=> $this->remitente,  'ENLACE_PDF'=> $this->mensaje ]);
     
    }
}
