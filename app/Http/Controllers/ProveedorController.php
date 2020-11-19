<?php

namespace App\Http\Controllers;


use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\CredencialesCliente;
use App\Suscriptores;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;    
use App\Usu_proveedor;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProveedorController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
  


 



public function usuarios(){
    $us=  Usu_proveedor::paginate(10  );
    if(  request()->ajax())
    return view('0provider.usuario.grilla' , ['usuarios'=>   $us]);
    else
    return view('0provider.usuario.index' , ['usuarios'=>   $us]);
}


public function nick_existe( $nick, $operacion ){
 
   $res=  Usu_proveedor::where("NICK",  $nick)->first();
   if( is_null(  $res) ) return response()->json( ['NO' =>  'Nick disponible']);
   else{

    $usutemp= Usu_proveedor::find(  $res->IDNRO); 
    $nick_en_bd=   $usutemp->NICK; 
    if( $operacion== "M"  &&   $nick_en_bd ==   $nick ) return response()->json( ['NO' =>  'Nick disponible']);
    else return response()->json( ['SI' =>  'Nick ya disponible']);

    }
}
    
 

   
 


public function cargar( Request $request, $id=0){
    if(   $request->isMethod("POST"))  {//hay datos 
        //Quitar el campo _token
        $Params=  $request->input(); 
        //Devuelve todo elemento de Params que no este presente en el segundo argumento
       
            //hashing
        if( array_key_exists("PASS",   $Params) )
        $Params['PASS']= Hash::make($request->PASS);

      


         DB::beginTransaction();
        try{
            
            $r= null;
            if(  $id == 0)  $r= new Usu_proveedor();
            else   $r= Usu_proveedor::find( $request->input("IDNRO") ); 

             $r->fill(  $Params  );  
             $r->save();
             echo json_encode( array('idnro'=>  $r->IDNRO  ));    
            DB::commit();
       
        } catch (\Exception $e) {
            DB::rollback();
            echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
        }   
    }
    else  {   
        if( $id == 0)
        {
            if( request()->ajax())
            return view("0provider.usuario.form");
            else 
           { $us= Usu_proveedor::paginate(10);
            return view('0provider.usuario.create' , ['usuarios'=> $us]);
            }  
        }
        else{
            $dato= Usu_proveedor::find( $id );
            if( request()->ajax())
            return view("0provider.usuario.form",  [ "IDNRO"=> $id, "DATO"=> $dato , "OPERACION"=>"M"]);
            else 
           { $us= Usu_proveedor::paginate(10);
            return view('0provider.usuario.create' , ['usuarios'=> $us]);
            }  
            
        }
       
     }   
 }


public function borrar( $id){
   if(  Usu_proveedor::find($id)->delete() )  
   return response()->json(  array('ok'=>  "BORRADO"  ) );
   else  return response()->json( array( 'error'=> "Hubo un error al guardar uno de los datos") );


}





/**
 * 
 * 
 */
/***Autenticacion */
/**
 * 
 * 
 */


 
public function sign_in( Request $request){
     
    /*Conexion Dinamica a la base de datos *
    $configDb = array(
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'prestasys',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
    );
    Config::set('database.connections.mysql.', "");
    $conexionSQL = DB::connection('mysql');
    dd(  $conexionSQL->select("select * from deudor"));
    /*** End config */

     if(  is_null( $request->input("NICK") ) ){//SI no hay parametros
        //MOSTRAR FORM
     
        return view("0provider.login");

     }else{
            //DATOS DE SESIOn
            $usr= $request->input("NICK");
            //OBTENER NRO REG DE USUARIO a partir de su NICK
            $d_u= Usu_proveedor::where("NICK", $usr)->first();
            
            //VERIFICAR EXISTENCIA DE USUARIO
            if( is_null( $d_u) ){//no existe
                return view("0provider.login", array("errorSesion"=> "El usuario ->$usr<- no existe") );
            }else{
                $id_usr=$d_u->IDNRO; 
                $nom= $d_u->NICK; 
                $pass= $request->input("PASS");
                $tipo= $d_u->tipo; 

                // VERIFICACION DE contrasenha correcta
                if( $this->correctPassword( $pass, $usr) ){
                    $SesionDatos =
                     array( 	'id' => $id_usr, 'nick'  => $usr, 'provider' => true );
                    // Via a request instance... 
                    session( $SesionDatos); 

                    //Notificar inicio de sesion
                    //valente.py@hotmail.com
                   // explode(',', env('ADMIN_EMAILS'));
                  /* $UserAgent= $request->header('User-Agent') ;
                   $Ip= $request->ip(); 
                   $MailControl= Parametros::first()->EMAIL;
                  try{
                    Mail::to([ $MailControl]) 
                    //->queue(   new AuthAlert(  $usr,  ["user-agent"=>$UserAgent, "ip"=>$Ip] ) );
                   ->send(  new AuthAlert(  $usr,   ["user-agent"=>$UserAgent, "ip"=>$Ip]  ) );
                  }catch( Exception $e){}
                  /**Fin Envio de email */

                return redirect(  url("/p") ); 
                }else{
                //	echo json_encode(  array('error' => "Clave incorrecta" )); 
                    return view("0provider.login", array("errorSesion"=> "Clave incorrecta") );
                }
            }//end else
            
     }//END ANALISIS DE PARAMETROS
}//END SIGN IN


private function correctPassword( $entrada, $nick){
    $hashedPassword=Usu_proveedor::where("NICK", $nick)->first()->PASS; 
    return Hash::check( $entrada, $hashedPassword);
   
}
 

public function sign_out(){
    session()->flush(); 
    return redirect(    url("signin/p")   ); 
}

 



 




}