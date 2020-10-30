<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan_servicio extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "planes";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [   'DESCR', 'MAX_USERS', 'PRECIO', 'DURACION'];

    public $timestamps = true;

   
    
}