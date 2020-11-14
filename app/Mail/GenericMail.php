<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

  


class GenericMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


     private $titulo= null;
     private $destinatario= null;
     private $mensaje= null;

    public function __construct( $correo)
    {
        $this->titulo= $correo->titulo;
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
        return  $this->subject(   $this->titulo)->from('info@clientez.com')
                ->view('layouts.generic_mail',  
                 [ 'mensaje'=> $this->mensaje,  ]);
       // return $this->view('view.name');
    }
}
