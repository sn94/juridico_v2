<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{

      /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table= "notificaciones";

    protected $primaryKey = 'IDNRO';

    protected $fillable= [   'CI','PRESENTADO','PROVI_1','NOTIFI_1','ADJ_AI','AI_NRO','AI_FECHA','INTIMACI_1',
    'INTIMACI_2','CITACION','PROVI_CITA','NOTIFI_2','ADJ_SD','SD_NRO','SD_FECHA','NOTIFI_3','ADJ_LIQUI',
    'PROVI_2', 'NOTIFI_4', 'ADJ_APROBA','APROB_IMPO','ADJ_OFICIO', 'NOTIFI_5',  'EMBARGO_N','EMB_FECHA','OTRA_INSTI','SALDO_LIQUI',
    'LIQUIDACIO','IMPORT_LIQUI','APROBA_AI','APRO_FECHA','HONO_MAS_IVA','NOTIFI_LIQUI','CON_DEPOSITO',
     'OBSERVACION', 'NOTIFI_HONOIVA', 'ADJ_INFO_FECHA', 'INFO_AUTOMOTOR', 'INFO_AUTOVEHIC','INFO_AUTOCHASI',
     'INFO_INMUEBLES', 'INFO_INMUFINCA','INFO_INMUDISTRI','EMB_INMUEBLE','EMB_VEHICULO','ADJ_INHI_FEC',
     'INHI_AI_NRO', 'INHI_AI_FEC', 'INHI_NRO', 'FEC_INIVI', 'FEC_FINIQU', 'SD_FINIQUI','ARREGLO_EX',
     //NUEVOS
     'NOTIFI1_AI_TIT' ,'NOTIFI1_AI_GAR', 'NOTIFI2_AI_TIT', 'NOTIFI2_AI_GAR', 'FLAG'
 ];




 /*
  'NOTIFI_4','SALDO_EXT',
    'NOTIFI_5','EMBAR_EJEC','SD_FINIQUI','FEC_FINIQU','INIVISION','FEC_INIVI',,'LEVANTA',
    'FEC_LEVANT','DEPOSITADO','EXTRAIDO_C','EXTRAIDO_L',,'EXCEPCION','APELACION','INCIDENTE'
    */
    public $timestamps = false;

 

}