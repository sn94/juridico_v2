<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Honorarios extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "honorarios";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [ 'IDNRO', 'ADJ_HONORARIOS','AI_NRO','FECHA','GS','NOTIFI_1','ADJ_CITA','PROVIDENCIA',
    'NOTIFI_2','ADJ_SD','SD_NRO','FECHA_SD','NOTIFI_3','FECHA_EMB','GS2', 'INSTI', 'ABOGADO'];

    public $timestamps = false;
    
}