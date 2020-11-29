<?php

namespace App\Http\Controllers;

use App\Abogados;
use App\Demanda;
use App\Http\Controllers\Controller;
use App\Mail\AuthAlert;
use App\Mail\Correo;
use App\Mail\CredencialesCliente;
use App\Mail\PasswordRecovery;
use App\ODemanda;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   
use App\Parametros;
use App\RecoveryPassword;
use App\User;
use App\User_contextos;
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

        
    try{
        $this->obtenerConexion();
    }catch( Exception $er){
       return "error al recuperar formulario";
    }
       

    $lst_od= session("tipo")=="SA" ? User::select("usuarios.*", 

    DB::raw("if( usuarios.tipo ='O', CONCAT('OPERADOR - Asist. de Abogado N° ', usuarios.ABOGADO) ,
    if(usuarios.tipo='U', CONCAT('USUARIO - Asist. de Abogado N° ',usuarios.ABOGADO), 
    IF(usuarios.tipo='S', 'SUPERVISOR ABOGADO' , 'SUPER ADMIN' )         ) ) as tipo"),
    DB::raw("if(usuarios.ABOGADO is null, '', 'ABOGADO') as FUNCION"))->get()
    : 
    User::select("usuarios.*", 
    DB::raw("if( usuarios.tipo ='O', 'OPERADOR' , IF(  usuarios.tipo ='U', 'USUARIO', 'SUPERVISOR (Tú)') ) as tipo"),
    DB::raw("if(usuarios.ABOGADO is null, '', 'ABOGADO') as FUNCION"))
    ->where("usuarios.ABOGADO", session("abogado"))-> get()
    ; 


        //Lista odemandas
        if( request()->ajax())
        { 
            return view('auth.grilla' , ["users"=>  $lst_od]);
        }else{
        //registros de abogados
        $abogados_l= Abogados::select("abogados.IDNRO", DB::raw( "concat(  abogados.NOMBRE, concat(' ', abogados.APELLIDO) ) as NOMBRES") )->get();

        return view('auth.index',  ['users'=> $lst_od  ,  'abogados'=> $abogados_l,  "OPERACION"=>"A"] );
        } 
} 




private function enviar_email_credencial( $email, $nick, $pass, $titulo= "BIENVENIDO AL SISTEMA"){
    try{
        Mail::to([ $email]) 
        //->queue(   new AuthAlert(  $usr,  ["Suscriptores-agent"=>$SuscriptoresAgent, "ip"=>$Ip] ) );
    ->send(  new CredencialesCliente(  $nick, $pass, $titulo  ) );
    }catch( Exception $e){}
}




    
public function user_creation_is_alowed(  ){
    //session
    $id_suscrip= session("system");
    $Conn=  DB::connection("principal");
    $res= DB::table("suscriptores")
    ->join("planes", "planes.IDNRO", "suscriptores.PLAN")->select("planes.MAX_USERS")->first();
    if(  is_null($res) ){
return response()->json(  ['error'=> "No existe un registro de Suscripcion al servicio"]);
    }else{ 
         
        $this->obtenerConexion();
        $numero_de_usuarios_actual= User::count();
        if( $res->MAX_USERS <  $numero_de_usuarios_actual) 
        return response()->json(  ['ok'=> "Permitido" ]);
        else return response()->json(  ['error'=> "No permitido. Ya se llego al limite de número de usuarios" ]);
    }
}
public function agregar( Request $request){

    try{
        $this->obtenerConexion();
    }catch( Exception $er){
       return "error al recuperar formulario";
    }

    if( $request->isMethod("POST"))  {//hay datos 
        //Quitar el campo _token
        $Params=  $request->input(); 
        //Devuelve todo elemento de Params que no este presente en el segundo argumento
       
         $Params['pass']= Hash::make($request->pass);
         DB::beginTransaction();
        try{     

            //hashing
            $request->pass= Hash::make($request->pass);
             $r= new User(); 
             $r->fill(  $Params  );  
             $r->save();

             //asignacion de codigo de abogados
             if( array_key_exists("ABOGADO",  $Params) ){
                 foreach( $Params['ABOGADO']  as $abocod){
                     $insta=  new User_contextos();
                     $insta->USER=  $r->IDNRO;
                     $insta->ABOGADO= $abocod;
                     $insta->save();
                 }
             }
             echo json_encode( array('ok'=>  "GUARDADO"  ));    
            DB::commit();
            $correo= new Correo();
            $correo->titulo= "Bienvenido";
            $correo->destinatario=   $Params['email'];
            $correo->mensaje= "Sus ";
            $this->enviar_email_credencial(  $Params['email'],  $Params['nick'], $Params['pass'] );
       
        } catch (\Exception $e) {
            DB::rollback();
            echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
        }   
    }
    else  {   
         
         //registros de abogados
         $abogados_l= Abogados::select("abogados.IDNRO", DB::raw( "concat(  abogados.NOMBRE, concat(' ', abogados.APELLIDO) ) as NOMBRES") )->get();

        return view('auth.form' , ['abogados'=>  $abogados_l]);
       }/** */    
}
   

   
 


