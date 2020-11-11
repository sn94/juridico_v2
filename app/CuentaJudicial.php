<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaJudicial extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "cuenta_judicial";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'ID_DEMA','CI','CTA_JUDICI','BANCO','TIPO_CTA','TIPO_MOVI','FECHA','TIPO_EXT','IMPORTE',
    'CHEQUE_NRO','TITULAR', 'ABOGADO'];

    public $timestamps = false;

 
    
    public function movcuentajudicial(){
        return $this->hasMany("App\MovCuentaJudicial", "CTA_JUDICIAL", "IDNRO");
    }

}