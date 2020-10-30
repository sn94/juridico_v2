<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codigo_gasto extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "cod_gasto";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [  'CODIGO', 'DESCRIPCION'];

    public $timestamps = true;

    public function gastos()
    {
        return $this->hasMany('App\Gastos', 'CODIGO', 'IDNRO');
    }
    
}