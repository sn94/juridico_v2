<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table="usuarios";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'IDNRO';
    protected $fillable = [
        'nick', 'tipo', 'pass', 'email', 'ABOGADO'
    ];

    public $timestamps = true;

}
