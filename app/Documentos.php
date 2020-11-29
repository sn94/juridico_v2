<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "documentos";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'NOMBRE','UBICACION' ,  'ABOGADO'];

    public $timestamps = true;
 
 

}