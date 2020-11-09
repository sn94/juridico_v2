<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagosServicio extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "pagos";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'FECHA','CLIENTE','COMPROBANTE'];

    public $timestamps = false;
    
}