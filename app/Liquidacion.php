<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "liquida";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [ 'ID_DEMA','CTA_BANCO','CAPITAL','ULT_PAGO','ULT_CHEQUE','CTA_MESES','INT_X_MES','IMP_INTERE',
    'GAST_NOTIF','GAST_NOTIG','GAST_EMBAR','GAST_INTIM','HONO_PORCE','HONORARIOS','IVA','LIQUIDACIO','TOTAL','EXTRAIDO',
    'SALDO','EXT_LIQUID','NEW_SALDO','TITULAR', 'ABOGADO' ];
    

    public $timestamps = false;

 

}