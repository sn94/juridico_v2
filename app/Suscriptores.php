<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suscriptores extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
 
    protected $connection= "principal";
    
    protected $table= "suscriptores";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'RAZON_SOCIAL','EMAIL', 'TELEFONO', 'CELULAR', 'PLAN', 'ULT_FECHA_PAGO',   'DNS', 'DIAS', 
    'HABILITADO', 'APROBADO'];

    public $timestamps = true;
 

}