<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecoveryPassword extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */

    protected $connection= "principal";

    
    protected $table= "password_recovery";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'USUARIO','TOKEN','EXPIRA' ];

    public $timestamps = false;


 

}