<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filtros extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "filtros";

    protected $primaryKey = 'NRO';

    protected $fillable= [  'NOMBRE','FILTRO', 'ABOGADO'];

    public $timestamps = false;
    
}