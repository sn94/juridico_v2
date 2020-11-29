<?php

namespace App\Http\Controllers;

use App\Abogados;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Mail\Correo;
use App\Mail\Credencial_abogado;
use App\Mail\GenericMail;
use App\pdf_gen\PDF;
use App\User;
use Exception; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AbogadoController extends Controller
{
    

    public function __construct()
    {
       
        date_default_timezone_set("America/Asuncion");
    }



    /* private function obtenerConexion( $keepDefaultSetting=  false ){
        if(  $keepDefaultSetting)  return;
        $systemid=  session("system");  
        $DataBaseName= "cli_".$systemid;
        $configDb = array(
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' =>  $DataBaseName,
            'username' =>  env("DB_USERNAME"),
            'password' => env("DB_PASSWORD"),
            'charset' => 'utf8',
            'prefix' => '',
        );
     
        Config::set('database.connections.mysql', $configDb);
       //$conexionSQL = DB::connection('mysql');
       return $systemid;
    }**/



    public function index()
    {
        $this->obtenerConexion();
 
            $cantidad =  Abogados::count();

            if ($cantidad <= 0) {
                if (request()->ajax())  return view("abogado.grilla",
                    ["sin_abogados" => true]
                );
                else   return view("abogado.index", ["sin_abogados" => true]);
            } else {
                $abogados = Abogados::paginate(10);
                if (request()->ajax())  return view("abogado.grilla",  ['abogados' =>  $abogados]);
                else   return view("abogado.index",  ['abogados' =>  $abogados]);
            }
         
      
    }




    public function select_cod_abogado(  ){
        //Realmente existe?
        $this->obtenerConexion();
        if (request()->isMethod("POST")) {
            $datos = request()->input();
            $abo = Abogados::find( $datos['abogado_code']);
            if (is_null($abo)) {
                return  response()->json(["error" => "El código que ingresó no existe"]);
                // return view("layouts.error",  ["error"=> "El código que ingresó no existe"  ]);
            } else {  //Verificar concordancia entre codigo de abogado y PIN

                session(['abogado' => $datos['abogado_code']]);
                return redirect(url("/"));
               /* if (session("tipo") != "SA") :
                    $pin_ingresado =  $datos['abogado_pin'];
                    $pin_hash =  $abo->PIN;
                    if (Hash::check($pin_ingresado, $pin_hash)) {
                        session(['abogado' => $datos['abogado_code']]);
                        return redirect(url("/"));
                    } else {
                        return  response()->json(["error" => "Pin no válido"]);
                    }
                else :
                    session(['abogado' => $datos['abogado_code']]);
                    return redirect(url("/"));
                endif;*/
            }
        } else {
            $abogados = Abogados::select('abogados.IDNRO', DB::raw("CONCAT(NOMBRE, CONCAT(' ',APELLIDO) ) AS NOMBRES"))
            ->orderBy("IDNRO");
            //filtrar
            if( session("tipo") != "SA"){
                $abogados= $abogados->join("usu_contextos", "usu_contextos.ABOGADO", "abogados.IDNRO")
                ->where("usu_contextos.USER", session("id") );
            }
            $abogados= $abogados->get();
            return view("abogado.seleccion", ['abogados' =>  $abogados]);
        }
    }


    

    private function enviar_email_credencial( $email, $genericEmail){
        try{
            Mail::to([ $email]) 
            //->queue(   new AuthAlert(  $usr,  ["Suscriptores-agent"=>$SuscriptoresAgent, "ip"=>$Ip] ) );
        ->send( $genericEmail );
        }catch( Exception $e){ 
            //echo $e;
        }
    }

    public function cargar( Request $request, $id=0){
        $this->obtenerConexion();
        if(   $request->isMethod("POST"))  {//hay datos 
            //Quitar el campo _token
            $Params=  $request->input();  
             DB::beginTransaction();
            try{
                
                $r= null;

                if(  $id == 0){  //creacion

                    //hay registros? crear uno en blanco
                    if( Abogados::count() == 0)
                    { $first_lawyer= new Abogados(); $first_lawyer->save(); }
                    $r= new Abogados();
                     //Generar PIN para permitir uso del ID a terceros
                    $raw_pin_third_party=  Helper::generar_password();
                    $Params['PIN']=   Hash::make(  $raw_pin_third_party);
                }
                else  { $r= Abogados::find( $request->input("IDNRO") ); }

                $Params[ 'CEDULA']= Helper::cleanNumber(   $Params[ 'CEDULA']  );//quitar separador punto
              

                 $r->fill(  $Params  );  
                 $r->save();

                 $id_aboga=  $r->IDNRO;
                 $future_nick= session("system"). "_".$r->CEDULA;
                 $raw_pass= Helper::generar_password();
                 
                 $usu_rela=  User::where("ABOGADO", $id_aboga)->first();
                 if( is_null($usu_rela)){
                     $usu_rela= new User();
                     $usu_rela->nick= $future_nick;
                     $usu_rela->tipo="S";
                     $usu_rela->pass= Hash::make( $raw_pass) ;
                     $usu_rela->email= $r->EMAIL;
                     $usu_rela->ABOGADO=  $r->IDNRO;
                     $usu_rela->save();
                        //Creacion de usuario
                        $correo_ob= new Correo();
                        $correo_ob->setTitulo("Credenciales de acceso al Sistema de Juicios");
                        $correo_ob->setDestinatario( $r->EMAIL);
                        $correo_ob->setMensaje( "Usuario: $future_nick <br>Password: $raw_pass <br>Recuerde que puede cambiar su nick y contraseña cuando lo desee" );
                        $genemail= new GenericMail( $correo_ob );
                        $this->enviar_email_credencial(   $r->EMAIL,  $genemail );
                   // $this->enviar_email_credencial( $r->EMAIL, $future_nick, $raw_pass, $raw_pin_third_party);
                   
                     
                }else{
                    $tempoemail=  $usu_rela->email;
                    //ACTUALIZAR EMAIL SI HA CAMBIADO
                    if(  $usu_rela->email != $r->EMAIL   )
                    {
                        $usu_rela->email=  $r->EMAIL;
                        $usu_rela->save();
                        $correo_ob= new Correo();
                        $correo_ob->setTitulo("Dirección de correo electrónico actualizada");
                        $correo_ob->setDestinatario( $r->EMAIL);
                        $correo_ob->setMensaje( "Recientemente a cambiado su email de referencia, de $tempoemail a $r->EMAIL " );
                        $genemail= new GenericMail( $correo_ob );
                        $this->enviar_email_credencial(   $r->EMAIL,  $genemail );
                    }
                } 

                 DB::commit();
                 echo json_encode( array('idnro'=>  $r->IDNRO  )); 
              
                
           
            } catch (\Exception $e) {
                DB::rollback();
                echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
            }   
        }
        else  {   
            if( $id == 0)
            {
                if( request()->ajax())
                return view("abogado.form",  ["OPERACION"=>"A"] );
                else 
               { $us= Abogados::paginate(10);
                return view('abogado.create' , ['abogados'=> $us]);
                }  
            }
            else{
                $dato= Abogados::find( $id );
                if( request()->ajax())
                return view("abogado.form",  [ "IDNRO"=> $id, "DATO"=> $dato , "OPERACION"=>"M"]);
                else 
               { $us= Abogados::paginate(10);
                return view('abogado.create' , ['abogados'=> $us]);
                }  
                
            }
           
         }   
     }





     public  function  regenerar_pin(  $id_abogado){
        $this->obtenerConexion();
         $abogado=  Abogados::find(  $id_abogado );
         if( is_null( $abogado) ){
            return  response()->json(  ["error"=> "ID de abogado no existe"  ] );
         }else{

            $rawpin= Helper::generar_password();
            $abogado->PIN=  Hash::make( $rawpin );
            if( $abogado->save()){
                $correo_ob= new Correo();
                //Actualizacion de PIN notifi. en Email
                $correo_ob->setTitulo("PIN actualizado");
                $correo_ob->setDestinatario( $abogado->EMAIL);
                $correo_ob->setMensaje( "Código abogado: $abogado->IDNRO, Su nuevo PIN es $rawpin" );
                $genemail= new GenericMail( $correo_ob );
                $this->enviar_email_credencial(   $abogado->EMAIL,  $genemail );
                if( session("tipo") == "SA")
                return  response()->json(  ["ok"=> "El nuevo PIN es $rawpin"  ] );
                else 
                return  response()->json(  ["ok"=> "PIN regenerado"  ] );
            }else{
                return  response()->json(  ["error"=> "Error al regenerar el PIN"  ] );
            }
         }
     }

     public function delete( $id){
         $this->obtenerConexion();
        if(  Abogados::find($id)->delete() ) echo json_encode( array('ok'=>  "BORRADO"  ) );
        else json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos") );
     
     }


}