public function editar( Request $request, $id=0){

    try{
        $this->obtenerConexion();
    }catch( Exception $er){
       return "error al recuperar formulario";
    }


    if(  $request->isMethod("POST"))  {//hay datos 
        //Quitar el campo _token
        $Params=  $request->input();  

            //hashing
        $raw_pass= "";
        if(  array_key_exists("pass",  $Params )  ){
            $raw_pass= $Params['pass'];
            $Params['pass']= Hash::make($request->pass);
        }
        
        
        try{
             
            DB::beginTransaction();
             $r= User::find( $request->input("IDNRO") ); 
             $r->fill(  $Params  );  
             $r->save();


             
             //asignacion de codigo de abogados
         
             if( array_key_exists("ABOGADO",  $Params) ){
                 User_contextos::where(  "USER",  $request->input("IDNRO"))->delete();
                foreach( $Params['ABOGADO']  as $abocod){
                    $insta=  new User_contextos();
                    $insta->USER=  $r->IDNRO;
                    $insta->ABOGADO= $abocod;
                    $insta->save();
                }
            }


             echo json_encode( array('ok'=>  "ACTUALIZADO"  ));    
            DB::commit();
            if(  array_key_exists("pass",  $Params )  )
            $this->enviar_email_credencial(  $Params['email'],  $Params['nick'], $raw_pass, "CREDENCIALES ACTUALIZADAS");
       
        } catch (\Exception $e) {
            try{ DB::rollback();    echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );}
            catch(Exception $er){     echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );}
         
        }   
    } else {
            try {
                $dato = User::find($id);
                //registros de abogados
                
                $abogados_aso = Abogados::
                select("abogados.IDNRO", DB::raw("concat(  abogados.NOMBRE, concat(' ', abogados.APELLIDO) ) as NOMBRES"),
                DB::raw(" IF( (select ABOGADO FROM usu_contextos WHERE USER=$id AND ABOGADO=abogados.IDNRO) IS NOT NULL, '1','0') as MARCAR") 

                ) ->get()  ;
                  
                return view('auth.form', ["DATO" => $dato, 'abogados' => $abogados_aso, "OPERACION" => "M"]);
            } catch (Exception $er) {
                echo $er. "error al recuperar formulario";
            }
        }
        /** */    
 }


