<?php

namespace App\Http\Controllers;
 
use App\Arreglo_extrajudicial;
use App\Contraparte;
use App\Demanda;
use App\Demandados;
use App\Helpers\Helper;
use App\Honorarios;
use App\Http\Controllers\Controller;
use App\Notificacion;
use App\Observacion;
use Exception;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 

class DemandaController extends Controller
{
    

    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }

/****
 * DEMANDAS
 * 
 */
/**
 * Listado de demandas
 * *
 * */
    public function demandas(){
        $o_de= DB::table("odemanda")->get();

        $dts= DB::table("demandas2")
        ->join("demandado", "demandado.CI", "=", "demandas2.CI")
        ->select("demandado.CI", "demandado.TITULAR", "demandas2.*" )
        ->where("ABOGADO", "=",  session("abogado") )
        ->get();
       // $dts = DB::select("select IDNRO,TITULAR,CI,DEMANDANTE,COD_EMP,CTA_BANCO,BANCO,GARANTE,CI_GARANTE from demandas2  order by TITULAR");
        return view('demandas.list', ['lista' => $dts, "odemanda" => $o_de]); 
    }

 

/**
 * LISTA DE DEMANDAS DE UNA PERSONA
 * 
 */
 
 public function adjuntarSaldosDemanda( $ci){
    $judi=new JudicialController();
    $lst= Demanda::where("CI", $ci)->orderBy("IDNRO")->get();
    $n_lst= array();
    foreach( $lst as $it){
        $idn= $it->IDNRO;
        $arr= $judi->saldo_C_y_L( $idn);
        $arr['IDNRO']= $idn;
       array_push( $n_lst, $arr);

    }
 return $n_lst; 
 }



 private function listar_DEMANDAS( $CI){
    $lista=  DB::table("demandas2")
    ->join("notificaciones", "notificaciones.IDNRO", "=", "demandas2.IDNRO")
    ->join("demandan", "demandan.IDNRO", "=", "demandas2.DEMANDANTE", "left")
    ->join("odemanda", "odemanda.IDNRO", "=", "demandas2.O_DEMANDA", "left")
    ->select("demandas2.IDNRO","demandas2.COD_EMP", "demandan.DESCR as DEMANDANTE", "odemanda.NOMBRES AS O_DEMANDA", "notificaciones.PRESENTADO", "notificaciones.SD_FINIQUI", "notificaciones.FEC_FINIQU")
    ->where("demandas2.CI", $CI)
    ->where("demandas2.ABOGADO", session("abogado"))
    ->orderBy("demandas2.IDNRO")
    ->get();  return  $lista;
 }


 public function demandas_by_ci($ci){
  
    $lista= $this->listar_DEMANDAS( $ci);
       $persona= Demandados::where("ci", $ci)->first();//persona
       $saldos= $this->adjuntarSaldosDemanda($ci);
        return view("demandado.list_demandas", 
        ['lista'=>   $lista, 'idnro'=>$persona->IDNRO,  'ci'=>$ci, 'nombre'=> $persona->TITULAR, "saldos"=> $saldos ] );
 }



 


 public function demandas_by_id($ID){
  
    $lista= null;
 
       $persona= Demandados::find( $ID);//persona
      
       $ci= $persona->CI;
        
       //nO HAY CEDULA
        if( strlen( trim($ci)) == 0){
            return  view("demandado.sin_cedula" ); 
        }else{
            $lista= $lista= $this->listar_DEMANDAS( $ci);
            $saldos= $this->adjuntarSaldosDemanda($ci);
            if(  request()->ajax() ){
                return view("demandado.list_demandas_grilla", 
                ['lista'=>   $lista,  'idnro'=>$ID,     "saldos"=> $saldos ] );
            }else
            return view("demandado.list_demandas", 
            ['lista'=>   $lista,  'idnro'=>$ID,  'ci'=>$ci, 'nombre'=> $persona->TITULAR, "saldos"=> $saldos ] );
        }   
 }
