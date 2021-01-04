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







    public function welcome(Request $request)
    {
        $this->defaultConexion();
        return view("modulo_admin.index");
    }



    public function index()
    {
        $us =  Usu_proveedor::paginate(10);
        if (request()->ajax())
        return view('modulo_admin.usuario.grilla', ['usuarios' =>   $us]);
        else
        return view('modulo_admin.usuario.index', ['usuarios' =>   $us]);
    }


  
 

   
 
    public function nick_redundante($nick, $operacion)
    {
        $res =  Usu_proveedor::where("NICK",  $nick)->first();
        if (is_null($res)) return false;
        else {

            $usutemp = Usu_proveedor::find($res->IDNRO);
            $nick_en_bd =   $usutemp->NICK;
            if ($operacion == "M"  &&   $nick_en_bd ==   $nick) return false;
            else return true;
        }
    }



    private function cargar()
    {
        $request =  request();
        $Params =  $request->input();
        //hashing
        if (array_key_exists("PASS",   $Params))
        $Params['PASS'] = Hash::make($request->PASS);
        DB::beginTransaction();
        try {

            $r = null;
            if (array_key_exists("IDNRO",  $Params))   $r = Usu_proveedor::find($Params['IDNRO']); //editar
            else  $r = new Usu_proveedor(); //actualizar
            $r->fill($Params);
            $r->save();
            DB::commit();
            return response()->json(['idnro' =>  $r->IDNRO]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(array('error' => "Hubo un error al guardar uno de los datos<br>$e"));
        }
    }



    public function create(Request $request)
    {
        if ($request->isMethod("POST")) { //hay datos 
            //Redundacia de nick
            $Params =  $request->input();
            if ($this->nick_redundante($Params['NICK'],  "A"))
            return response()->json(['error' => "Nick ya está siendo utilizado"]);
            return $this->cargar();
        } else {
            if (request()->ajax())  return view("modulo_admin.usuario.form");
            else {
                $us = Usu_proveedor::paginate(10);
                return view('modulo_admin.usuario.create', ['usuarios' => $us]);
            }
        }
    }

    public function update(Request $request, $id = 0)
    {
        if ($request->isMethod("PUT")) { //hay datos 
            //Redundacia de nick
            $Params =  $request->input();
            if ($this->nick_redundante($Params['NICK'],  "M"))
            return response()->json(['error' => "Nick ya está siendo utilizado"]);
            return $this->cargar();
        } else {
            $dato = Usu_proveedor::find($id);
            if (request()->ajax())
                return view("modulo_admin.usuario.form",  ["IDNRO" => $id, "DATO" => $dato, "OPERACION" => "M"]);
            else {
                $us = Usu_proveedor::paginate(10);
                return view('modulo_admin.usuario.update', ['usuarios' => $us,  'OPERACION'=>"M"]);
            }
        }
    }




    public function borrar($id)
    {
        if (is_null(Usu_proveedor::find($id)))
        return response()->json(["error" => "El usuario ID $id no existe "]);
        else {
            if (Usu_proveedor::find($id)->delete())
            return response()->json(array('ok' =>  "BORRADO"));
            else  return response()->json(array('error' => "Hubo un error al guardar uno de los datos"));
        }
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


 private function existeUsuario(){
    $usr= request()->input("NICK");
    $d_u= Usu_proveedor::where("NICK", $usr)->first(); 
   return ! is_null( $d_u);
 }
 
private function correctPassword( $entrada, $nick){
    $hashedPassword=Usu_proveedor::where("NICK", $nick)->first()->PASS; 
    return Hash::check( $entrada, $hashedPassword);
   
}

    public function sign_in(Request $request)
    {


        if ($request->isMethod("GET")) {
            return view("modulo_admin.usuario/login");
        } else {
            //DATOS DE SESIOn
            $usr = $request->input("NICK");
            //OBTENER NRO REG DE USUARIO a partir de su NICK
            $d_u = Usu_proveedor::where("NICK", $usr)->first();

            //VERIFICAR EXISTENCIA DE USUARIO
            if (!$this->existeUsuario()) //no existe
                return response()->json(array("error" => "El usuario ->$usr<- no existe"));

            $id_usr = $d_u->IDNRO;  //nick
            $pass = $request->input("PASS"); //pass

            // VERIFICACION DE contrasenha correcta
            if (!$this->correctPassword($pass, $usr))
                return response()->json(['error' => 'password incorrecta']);

            //Crear la sesion
            $SesionDatos =
                array('id' => $id_usr, 'nick'  => $usr, 'provider' => true);
            // Via a request instance... 
            session($SesionDatos);

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

            return response()->json(['ok' => 'Autenticado']);
           // return redirect(url("/admin/welcome"));
        } //END ANALISIS DE PARAMETROS
    }//END SIGN IN



 

public function sign_out(){
    session()->flush(); 
    return redirect(    url("admin/sign-in")   ); 
}

 



 




}