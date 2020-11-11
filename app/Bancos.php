<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bancos extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "ctas_banco";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'BANCO','TIPO_CTA','CUENTA','TITULAR','SALDO' , 'ABOGADO'];

    public $timestamps = false;


    public function banc_mov(){
        return $this->hasMany("App\Banc_mov", "IDBANCO", "IDNRO");
    }
 

}