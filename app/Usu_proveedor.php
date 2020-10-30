<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
 

class Usu_proveedor extends Model
{ 
    protected $table="usu_proveedor";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

 

     protected $connection= "principal";
     
    protected $primaryKey = 'IDNRO';
    protected $fillable = [
        'NICK', 'PASS' , 'EMAIL',
    ];

    public $timestamps = true;

}
