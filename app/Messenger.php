<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Messenger extends Authenticatable
{
    use Notifiable;

    protected $table="mensajes";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'IDNRO';
    protected $fillable = [
        'DESTINATARIO', 'REMITENTE', 'ASUNTO', 'MENSAJE', 'LEIDO'
    ];

    public $timestamps = true;
 
}
