<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

  


class Credencial_abogado extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */


     private $Nick= null;
     private $Peticion= null;
     private $Timestamp= null;
     private $titulo=  "BIENVENIDO AL SISTEMA";
     private $pin_acceso=  "";

    public function __construct( $Nick, $pass, $titulo= "BIENVENIDO AL SISTEMA", $pin="")
    {
        $this->titulo=  $titulo;
        $this->Nick= $Nick;
        $this->Password= $pass;
        $this->Timestamp= Date("j/m/Y  h:i A");
        $this->pin_acceso=  $pin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject(  $this->titulo )->from('info@clientez.com')
                ->view('abogado.mailcredencial',  
                 [ 'nick'=> $this->Nick, 'password'=> $this->Password, 'pin'=> $this->pin_acceso,
                  "timestamp"=> $this->Timestamp  ]);
       // return $this->view('view.name');
    }
}
