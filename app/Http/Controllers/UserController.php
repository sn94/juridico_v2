<?php

namespace App\Http\Controllers;

use App\Demanda;
use App\Http\Controllers\Controller;
use App\Mail\AuthAlert;
use App\Mail\PasswordRecovery;
use App\ODemanda;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   
use App\Parametros;
use App\RecoveryPassword;
use App\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
   
// echo $request->session()->get('nick');
    

public function index(){

        
        //Lista odemandas
        $lst_od= User::get(); 
        return view('auth.index',  ['users'=> $lst_od  , "OPERACION"=>"A"] );
} 




    
public function agregar( Request $request){
    if( ! strcasecmp(  $request->method() , "post"))  {//hay datos 
        //Quitar el campo _token
        $Params=  $request->input(); 
        //Devuelve todo elemento de Params que no este presente en el segundo argumento
        $Newparams= array_udiff_assoc(  $Params,  array("_token"=> $Params["_token"] ),function($ar1, $ar2){
            if( $ar1 == $ar2) return 0;    else 1; 
         } ); 
         $Newparams['pass']= Hash::make($request->pass);
         DB::beginTransaction();
        try{     

            //hashing
            $request->pass= Hash::make($request->pass);
             $r= new User(); 
             $r->fill(  $Newparams  );  
             $r->save();
             echo json_encode( array('ok'=>  "GUARDADO"  ));    
        
        DB::commit();
       
        } catch (\Exception $e) {
            DB::rollback();
            echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
        }   
    }
    else  {   
        
        //Lista odemandas
        $lst_od= User::get();
        return view('auth.form' );
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
            
             $r= User::find( $request->input("IDNRO") ); 
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
        $dato= User::find( $id );
        return view('auth.form' , ["DATO"=> $dato , "OPERACION"=>"M"]  );
     }/** */    
 }


public function borrar( $id){
   if(  User::find($id)->delete() ) echo json_encode( array('ok'=>  "BORRADO"  ) );
   else json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos") );

}

public function list(){
    $ls= User::get();
    return view('auth.grilla' , ["users"=>  $ls]);
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


 


private function get_system_id( $nick ){
$parts=  explode("_", $nick);
$id=  $parts[0];
return $id;
}

 


private function obtenerConexion(  $nick  ){
    $systemid=  $this->get_system_id( $nick);
    $DataBaseName= "cli_".$systemid;
    
    $configDb = array(
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' =>  $DataBaseName,
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
    );
    Config::set('database.connections.mysql', $configDb);
   //$conexionSQL = DB::connection('mysql');
   return $systemid;
}




public function validar_existencia_usuario(  $usr){
    $systemid= $this->obtenerConexion(  $usr);

    //OBTENER NRO REG DE USUARIO a partir de su NICK
    $d_u= null;
    try{
        $d_u= User::where("nick", $usr)->first();
        return response()->json( ["ok"=>  "Registrado"]);
    }catch( Exception $ex) {
        return response()->json( ["error"=>  "Usted no está registrado"]);
    }
}

public function sign_in( Request $request){
     
    
   // ** End config */

     if(  is_null( $request->input("nick") ) ){//SI no hay parametros
        //MOSTRAR FORM
      
        return view("auth.login");

     }else{
            //DATOS DE SESIOn
            $usr= $request->input("nick");
            //Identificar el sistema al cual pertenece
            //Extraer Id
            //Crear conexion pertinente
            $systemid= $this->obtenerConexion(  $usr);

            //OBTENER NRO REG DE USUARIO a partir de su NICK
            $d_u= null;
            try{
                $d_u= User::where("nick", $usr)->first();
            }catch( Exception $ex) {
                return response()->json( ["error"=>  "Usted no está registrado"]);
            }
            //VERIFICAR EXISTENCIA DE USUARIO
            if( is_null( $d_u) ){//no existe
                return view("auth.login", array( "nick"=> $usr,   "errorSesion"=> "El usuario ->$usr<- no existe") );
            }else{
                $id_usr=$d_u->IDNRO; 
                $nom= $d_u->nick; 
                $pass= $request->input("pass");
                $tipo= $d_u->tipo; 

                // VERIFICACION DE contrasenha correcta
                if( $this->correctPassword( $pass, $usr) ){
                    $SesionDatos = array( 	'id' => $id_usr, 'nick'  => $usr, 'tipo' => $tipo, 'system'=> $systemid);
                    // Via a request instance... 
                    session( $SesionDatos); 

                    //Notificar inicio de sesion
                    //valente.py@hotmail.com
                   // explode(',', env('ADMIN_EMAILS'));
                   $UserAgent= $request->header('User-Agent') ;
                   $Ip= $request->ip(); 
                   $DatoParametros=  Parametros::first();
                   $MailControl=  is_null($DatoParametros) ?  "" :  $DatoParametros->EMAIL;
                   if(  $MailControl !=  ""){
                    try{
                        Mail::to([ $MailControl]) 
                        //->queue(   new AuthAlert(  $usr,  ["user-agent"=>$UserAgent, "ip"=>$Ip] ) );
                       ->send(  new AuthAlert(  $usr,   ["user-agent"=>$UserAgent, "ip"=>$Ip]  ) );
                      }catch( Exception $e){}
                   }//end empty email control
                 
                

                return redirect(  url("/") ); 
                }else{
                //	echo json_encode(  array('error' => "Clave incorrecta" )); 
                    return view("auth.login", array("errorSesion"=> "Clave incorrecta") );
                }
            }//end else
            
     }//END ANALISIS DE PARAMETROS
}//END SIGN IN


private function correctPassword( $entrada, $nick){
    $hashedPassword=User::where("nick", $nick)->first()->pass; 
    return Hash::check( $entrada, $hashedPassword);
   
}
 

public function sign_out(){
    session()->flush(); 
    return redirect(    url("signin")   ); 
}

 

//Generar el link de recuperacion
public function recovery_password(){

    if(  request()->isMethod("POST")){
        $nick_rec= request()->input("NICK");
        $email_rec= request()->input("EMAIL");
        //identificar usuario
        $this->obtenerConexion(  $nick_rec);

        $data= User::where( "email",  $email_rec)->first();
        if(  is_null($data)){
            return view("auth.recovery_password", ['MENSAJE'=>'ESA DIRECCION DE CORREO NO ESTA REGISTRADA']);
        }else
        {
            //Generar nueva contrasenha
            $rawToken=  $email_rec.time();
            $HashForToken=   Hash::make(  $rawToken );
            $recover= new RecoveryPassword();
            $recover->fill( ['USUARIO'=> $data->IDNRO,  'TOKEN'=> $HashForToken, 'EXPIRA'=> '']) ;
            $recover->save();
            //generar link
            $nuevoLink=  url("recovery-password/".$HashForToken);
            //Enviar correo para recuperacion
            $MailControl=  $data->email;
                   if(  $MailControl !=  ""){
                    try{
                        Mail::to([ $MailControl]) 
                        //->queue(   new AuthAlert(  $usr,  ["user-agent"=>$UserAgent, "ip"=>$Ip] ) );
                       ->send(  new PasswordRecovery( $nuevoLink ) );
                      }catch( Exception $e){}
                   }//end empty email control
            /************* */
            return view("auth.passwrecovery_done", ['EMAIL'=> $MailControl]);
        }
    }else{
        return view("auth.recovery_password");
    }
   

}/*********** */

 

 

}