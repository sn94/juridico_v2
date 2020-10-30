<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

  


class AuthAlert extends Mailable
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

    public function __construct( $Nick, $peticion)
    {
        $this->Nick= $Nick;
        $this->Peticion= $peticion;
        $this->Timestamp= Date("j/m/Y  h:i A");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject('NOTIFICACIÓN DE SEGURIDAD')->from('info@clientez.com')
                ->view('auth.auth_alert',  
                 [ 'nick'=> $this->Nick, 'peticion'=> $this->Peticion,
                  "timestamp"=> $this->Timestamp  ]);
       // return $this->view('view.name');
    }
}
