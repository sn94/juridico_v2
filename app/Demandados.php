<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demandados extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "demandado";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [ 'TITULAR','DOMICILIO','CI','TELEFONO','CELULAR', 'CELULAR2','TRABAJO','LABORAL','TEL_TRABAJ','GARANTE',
    'CI_GARANTE','TEL_GARANT','DOM_GARANT','TRABAJO_G','LABORAL_G','TEL_LAB_G',
    'DOC_DENUNC','LOCALIDAD','DOC_DEN_GA','LOCALIDA_G', 'CEL_GARANT',
'GARANTE_3','CI_GAR_3', 'DIR_GAR_3', 'TEL_GAR_3' , 'CEL_GAR_3 ',  'ABOGADO'];

    public $timestamps = false;
    
}