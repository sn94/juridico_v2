<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

  


class CredencialesCliente extends Mailable
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

    public function __construct( $Nick, $pass)
    {
        $this->Nick= $Nick;
        $this->Password= $pass;
        $this->Timestamp= Date("j/m/Y  h:i A");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject('BIENVENIDO AL SISTEMA')->from('info@clientez.com')
                ->view('0provider.mailcredencial',  
                 [ 'nick'=> $this->Nick, 'password'=> $this->Password,
                  "timestamp"=> $this->Timestamp  ]);
       // return $this->view('view.name');
    }
}
