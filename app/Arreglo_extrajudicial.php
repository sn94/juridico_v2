<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arreglo_extrajudicial extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "arreglo_extrajudicial";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'FECHA','TIPO','IMPORTE_T','CANT_CUOTAS' ]; 

    public $timestamps = true;

 

//Utilizar como nombre de funcion
//En minusculas el nombre del modelo que se esta relacionando
    public function arreglo_extra_cuotas()
    {                                                       //FOREIGN KEY   LOCAL KEY
        return $this->hasMany('App\Arreglo_extra_cuotas',  'ARREGLO', 'IDNRO');
    }



}