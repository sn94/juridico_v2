<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Banc_mov extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "ctasban_mov";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [ 'IDBANCO', 'FECHA','NUMERO','CODIGO','IMPORTE','CONCEPTO','PROJECTO','NRO_RECIBO','PROVEEDOR','TIPO_MOV' ];

    public $timestamps = false;

 

    public function  bancos(){
        return $this->belongsTo('App\Bancos', "IDNRO", "IDBANCO");
    }
}