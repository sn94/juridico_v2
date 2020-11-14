<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abogados extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "abogados";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'NOMBRE','APELLIDO','DOMICILIO','TELEFONO','CELULAR', 'CEDULA' ,  'EMAIL', 'PIN'];

    public $timestamps = true;
 
 

}