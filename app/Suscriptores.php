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

    protected $fillable= [  'RAZON_SOCIAL','EMAIL', 'TELEFONO', 'CELULAR', 'PLAN',   'DNS', 
    'HABILITADO', 'APROBADO'];

    public $timestamps = true;
 

}