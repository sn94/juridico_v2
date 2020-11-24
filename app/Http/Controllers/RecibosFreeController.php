<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\NumeroALetras;
use App\Http\Controllers\Controller;
use App\Mail\Correo;
use App\Mail\SendRecibo;
use App\pdf_gen\PDF;
use App\RecibosFree;
use App\RecibosFree_user;
use App\User;
use Exception; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Return_;

class RecibosFreeController extends Controller
{
    

    public function __construct()
    {
       
        date_default_timezone_set("America/Asuncion");
    }
  

 



    public function index(){
     
      return view("recibos_free.index")    ;
    }



    // NUEVO RECIBO
    public function nuevo( ){

        if( request()->isMethod("GET"))
        return view("recibos_free.form");
        else{

            $this->defaultConexion();
            $datos= request()->input();
            //QUITAR LIMPIAR
            $limpio_=  Helper::cleanNumber(  $datos['IMPORTE'] );
         
            $datos['IMPORTE']=  $limpio_;
            $datos['IMPORTE_L']=     (new NumeroALetras())->toWords( $limpio_);

            $nuevo_rec=  new RecibosFree();
            $nuevo_rec->fill(  $datos);
            if(  $nuevo_rec->save() )
            return response()->json(  ["ok"=>  $nuevo_rec->IDNRO]  );
            else
            return response()->json(  ["error"=>"Error al guardar recibo!"]  );
        }
    }


    public function nuevo_freeuser(){

        if( request()->isMethod("GET"))
        return view("recibos_free.freeuser");
        else{

            $this->defaultConexion();
            $datos= request()->input();
            //verificar si ya existe nick
           
            if( !is_null(  RecibosFree_user::where("NICK", $datos['NICK'])->first() ) ){
                return response()->json(  ["error"=>"Ese nombre de usuario ya existe!"]  );
            }
            $nuevo_rec=  new RecibosFree_user();
            $nuevo_rec->fill(  $datos);
            if(  $nuevo_rec->save() )
            return response()->json(  ["ok"=>"Gracias por registrarse!"]  );
            else
            return response()->json(  ["error"=>"No se pudo al guardar sus datos!"]  );
        }
    }


    
    public function login_freeuser(){
        if( request()->isMethod("GET")){
            return view("recibos_free.login");
        }else{  
            $datos= request()->input();
           
            $usr= RecibosFree_user::where("NICK", $datos['NICK'] )->first();
            if( !is_null(  $usr ) ){
                if(  $datos['PASS'] ==  $usr->PASS ){
                    $SesionDatos= ["freeuser"=>  $usr->IDNRO , 'freeuser_'=>  $usr->NICK]; 
                    session( $SesionDatos); 
                    return response()->json(  ['ok'=> $usr->IDNRO, 'nick'=> $usr->NICK] );
                } 
               
                else return response()->json(  ['error'=> 'Ingresa'] );
                
            } return response()->json(  ['error'=> 'Usuario inexistente'] );

        }
    }
    public function freeuser_menu(){
        return view("recibos_free.menu_usuario");
    }
    public function logout_freeuser(){
        session()->flush(); 
        return redirect("recibos-free");
    }

   
    public function print(  $id_recibo ){
        $recibo= RecibosFree::find(  $id_recibo);
        $NRORECIBO=  $recibo->IDNRO;
        $IMPORTE=  $recibo->IMPORTE;
        $fechaletras= Helper::fechaDescriptiva(   $recibo->FECHA );
        $CLIENTE=  $recibo->CLIENTE;
        $IMPORTEL=  $recibo->IMPORTE_L;
        $CONCEPTO=  $recibo->CONCEPTO;

        return view("recibos_free.recibo", ['NRORECIBO'=> $NRORECIBO, 'IMPORTE'=>$IMPORTE, 'fechaletras'=>$fechaletras, 'CLIENTE'=>$CLIENTE, 'IMPORTEL'=>$IMPORTEL, 'CONCEPTO'=> $CONCEPTO]);
    }
 


