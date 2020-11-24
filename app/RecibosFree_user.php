<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecibosFree_user extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "freeuser";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [ 'NICK', 'NOMBRES', 'APELLIDOS','EMAIL', 'PASS', 'DIRECCION', 'TELEFONO'  ];

    public $timestamps = false;
 
 

}