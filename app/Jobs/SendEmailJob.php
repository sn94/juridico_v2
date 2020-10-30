<?php

namespace App\Jobs;

use App\Mail\AuthAlert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    private $nick="";
    private $peticion="";
    private $email_dest="";
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email_dest, $nick, $peticion)
    {
        $this->nick= $nick;
        $this->peticion= $peticion;
        $this->email_dest= $email_dest;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
    
        $email = new AuthAlert( $this->nick, $this->peticion);

        Mail::to($this->email_dest)->send($email);
    }
}