public function borrar( $id){
   if(  User::find($id)->delete() ) echo json_encode( array('ok'=>  "BORRADO"  ) );
   else json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos") );

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

 


 




public function validar_existencia_usuario( $usr){
 
    $systemid= $this->obtenerConexion(  $usr);

    //OBTENER NRO REG DE USUARIO a partir de su NICK
    $d_u= null;
    try{
        $d_u= User::where("nick", $usr)->first();
        return response()->json( ["ok"=>  "Registrado"]);
    }catch( Exception $ex) {
        return response()->json( ["error"=>  "Usted no está registrado".$ex]);
    }
}


public function obtener_id_abogado_asoc(  $idu){
    $usr= User::find(   $idu );
    if( ! is_null($usr) ){

        $list = User_contextos::where("USER", $idu)->get();
         return $list; 
    } return  [];
}

public function sign_in( Request $request){
     
    
   // ** End config */

     if(  is_null( $request->input("nick") ) ){//SI no hay parametros
        //MOSTRAR FORM
      
        return view("auth.login");

     }else{
            //DATOS DE SESIOn
            $usr= $request->input("nick");
            //Identificar el sistema al cual pertenece /Extraer Id Crear conexion pertinente
            
            $systemid= $this->obtenerConexion(  $usr);
 
            //OBTENER NRO REG DE USUARIO a partir de su NICK
            $d_u= null;
            try{
                $d_u= User::where("nick", $usr)->first();
            }catch( Exception $ex) {
                return response()->json( ["error"=>  "Usted no está registrado!!"]);
            }
            //USUARIO PERTENECE A UNA CUENTA HABILITADA? 
            $habilitado=  $this->sistema_habilitado( $systemid , true);
            if(  $habilitado != "")
            return view("auth.login",  [ "errorSesion"=>   $habilitado ]  ); 
            
            $systemid= $this->obtenerConexion(  $usr);

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
                    //Supervisor == ABOGADO
                    if ($tipo == "S")
                    $SesionDatos['abogado'] = $d_u->ABOGADO;
                    else {
                        if ($tipo != "SA") {
                            $id_A = $this->obtener_id_abogado_asoc($d_u->IDNRO);
                            $AbogadosAsig= sizeof($id_A);
                            if ( $AbogadosAsig > 0) {
                                if( $AbogadosAsig == 1 )
                                $SesionDatos['abogado'] = $id_A->IDNRO;
                                 
                            } else
                                return view("auth.login", array("errorSesion" => "Aún no se le ha asignado un código de abogado. Consulte con el administrador"));
                        }
                    }

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
                   } //end empty email control

                    if ($tipo == "SA")
                    return redirect(url("session-abogados"));
                    else
                        return redirect(url("/"));
                        
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

 
public function reset_password(){
    $DATA=  request()->input();
    $usuario=  $DATA['USUARIO'];
    $nueva_pass=  $DATA['PASS1']; 

   try{
    $this->obtenerConexion( $usuario );
    $JuridicoBD= DB::connection("mysql");
    $objetoUser= User::where("nick",  $usuario)->first();
    
    $objetoUser->pass=    Hash::make(  $nueva_pass );
    $objetoUser->save();
   return redirect(  url("signin") ); 
    
   }catch( Exception $ex){   echo "Hubo un error al tratar de actualizar su contraseña";
   }

}
//Generar el link de recuperacion
public function recovery_password(  $token=""){

    if(  request()->isMethod("POST")){
        try{
            $nick_rec= request()->input("NICK");
            $email_rec= request()->input("EMAIL");
            //identificar usuario
            $this->obtenerConexion(  $nick_rec);

            $data= User::where( "email",  $email_rec)->first();
            if(  is_null($data)){
                return view("auth.recovery_password_request", ['MENSAJE'=>'ESA DIRECCION DE CORREO NO ESTA REGISTRADA']);
            }else
            {
                //Generar nueva contrasenha
                $rawToken=  $email_rec.time();
                $HashForToken=   Hash::make(  $rawToken );
                $HashForToken= preg_replace("/\//", "", $HashForToken);
                //fECHA HORA DE EXPIRACION
                
                $ex_Fecha_Actual= date("Y-m-d H:i:s");
                $ex_SumarHoras=  strtotime(  '+1 hour',  strtotime($ex_Fecha_Actual));
                $expiracion=  date("Y-m-d H:i:s",   $ex_SumarHoras);
                
                $recover= new RecoveryPassword();
                $recover->fill( ['USUARIO'=> $nick_rec,  'TOKEN'=> $HashForToken, 'EXPIRA'=> $expiracion]) ;
                $recover->save();
                //generar link
                $nuevoLink=  url("recovery-password")."/$HashForToken";
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
        }catch( Exception $ex){
            return view("auth.recovery_password_request", ['MENSAJE'=> "<p style='color: red; font-weight: 600;'>(Base de datos inexistente). Consulte con su proveedor del servicio</p> $ex"  ]);
             
        }
    }else{
        if( $token == "")
        return view("auth.recovery_password_request");
        else 
        {
            //verificar token 
            //BUSCAR TOKEN
            $recuperacion_reg= RecoveryPassword::where("TOKEN",   $token)->first();
            if( !is_null(  $recuperacion_reg ) ){

                $id_usuario= $recuperacion_reg->USUARIO;
                $fecha_hora_exp=   $recuperacion_reg->EXPIRA;
                $ex_Fecha_Actual=  strtotime(  date("Y-m-d H:i:s") );
                //diferencia
                $expiracionHora= strtotime(  $fecha_hora_exp );
                if( $ex_Fecha_Actual   <   $expiracionHora)
                    return view("auth.recovery_password_form", ['USUARIO'=>   $id_usuario]);
                else 
                {
                    $recuperacion_reg->delete();
                    echo "El link al que usted accedió ya ha caducado. Haga clic en el siguiente link para solicitar de nuevo el reestablecimiento de su contraseña";
                    echo "<br> <a href='".url("recovery-password")."'> Reestablecer contraseña </a>";
                }
 
            }else{
                echo "El link al que usted accedió ya no existe. Acceda al siguiente link para solicitar de nuevo el reestablecimiento de su contraseña";
                echo "<br> <a href='".url("recovery-password")."'>".url("recovery-password")."</a>";
            }
        }
    }
   

}/*********** */

 



public function sistema_habilitado( $systemid , $interno= false){
    $db_admin = DB::connection("principal");

    $dato_cuenta = $db_admin->table("suscriptores")
    ->join("planes","planes.IDNRO", "suscriptores.PLAN")
    ->select("planes.DURACION", 
    DB::raw("if( ABS( datediff( date(suscriptores.created_at), curdate()) )  > planes.DURACION , 'N', 'S') as VALIDO") )
    ->where("suscriptores.IDNRO", $systemid )->first();

    //fecha de creacion
    $Valido=  $dato_cuenta->VALIDO;
    //duracion
    $Plan_duracion=  $dato_cuenta->DURACION; 
    //Fecha pago
    $Fecha_pago= "";

    $HABILITADO= false;
    if(  $Valido == "N"){
        //lEER PAGOS
         //VERIFICAR ULTIMO PAGO
        $estado_pago= $db_admin->table("pagos")
        ->select( "pagos.FECHA AS FECHAPAGO", DB::raw("if( datediff(  DATE_ADD( pagos.FECHA, INTERVAL $Plan_duracion DAY)  , curdate()) > 0, 'S','N') as PERMITIR"))
        ->where("pagos.CLIENTE", $systemid)
        ->orderBy("FECHA", "desc")->first();
        if( ! is_null($estado_pago) ) {
            $Fecha_pago=   $estado_pago->FECHAPAGO;

            if(   $estado_pago->PERMITIR == "S" )  $HABILITADO= true; 
        }

    } else $HABILITADO=  true;

    if(  $interno ){
       if( $HABILITADO) return "";
       else{
           if( $Fecha_pago=="")
           return "El acceso está deshabilitado. Ya venció el período de prueba";
           else
           return "El acceso está deshabilitado. La fecha del último pago fue el $Fecha_pago";
       }
      
    }else{
        if( $HABILITADO ){
            return response()->json( ["ok"=>  "Habilitado. "]);
        }else{
            return response()->json( ["error"=>  "El acceso está deshabilitado. La fecha del último pago fue el $Fecha_pago"]);
        }
    }
   
    //  return response()->json( ["error"=>  "El acceso está deshabilitado. "]);

}
 

}