<?php
namespace App\Helpers;
use Exception;
use Mockery\Undefined;

class Helper
{
    
    /***
     * Devuelve una cadena numerica con separadores de puntos
     */
    public static function number_f( $ar){

      try{
        $v= floatval( $ar);
        return number_format($v, 0, '', '.');  
      }catch( Exception $err){
        return 0;
      }
      }
//Formato numero decimal de coma  a punto
      public static function fromComaToDot( $ar){
        return str_replace( ",", ".", $ar);
      }



      //Quitar puntos y comas
      public static function cleanNumber( $ar){
        return preg_replace( "/(,|\.)/", "", $ar);
      }

    /***
     * Devuelve una fecha Y-m-d a partir de una fecha d/m/Y
     */
    public static function fecha_f( $fe){ //dma a  amd
        //convertir de d/m/Y a Y/m/d
       if( $fe==""  ) return "";
        $fecha= explode("/",  $fe);
        if( sizeof( $fecha) > 1){

          if( strlen($fecha[2] ) == 4 ){// dia mes anio
            if(  strlen($fecha[1])==1   )  $fecha[1]= "0".$fecha[1];
            if(  strlen($fecha[0])==1   )  $fecha[0]= "0".$fecha[0];
            echo $fecha[2] ."-".$fecha[1]."-".$fecha[0]; 
          }else{
            echo   $fecha[2]."-".$fecha[1]."-". $fecha[0]; 
          }
        }else
        echo $fe;//la fecha esta en otro formato
      }

/**Devuelde de yyyy-mm-dd a dd-mm-yyyy */
      public static function fecha_dma( $fe){ 
        //convertir de d/m/Y a Y/m/d
       if( $fe==""  || $fe =="0000-00-00" ) return "";
      
        $fecha= explode("-",  $fe);
        if( sizeof( $fecha) > 1){
           return   $fecha[2]."/".$fecha[1]."/". $fecha[0]; 
        }else
        return  $fe;//la fecha esta en otro formato
      }


 
      public static function beautyDate( $fecha){
        $retorna="";
        if( $fecha=="") return $retorna;
        try{
          $retorna=\Carbon\Carbon::parse($fecha)->format('d/m/Y');
        }catch(Exception $e)
        {
          $retorna= Helper::fecha_f($fecha);
        }
        return $retorna;
      }




public static   function dayName( $Dia=""){
  $Dia=   $Dia=="" ?  date("N")  : $Dia;
$DiaH="";
switch( $Dia){
    case 1:  $DiaH= "lunes";break;
    case 2:  $DiaH= "martes";break;
    case 3:  $DiaH= "miercoles";break;
    case 4:  $DiaH= "jueves";break;
    case 5:  $DiaH= "viernes";break;
    case 6:  $DiaH= "sabado";break;
    case 7:  $DiaH= "domingo";break;
}  return   $DiaH;
}
      
public  static function monthDescr($m=""){
  $m=  $m== ""? date("n"): $m;
  $r="";
  switch( $m){
      case 1: return "Enero";break;
      case 2: return "Febrero";break;
      case 3: return "Marzo";break;
      case 4: return "Abril";break;
      case 5: return "Mayo";break;
      case 6: return "Junio";break;
      case 7: return "Julio";break;
      case 8: return "Agosto";break;
      case 9: return "Septiembre";break;
      case 10: return "Octubre";break;
      case 11: return "Noviembre";break;
      case 12: return "Diciembre";break;
  }  return $r;
}


public static function fechaDescriptiva(){
  $dia= Helper::dayName();
  $mes= Helper::monthDescr();
  $anio= date("Y");
  $fechacompleta=  $dia.", ".(date("d"))." de $mes del $anio";
  return $fechacompleta;
}





public static function generar_password(){
     //Carácteres para la contraseña
     $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
     $password = "";
     //Reconstruimos la contraseña segun la longitud que se quiera
     for($i=0;$i<6;$i++) {
        //obtenemos un caracter aleatorio escogido de la cadena de caracteres
        $password .= substr($str,rand(0,62),1);
     }
     //Mostramos la contraseña generada
     return $password;
}



 


}