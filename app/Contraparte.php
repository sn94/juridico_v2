<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contraparte extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "inter_contraparte";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'ABOGADO', 'DIRLEGAL', 'OBS'];

    public $timestamps = false;
    
}