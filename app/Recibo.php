<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "recibo";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'IDNRO',  'IMPORTE','DEUDOR','ARREGLO','CONCEPTO','FECHA_L','created_at' ];
 
    public $timestamps = false;

}