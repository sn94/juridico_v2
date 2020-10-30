<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ODemanda extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "odemanda";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'NOMBRES','TELEFONO','OBS'];

    public $timestamps = false;
    
}