    public function recibo_pdf( $id_recibo){
        $recibo= RecibosFree::find(  $id_recibo);
        $NRORECIBO=  $recibo->IDNRO;
        $IMPORTE=   Helper::number_f($recibo->IMPORTE);
        $fechaletras= Helper::fechaDescriptiva(   $recibo->FECHA );
        $CLIENTE=  $recibo->CLIENTE;
        $IMPORTEL=  $recibo->IMPORTE_L;
        $CONCEPTO=  $recibo->CONCEPTO;
        $html= <<<EOF
        
        <div  style="margin-top: 0px; margin-bottom: 0px;padding-right:20px;padding-bottom:0px; width: 350px;  padding-top: 10px;border-top: 1px solid #a3a3a3;border-bottom: 1px solid #a3a3a3;border-left: 1px solid #a3a3a3;border-right: 1px solid #a3a3a3;"> 
        <br>    
        <table style="width: 100%; padding-right: 0px;  padding-left: 0px;margin-top:10px; margin-right: 0px;margin-left: 0px; ">
                <tr  style="border: solid 1px black;padding-right: 0px;padding-left: 0px;margin-right: 0px;margin-left: 0px; ">
                    <td   style=" margin-right: 0px;margin-left: 0px;padding-right: 0px;padding-left: 0px;" ><span style="text-align: left;font-weight:bold; font-size: 12px;">RECIBO N° $NRORECIBO</span> </td>
                    <td  ></td>
                    <td    style="border: solid 1px black;margin-right: 0px;margin-left: 3px;padding-right: 0px;padding-left: 0px;background-color: #a4a4a4; font-size: 12px; text-align: center;"> G. $IMPORTE  </td>
                </tr>
            </table>
            <p   style="text-align: right; font-size: 12px;">$fechaletras</p>
            <p   style="font-size: 12px;">Recibí(mos) de <span style="background-color: #d2d2d2;   font-size: 14px;text-align: right;padding-left:15px;padding-right:15px;">$CLIENTE</span> </p>
            <p  style="font-size: 12px;">la cantidad de guaraníes <span style="background-color: #d2d2d2;  font-size: 12px;padding-left:15px;padding-right:15px;">$IMPORTEL</span> </p>
           
            <p   style=" font-size: 12px;">por concepto de <span  style="background-color: #d2d2d2;   font-size: 12px;padding-left:15px;padding-right:15px; width: 200px;border: none;" >$CONCEPTO</span> </p>
            <table>
            <tr><td> </td><td style="width: 200px;"></td><td style=" border-top: 1px solid #070707; font-size: 12px; ">Firma y aclaración</td></tr>
            </table>
        </div>
        EOF;
        $tituloDocumento= "Recibo N° -$NRORECIBO";
        //echo $html;
            $pdf = new PDF(); 
            $pdf->prepararPdf("$tituloDocumento.pdf", "", ""); 
            $pdf->generarHtml( $html);
            $pdf->generar();
    }

    public function listar(){
        $reci= DB::table("recibos_free")->where("FREEUSER",  session("freeuser") )
        ->select( "IDNRO", "FECHA", "IMPORTE", "CLIENTE")
        ->orderBy("FECHA", "DESC")
        ->paginate(10);

        return  view("recibos_free.lista", ['recibos'=> $reci]  );
    }

    public function total_recibos(){
        $reci= DB::table("recibos_free")->where("FREEUSER",  session("freeuser") )
        ->select(  "FECHA", "IMPORTE", DB::raw("COUNT(IDNRO) as TOTAL"))
        ->orderBy("FECHA", "DESC")
        ->groupBy("FECHA")
        ->groupBy("IMPORTE")
        ->paginate(10);

        return  view("recibos_free.lista", ['recibos'=> $reci]  );
    }




    public function send_email($NRORECIBO = "")
    {
        if (request()->isMethod("POST")) {

            $datos =  request()->input();
            $mail_obj = new Correo();
            $mail_obj->setTitulo("Usted ha recibido un recibo");
            $mail_obj->setRemitente($datos['REMITENTE']);
            $mail_obj->setDestinatario($datos['DESTINATARIO']);
            $mail_obj->setMensaje(url("recibos-free/pdf/" . $datos['NRORECIBO']));
            $snt = new SendRecibo($mail_obj);
            try {
                Mail::to([$datos['DESTINATARIO']])
                //->queue(   new AuthAlert(  $usr,  ["Suscriptores-agent"=>$SuscriptoresAgent, "ip"=>$Ip] ) );
                ->send($snt);

                return response()->json(['ok' => 'ENVIADO']);
            } catch (Exception $e) {
                return response()->json(['error' => $e]);
            }
        } else {
            return view("recibos_free.email_form", ['NRORECIBO' => $NRORECIBO]);
        }
    }
  

    
}