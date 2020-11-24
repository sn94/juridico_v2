<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecibosFree extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "recibos_free";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [ 'CLIENTE','CONCEPTO','IMPORTE','IMPORTE_L','FREEUSER',  'FECHA'];

    public $timestamps = false;
 
 

}