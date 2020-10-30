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


public function nick_existe( $nick){
   $res=  Usu_proveedor::where("NICK",  $nick)->first();
   if( is_null(  $res) ) return response()->json( ['NO' =>  'Nick disponible']);
   else return response()->json( ['SI' =>  'Nick ya disponible']);
}
    
public function nuevo( Request $request){
    if(  request()->getMethod()=="POST")  {//hay datos 
       
        //Quitar el campo _token
        $Params=  $request->input(); 
         $Params['PASS']= Hash::make(  $Params['PASS']);
         DB::beginTransaction();
        try{      
             $r= new Usu_proveedor(); 
             $r->fill(  $Params  );  
             $r->save();
             DB::commit();
             return response()->json(   array( 'idnro'=> $r->IDNRO )  ); 
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(   array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e")  ); 
        }   
    }
    else  {   

       
        if( request()->ajax())
        return view("0provider.usuario.form");
        else 
       { $us= Usu_proveedor::paginate(10);
        return view('0provider.usuario.create' , ['usuarios'=> $us]);}
       }/** */    
}
   

   
 


public function editar( Request $request, $id=0){
    if( ! strcasecmp(  $request->method() , "post"))  {//hay datos 
        //Quitar el campo _token
        $Params=  $request->input(); 
        //Devuelve todo elemento de Params que no este presente en el segundo argumento
        $Newparams= array_udiff_assoc(  $Params,  array("_token"=> $Params["_token"] ),function($ar1, $ar2){
            if( $ar1 == $ar2) return 0;    else 1; 
         } ); 

            //hashing
        $Newparams['pass']= Hash::make($request->pass);
         DB::beginTransaction();
        try{
            
             $r= Usu_proveedor::find( $request->input("IDNRO") ); 
             $r->fill(  $Newparams  );  
             $r->save();
             echo json_encode( array('ok'=>  "ACTUALIZADO"  ));    
            DB::commit();
       
        } catch (\Exception $e) {
            DB::rollback();
            echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
        }   
    }
    else  {   
        $dato= Usu_proveedor::find( $id );
        return view('0provider.form' , ["DATO"=> $dato , "OPERACION"=>"M"]  );
     }/** */    
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

     if(  is_null( $request->input("nick") ) ){//SI no hay parametros
        //MOSTRAR FORM
     
        return view("0provider.login");

     }else{
            //DATOS DE SESIOn
            $usr= $request->input("nick");
            //OBTENER NRO REG DE USUARIO a partir de su NICK
            $d_u= Usu_proveedor::where("nick", $usr)->first();
            //VERIFICAR EXISTENCIA DE USUARIO
            if( is_null( $d_u) ){//no existe
                return view("0provider.login", array("errorSesion"=> "El usuario ->$usr<- no existe") );
            }else{
                $id_usr=$d_u->IDNRO; 
                $nom= $d_u->nick; 
                $pass= $request->input("pass");
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