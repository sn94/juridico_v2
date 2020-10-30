<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovCuentaJudicial extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "mov_cta_judicial";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'CTA_JUDICIAL','TIPO_CTA','TIPO_MOVI','FECHA','TIPO_EXT','IMPORTE','CHEQUE_NRO', 'CUENTA'];

    public $timestamps = false;

 
    public function  ctajudicial(){
        return $this->belongsTo('App\CuentaJudicial', "IDNRO", "CTA_JUDICIAL");
    }

}