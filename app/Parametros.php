<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "parametros";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'INTERES','MORA','IVA','SEGURO','REDONDEO','HONORARIOS','PUNITORIO',
    'GASTOSADMIN','DIASVTO','FACTURA','RECIBO','FECMIN','FECMAX', 'EMAIL', 'SHOW_COUNTERS', 'DEPOSITO_CTA_JUDICI'];


    
    public $timestamps = false;
    
}