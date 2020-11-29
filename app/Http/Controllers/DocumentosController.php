<?php

namespace App\Http\Controllers;

use App\Documentos;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Block\Element\Document;

class DocumentosController extends Controller
{


    public function __construct()
    {

        date_default_timezone_set("America/Asuncion");
    }






    public function index()
    { 
        $this->obtenerConexion();
        $docus= Documentos:: 
        where("ABOGADO", session("abogado") )
        ->get();
        return view("documentos.view",  ['documentos'=>   $docus ]);   
    }



 

    public function cargar(){

        $this->obtenerConexion();
        if( request()->isMethod("POST")){

          $re=  request()->file('document');

         try{
            foreach( $re as $archivo):
       
                $nombre= $archivo->getClientOriginalName();
                $ubicacion= "ABOGADO-".session("abogado")."/".$nombre;

                $d=new Documentos();
                $d->ABOGADO= session("abogado");
                $d->NOMBRE= $nombre;
                $d->UBICACION= $ubicacion; 
                $d->save();
                $archivo->storeAs( "ABOGADO-".session("abogado"),   $nombre );
                 
              endforeach;

              return redirect("documentos");
         }catch(Exception $e){
echo $e;
         }
         
        }else{
            return view("documentos.cargar");
        }
    
    }

    
    public  function path( $idnro){

        $this->obtenerConexion();

        $docu= Documentos::find( $idnro );
        $el_path= $docu->UBICACION;
       // $Ruta_abs=  Storage::url(   $el_path);
       // echo public_path();
        //Storage::path(  $el_path); 
        return  response()->json(  ["ruta"=>  $el_path]);
    }

    public  function download( $idnro,  $system=""){

        if( $system != "")  $this->obtenerConexion(  $system );
        else $this->obtenerConexion();

        $docu= Documentos::find( $idnro );
        $el_path= $docu->UBICACION;
       /* $mime= Storage::mimeType($el_path);
        if(  $mime == "application/pdf" ){
            $Ruta_abs= Storage::path(  $el_path);
        }
        $Ruta_abs= Storage::path(  $el_path);*/
        return Storage::download( $el_path);
    }

    public function delete($idnro)
    {

        $this->obtenerConexion();
        $docu = Documentos::find($idnro);
        $el_path = $docu->UBICACION;
        try {
            if ($docu->ABOGADO != session("abogado"))
            return view("documentos.view", ['MENSAJE_ERROR' =>  "Accion no autorizada"]);
            else {
                $docu->delete();
                Storage::delete($el_path);
                return redirect("documentos");
            }
        } catch (Exception $ex) {
            return view("documentos.view", ['MENSAJE_ERROR' =>  $ex]);
        }
    }


    public function crear_enlace_simbolico(){
 
       var_dump(  shell_exec ( " ln -s /var/www/vhosts/legalex.com.py/httpdocs/juridico_v2/laravel_files/storage/app   /var/www/vhosts/legalex.com.py/httpdocs/juridico_v2/docus" )  );
    }
}