<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "obs_demanda";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'CI','OBS_PREVEN','OBS_EJECUT'];

    public $timestamps = false;
    
}