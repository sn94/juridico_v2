<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arreglo_extra_cuotas extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "arr_extr_cuotas";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [ 'ARREGLO' , 'NUMERO', 'VENCIMIENTO','IMPORTE','FECHA_PAGO' ]; 

    public $timestamps = false;

 


    //En minusculas el nombre del modelo que se referencia, para el nombre de la funcion
    public function arreglo_extrajudicial()
    {
        //                                                  FOREIGN KEY     PRIMARYKEY
        return $this->belongsTo('App\Arreglo_extrajudicial', 'ARREGLO', 'IDNRO');
    }
    

}