/**
 * FICHA DE DEMANDA SEGUN COD_EMP
 */
    public function ficha_demanda(  $codemp){
        $data= DB::table("demandas")->where('cod_emp', $codemp)->first();
        return view("demandas.ficha_demanda", ['ficha'=>   $data] );
    }

    public function ficha_de_demanda(  $idnro){
        $data= Demanda::find( $idnro);
        $demanObj=  Demandados::where("CI", $data->CI)->first();
        $nom= $demanObj->TITULAR;
        return view("demandas.ficha_demanda", ['ficha'=>   $data, 'idnro'=>$idnro, 'nom'=>  $nom] );
    }

  /*
    NUEVA DEMANDA
    */

    public function show_form_nuevo( $id_d){//Id de demandado
        $qu= Demandados::find( $id_d);
        if( is_null( $qu) ){  echo "Código inválido";
        }else{
            $ci= $qu->CI;//cedula  
            $nom=$qu->TITULAR;//nombre
            return view('demandas.agregar.index', ['ci'=>  $ci ,'id_demandado'=>$id_d, 'nombre'=> $nom ]); 
        }
    }
     

    private function formar_parametros(){//parametros basicos
        $origen= DB::table("odemanda")->get();//Origen de demanda
        $demandantes= DB::table("demandan")->get();//Demandantes
        $actuarias= DB::table("actuaria")->get();//Actuarias
        $jueces= DB::table("juez")->get();//Juez
        $instituciones= DB::table("instituc")->get();//Instituciones
        $inst_tipo= DB::table("instipo")->get();//tipo de Instituciones 
        $juzgados= DB::table("juzgado")->get();// JUzgado
        $localidades= DB::table("localida")->get();// Localidad
        $bancos= DB::table("bancos")->get();// Bancos

        return array("origen"=>$origen ,"demandantes"=> $demandantes ,   "actuarias"=> $actuarias, "jueces"=>$jueces,
         "instituciones"=> $instituciones, "instipos"=>$inst_tipo, "juzgados"=> $juzgados, "localidades"=>$localidades,
        "bancos"=> $bancos );
    }


    public function nueva_demandan(Request $request, $DEMANDADO=0){//idd id_demandado
         
        
        if(  $request->isMethod("POST"))  {
            
            //Quitar el campo _token
            $Params=  $request->input();  
            $Params['SALDO']=  $Params['DEMANDA'];//Saldo inicial
            $Params['ABOGADO']=  session("abogado");//id de abogado
            
            /***ini transac */ 
             DB::beginTransaction();
             try {
                $deman=new Demanda();
                $deman->fill(  $Params );
                $deman->save();
                //Generacion de otros registros
               $noti= new Notificacion(); $noti->IDNRO= $deman->IDNRO; $noti->CI= $deman->CI; $noti->ABOGADO=  session("abogado"); $noti->save();
               $obs= new Observacion(); $obs->IDNRO= $deman->IDNRO;    $obs->CI= $deman->CI; $obs->ABOGADO=  session("abogado"); $obs->save();
               $contra= new Contraparte(); $contra->IDNRO= $deman->IDNRO;  $contra->ABOGADO_=  session("abogado"); $contra->save();
               $obarre= new Arreglo_extrajudicial();  $obarre->IDNRO= $deman->IDNRO;  $obarre->ABOGADO= session("abogado"); $obarre->save();
                $obhonorario= new Honorarios(); $obhonorario->IDNRO= $deman->IDNRO; $obhonorario->ABOGADO=  session("abogado"); $obhonorario->save();
               DB::commit();
               echo json_encode( array( 'ci'=> $deman->CI, "id_demanda"=> $deman->IDNRO) );
             } catch (\Exception $e) {
                 DB::rollback();
                 echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
             } 
            /**end transac */
            
        }
        else{    
            if( $DEMANDADO != 0){
                $ficha= Demandados::find( $DEMANDADO);
                return view('demandas.index',  

                array_merge( $this->formar_parametros() ,
                 [  'ci'=>$ficha->CI, 'nombre'=>$ficha->TITULAR, 'ficha0'=> $ficha, 'OPERACION'=>"A+"])     ); 
            }else{
                $pars= array_merge( $this->formar_parametros() , array( 'OPERACION'=>"A"  ) );
                return view('demandas.index', $pars);  
            } 
        }
    }



    
    public function editar_demandan(Request $request, $iddeman=0, $tab=1){//idd id_demanda
       

           //instancia de demanda
           $obdema= NULL;
           if($iddeman==0) {$iddeman= $request->input("IDNRO"); }

           $obdema= Demanda::find( $iddeman );
           
        //Honorarios
        //Existe Honorarios
        $obhonorario=Honorarios::find( $iddeman );
 
        if(  $request->isMethod("POST"))  {
            
            //Quitar el campo _token
            $Params=  $request->input();  
             
            //Actualizar en BD
            $obdema->fill(  $Params );
            if($obdema->save() ){//exito   
                    //ACTUALIZAR SALDO
                $objudicial= new JudicialController();
                $objudicial->saldo_C_y_L(   $obdema->IDNRO, "array", true);
                echo json_encode( array( 'ci'=>  $request->input("CI"), "id_demanda"=>  $request->input("IDNRO") ) );
            }else{ //fallo
                echo json_encode(array(  'error'=> 'Un problema en el servidor impidió guardar los datos. Contacte con su desarrollador.' )); 
            }
        }
        else{  //get 
 
            
        if($request->ajax() ){
            return $this->editar_demanda_form( $iddeman  );
        }

            $ci= $obdema->CI;//cedula  
            $nom= Demandados::find($obdema->DEMANDADO)->TITULAR;//nombre 
            $obnoti= Notificacion::find( $iddeman);
           $obobs= Observacion::find( $iddeman);
           $obDataPerso= Demandados::find($obdema->IDNRO);
           //Contraparte-intervencion
           $obcontraparte= Contraparte::find( $iddeman);
           //Existe Arreglo Extrajudicial?
           $obarre=Arreglo_extrajudicial::find( $iddeman );
            //Devolver 
            $pars= array_merge( $this->formar_parametros() ,
             array( 'ci'=>  $ci ,'id_demanda'=>$iddeman,'ficha0'=>$obDataPerso, 'ficha'=> $obdema,
              'ficha2'=>$obnoti,  'ficha3'=>$obobs, 'ficha4'=> $obcontraparte,'ficha5'=> $obarre,
              'ficha6'=>$obhonorario,
               'nombre'=> $nom , 'OPERACION'=>"M" , "tab"=>$tab ) 
                );
            return view('demandas.index',  $pars); //Modificar M  
            }
        }


        //Solo devuelve el formulario de demandas (en AJAX)
    public function editar_demanda_form(  $iddeman=0){//idd id_demanda
        //instancia de demanda
        $obdema= NULL;
        if($iddeman==0) {$iddeman= request()->input("IDNRO"); }
        $obdema= Demanda::find( $iddeman );
        $obDataPerso= Demandados::where("CI", $obdema->CI)->first();
         $ci= $obdema->CI;//cedula  
         $nom= Demandados::where("CI",$ci)->first()->TITULAR;//nombre 
         //Devolver 
         $pars= array_merge( $this->formar_parametros() ,
          array( 'ci'=>  $ci ,'id_demanda'=>$iddeman,'ficha0'=>$obDataPerso, 'ficha'=> $obdema,
            'nombre'=> $nom , 'OPERACION'=>"M") 
             );
         return view('demandas.demanda_form',  $pars); //Modificar M  
 
     }




    public function contraparte(Request $request, $iddeman=""){
        $id_demanda= $iddeman =="" ?  $request->input("IDNRO") : $iddeman;
       $contra=  Contraparte::find( $id_demanda);
       //Si no existe
       if( is_null($contra) )  $contra= new Contraparte();
       $contra->fill(  $request->input() ); 
       if($contra->save())
       echo json_encode( array( 'ok'=>"GUARDADO" )    );
       else
       echo json_encode( array( 'error'=>"ERROR AL GUARDAR" )    ); 
    }
        

    public function honorarios(Request $request, $iddeman=""){
        $id_demanda= $iddeman =="" ?  $request->input("IDNRO") : $iddeman;
       $ho= Honorarios::find( $id_demanda);
       $ho->fill(   $request->input() );
       if($ho->save())
       echo json_encode( array( 'ok'=>"GUARDADO" )    );
       else
       echo json_encode( array( 'error'=>"ERROR AL GUARDAR" )    ); 
    } 


    public function ver_demandan(Request $request, $iddeman=0, $tab=1){//idd id_demanda
        $origen= DB::table("odemanda")->get();

        //instancia de demanda 
        $obdema= Demanda::find( $iddeman );
        $obnoti= Notificacion::find( $iddeman);
        $obobs= Observacion::find( $iddeman);
        $obDataPerso= Demandados::where("CI", $obdema->CI)->first();
         $ci= $obdema->CI;//cedula  
         $nom= Demandados::where("CI",$ci)->first()->TITULAR;//nombre 
         //Arreglo extrajudicial
         $arreglo=Arreglo_extrajudicial::find($iddeman);
         //Honorarios
         $honorario=  Honorarios::find( $iddeman );
         //Devolver
         
         //Cedula    ID demanda  Nombre  Operacion   
         $pars= array_merge( $this->formar_parametros() , array( 'OPERACION'=>"A"  ) );
         $propios= array(  'ci'=>  $ci ,'id_demanda'=>$iddeman, 'tab'=>$tab,
         'ficha0'=>$obDataPerso, 'ficha'=> $obdema, 'ficha2'=>$obnoti, 'ficha3'=>$obobs,
         'ficha4'=> $arreglo, 'ficha5'=> $arreglo, 'ficha6'=>$honorario,'nombre'=> $nom , 'OPERACION'=>"V");
         return view('demandas.index',  array_merge( $pars, $propios ) ); //ver V   
         
     }

 
 
public function borrar($iddeman){

    DB::beginTransaction();
    try {
        //Borrar demandas notificaciones y observacion asociada al CI Nro
        Demanda::find($iddeman)->delete();
        Notificacion::find( $iddeman)->delete();
        Observacion::find($iddeman)->delete();
        DB::commit();
      echo json_encode( array( 'id_deman'=> $iddeman) );
    } catch (\Exception $e) {
        DB::rollback();
        echo json_encode( array( 'error'=> "Hubo un error al borrar uno de los datos<br>$e") );
    }    
 }/** end  */
 






}