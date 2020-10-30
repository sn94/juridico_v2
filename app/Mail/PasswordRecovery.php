<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

  


class PasswordRecovery extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
 
     private $Timestamp= null;

    public function __construct( $recoverylink)
    {
        $this->recovery_link=    $recoverylink;
        $this->Timestamp= Date("j/m/Y  h:i A");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject('RECUPERACIÓN DE CONTRASEÑA')->from('info@clientez.com')
                ->view('auth.passwrecovery',  
                 [ 
                    "recovery_link"=> $this->recovery_link,
                  "timestamp"=> $this->Timestamp  ]);
       // return $this->view('view.name');
    }
}
