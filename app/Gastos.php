<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gastos extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "gastos";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'CODIGO','FECHA','NUMERO','DETALLE1','DETALLE2' , 'IMPORTE', 'ID_DEMA'];

    public $timestamps = true;

 
 

    public function codigo_gasto()
    {
        return $this->belongsTo('App\Codigo_gasto', 'IDNRO', 'CODIGO');
    }

}