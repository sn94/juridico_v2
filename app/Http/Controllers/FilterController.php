<?php

namespace App\Http\Controllers;

 
use App\Filtros;
use App\Http\Controllers\Controller;
 
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;   
use App\pdf_gen\PDF;  
 
class FilterController extends Controller
{


    private $NUMEROCOLS=9;
     
    public function __construct()
    {
        date_default_timezone_set("America/Asuncion");
    }
   

    

public function index(Request $request ){  
    $this->obtenerConexion();
    $lista= Filtros::orderBy('NRO','DESC')
    ->where("ABOGADO", session("abogado"))
    ->paginate(20);
    if( $request->ajax())
    return view('informes.filtros.grilla', [ "lista"=> $lista, 
    'ejecucionxls'=> url("exexlsfiltro"),  'ejecucionpdf'=> url("exepdffiltro") ] );
    else
    return view('informes.filtros.index', [ "lista"=> $lista, 'OPERACION'=>"A", 
    'ejecucionxls'=> url("exexlsfiltro"),  'ejecucionpdf'=> url("exepdffiltro") ] );
} 



public function filtro_orden( Request $request, $col, $sentido){
    $this->obtenerConexion();
    $orden= $sentido== "A" ?"ASC" : "DESC";
    $dato= Filtros::orderBy($col, $orden )
    ->where("ABOGADO", session("abogado"))
    ->paginate(20); 

if( $request->ajax()){
     if($dato->count() )
     return view("informes.filtros.grilla", ["lista"=>  $dato ] );
     else
     echo "<h6>SIN REGISTROS</h6>";
}else{
     return view("informes.filtros.index",
     ["lista"=>  $dato,  'ejecucionxls'=> url("exexlsfiltro"),  'ejecucionpdf'=> url("exepdffiltro") ] );
}
}

public function get_name($id){
    $this->obtenerConexion();
    echo json_encode( array("nombre"=> Filtros::find($id)->NOMBRE) );
}
 
/**
 * 
 */

/**
 * Recoge de la BD los campos de tablas que seran utilizados para crear filtros
 */
public function get_parametros( $opc){
    $this->obtenerConexion();
    $tablas= array();
    $parametr=array();
    $pa=DB::table("param_filtros")-> select('ORDEN','TABLA' ,'TABLA_FRONT')->distinct()->orderBy("ORDEN","ASC")
    
    ->where("TIPO", "<>", NULL)->get();
    //tablas y sus nombres
     foreach( $pa as $item){
        $tablas[$item->TABLA]= $item->TABLA_FRONT;
     }
     if( $opc == "t"){//Nombre interno y estetico de tablas
        echo json_encode( $tablas);
    }
    if( $opc =="f"){//Nombres internos y esteticos de campos de cada tabla
   //demandas
   foreach( $tablas as $clave=>$valor){
    $campos=DB::table("param_filtros")->
    select(  'CAMPO as back','CAMPO_FRONT as face', 'TIPO as tipo', 'LONGITUD as longitud','FUENTE as fuente' )->
    where("TABLA",$clave)-> where("TIPO", "<>", NULL)->get();
    $lista_Campos=array();
    foreach( $campos as $ite_Campo){  
        array_push(  $lista_Campos ,  array("back"=> $ite_Campo->back, "face"=>$ite_Campo->face, "tipo"=>$ite_Campo->tipo, "longitud"=>$ite_Campo->longitud, "fuente"=>$ite_Campo->fuente ));
    }
    $parametr[$clave]= $lista_Campos ;
 }
 echo json_encode($parametr);
    }
  
}
 
/**
 * Relaciones entre tablas
 *
 */

public function relaciones_filtro(){
    $this->obtenerConexion();
    $tablas= array();
    $pa=DB::table("param_filtros")-> select('TABLA')->where("TIPO", "<>", NULL)->get();
    //tablas y sus nombres
     foreach( $pa as $item){
         //Relaciones
        $Relaciones= DB::table("relaciones_filtros")->where("TABLA", $item->TABLA)->pluck("CAMPO_REL", "TABLA_REL");
        $tablas[$item->TABLA]=  $Relaciones;
     }
    echo  json_encode( $tablas);
}
/**
 * 
 * 
 */

   
public function cargar( Request $request, $OPERACION= "A", $id=""){
    $this->obtenerConexion();
    if( ! strcasecmp(  $request->method() , "post"))  {//hay datos 
        //Quitar el campo _token
        $Params=  $request->input();  
        $Params['ABOGADO']= session("abogado");

         DB::beginTransaction();
        try{
        
           $r= $OPERACION=="A" ? new Filtros() : Filtros::find( $Params['NRO']);
             $r->fill( $Params  );
             $r->save();
             echo json_encode( array('ok'=>  url("filtro/".$r->NRO)  ));    
             DB::commit();
         
       
        } catch (\Exception $e) {
            DB::rollback();
            echo json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos<br>$e") );
        }   
    }
    else{    
        $url_fields_res= url("res-filtro/f");
        $url_table_res= url("res-filtro/t");
        $url_relaciones= url("rel-filtro");
        $url_data_res= url("res-aux");
        $url_inicio=url("filtros");
        if( $OPERACION=="A")
        return view('informes.filtros.form',
         ["OPERACION"=> $OPERACION, "index"=> $url_inicio , "res_fields"=>$url_fields_res, 
         "res_tables"=>$url_table_res, 'res_relaciones'=> $url_relaciones ,'url_data_res'=>$url_data_res]);
         if( $OPERACION=="M")
         return view('informes.filtros.form',
          ["OPERACION"=> $OPERACION, "DATO"=> Filtros::find($id ), "index"=> $url_inicio , "res_fields"=>$url_fields_res, 
          "res_tables"=>$url_table_res, 'res_relaciones'=> $url_relaciones ,'url_data_res'=>$url_data_res]);
       } 
}

 

public function borrar( $NRO){
    $this->obtenerConexion();
    $ob= DB::table("filtros")->where('NRO',$NRO , 1)->delete();
   if( $ob ) echo json_encode( array('IDNRO'=>  $NRO  ) );
   else json_encode( array( 'error'=> "Hubo un error al guardar uno de los datos") );

}

public function list( $tabl){
    $this->obtenerConexion();
    $ls= DB::table( "filtros") ->where("ABOGADO", session("abogado"))->get();
    $L= <<<EOF
    
    EOF;
  /*  $ROW= <<<EOF 
    <tr> 
        <td style='text-align:left;'>  </td> 
        <td style='max-width:200px;'>  </td>
    </tr>
EOF;*/
    return view('informes.filtros.grilla' , ["lista"=>  $ls ]);
}



private function limpiarQuery( $SqlParam ){
    $this->obtenerConexion();
    $sql= $SqlParam;
    //Verificar si es una sentencia sql antigua
    if( ! preg_match("/\s*select\s*/i", $sql)  ){

        //Quitar comillas innecesarias
        $sql= preg_replace('/(^")|("$)/',"", $sql);
        //Verificar uso de funciones de fecha
        $sql= preg_replace('/(ctod)\(""(\d+\/\d+\/\d+)""\)/i', "str_to_date('$2','%d/%m/%Y')", $sql);
        $sql= preg_replace( "/(ctod)\('(\d+\/\d+\/\d+)'\)/i", "str_to_date('$2','%d/%m/%Y')", $sql);
        //eLIMINAR NOMBRES ERRONEOS DE CAMPOS
        $sql= preg_replace('/(LIQUIDACION)/',"LIQUIDACIO", $sql);
        //Modificar operadores incorrectos
        $sql= preg_replace('/(=>)/',">=", $sql);

        $sql= "select demandado.CI, demandado.TITULAR,demandas2.* from demandas2,notificaciones,demandado where demandas2.IDNRO=notificaciones.IDNRO 
        AND demandado.CI=demandas2.CI AND ".$sql; 
    }else{
        //agregar EL CAMPO TITULAR
        $campos_para_rec= (explode( "select", $sql))[1];
        $separadoFrom= explode( "from", $campos_para_rec);
        $adicional1= "select demandado.TITULAR,demandado.CI,".$separadoFrom[0];

        $separadoWhere= explode("where", $separadoFrom[1]);
        $adicional2= $separadoWhere[0].", demandado ";
        $adicional3= $separadoWhere[1]. " and demandas2.CI=demandado.CI";
        $sql=$adicional1." from ".$adicional2." where ".$adicional3;

    }
    //lIMPIAR
    $sql_1=preg_replace("/(&&)|(\.AND\.)/i"," AND ", $sql);
    $sql_2= preg_replace("/(\|\|)|(\.or\.)/i", "OR", $sql_1);
   
    //EJECUTAR 
   $ls= DB::select(  $sql_2);
    return $ls;
}
 

public function aviso_recorte_cols( $id_consulta){
    $this->obtenerConexion();
    $Filtro= Filtros::find( $id_consulta);
    $resultados= $this->limpiarQuery( $Filtro->FILTRO );//Prepara la sentencia sql la ejecuta
    if( sizeof( $resultados) ){
       $cols=   sizeof(array_keys(get_object_vars($resultados[0]))) ;
       if( $cols> $this->NUMEROCOLS) echo json_encode(array("msg"=>"PARA UNA MEJOR VISUALIZACIÓN EN PDF, SE HA RECORTADO EL NÚMERO DE COLUMNAS"));
    }else echo json_encode(array("msg"=>"x"));
  
}


private function filtro_inteligente_th($clave){
    $this->obtenerConexion();
    $html="";
    $cssclass= strtolower( $clave);
    $html.="<th class=\"$cssclass\">$clave</th>";    
    return $html;
}

private function filtro_inteligente_td($clave, $VALOR){
    $this->obtenerConexion();
$html="";
$valor= $VALOR;

//Valores Referenciales
if($clave=="DEMANDANTE"){ 
    $x=DB::table("demandan")
    ->where( "IDNRO",$valor)
    ->first(); 
    $valor= !is_null( $x )? $x->DESCR: $valor ;
}
elseif( $clave=="TITULAR")
       { //cortar a 31 caracteres
        if( strlen( trim($valor) )  > 31) $valor= substr($valor, 0, 30);
           $html.="<td class=\"titular\">  $valor</td>";
        }
elseif( $clave=="O_DEMANDA"){//O_DEMANDA

    $ori= DB::table("odemanda")->where("IDNRO", $valor)->first();
    if( !is_null($ori))    $html.="<td class=\"odemanda\"> $ori->CODIGO</td>";
    
}elseif( $clave=="JUZGADO"){
    //JUZGADO
    $ori= DB::table("juzgado")->where( "IDNRO",$valor)->first();
    if( !is_null($ori))    $html.="<td class=\"juzgado\"> $ori->DESCR</td>";

}elseif( $clave=="ACTUARIA"){
    //ACTUARIA
    $ori= DB::table("actuaria")->where( "IDNRO",$valor)->first();
    if( !is_null($ori))    $html.="<td class=\"actuaria\"> $ori->DESCR</td>";
}
elseif( $clave=="JUEZ"){
    //ACTUARIA
    $ori= DB::table("juez")->where( "IDNRO",$valor)->first();
    if( !is_null($ori))    $html.="<td class=\"juez\"> $ori->DESCR</td>";
}else{

    $cssclass= strtolower($clave);
    $html.="<td class=\"$cssclass\">  $valor</td>";
}
   
   return $html;
}

public function  reporte( $id_consulta, $tipo="xls", $onlyHtml= "N"){
    $this->obtenerConexion();
    set_time_limit(0);
    ini_set('memory_limit', '-1');
    $Filtro= Filtros::find( $id_consulta);
    $resultados= $this->limpiarQuery( $Filtro->FILTRO );//Prepara la sentencia sql la ejecuta
  

    //Determinar el numero de columnas
    if( sizeof( $resultados) ){
        $cols=   sizeof(array_keys(get_object_vars($resultados[0]))) ;  
        if( $cols < $this->NUMEROCOLS)   $this->NUMEROCOLS=  $cols;
     } 
   
    
    if( $tipo == "xls"){ echo json_encode( $resultados ); 
      }//Devuelve los datos en JSON
    else{// Genera un PDF

    //EJECUTAR
        $Titulo= $Filtro->NOMBRE; 
        $html=<<<EOF
         <style>
         th{
             font-size:6pt;
             font-weight: bold;
             background-color: #bac0fe;
             color: #060327;
         }
         .ci{
            width: 50px;
         }
         .titular{
             width: 150px;
         }
         .idnro{
             width: 50px;
         }
         .o_demanda,.cod_emp{
             width: 60px;
         }
         
         .row{
             font-size: 6pt;
             padding: 0px;
         }
         td{
            padding: 0px;
         }
         .col{
             display:inline;
        }
         </style>
         <table>
         <thead>
         <tr>
        EOF;

       



        $cols=0;
         foreach( $resultados as $objeto):
            foreach( $objeto as $clave=>$valor):
            
                if( $cols== $this->NUMEROCOLS) break;
                $html.=$this->filtro_inteligente_th($clave);
                $cols++;
            endforeach;
        break;
         endforeach;
        $html.= "</tr></thead><tbody>";

     
        $num_cols=1; 
       $column_names= [];
       if( sizeof($resultados)) $column_names= array_keys(get_object_vars($resultados[0]));
 
       
       foreach( $resultados as $objeto): 
      
            $html.="<tr class=\"row\">"; 
            foreach($column_names as $clave):
                $valor= $objeto->{$clave}; 
                 $html.= $this->filtro_inteligente_td($clave, $valor);
                 if($num_cols == $this->NUMEROCOLS) {   $num_cols= 1; break;}
                $num_cols++;
            endforeach;
         
            $html.="</tr>"; 
        endforeach; 
        $html.="</tbody></table>";
 
        
        if( sizeof( $resultados) ){
            $tituloDocumento= $Titulo."-".date("d")."-".date("m")."-".date("yy")."-".rand();
          $pdf = new PDF("L"); 
            $pdf->prepararPdf("$tituloDocumento.pdf", $tituloDocumento, ""); 
            $pdf->generarHtml( $html);
            if( $onlyHtml=="N")
            $pdf->generar();
            else{
                
                echo $html;
            }
        }
          }//End Pdf gen
}


 
 



}