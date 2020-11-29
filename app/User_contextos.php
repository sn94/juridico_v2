<?php



namespace App;
 

use Illuminate\Database\Eloquent\Model;

 

class User_contextos extends Model
{ 

    protected $table="usu_contextos";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'IDNRO';
    protected $fillable = [ 'USER', 'ABOGADO' ];

    public $timestamps = false;

}
