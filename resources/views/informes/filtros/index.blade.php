@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">FILTROS</li>  
@endsection

@section('content')
 
 
<!--FORM HELPER -->
<form action="" id="form-helper"></form>

<input type="hidden" id="RUTA1" value="{{$ejecucionxls}}">
<input type="hidden" id="RUTA2" value="{{$ejecucionpdf}}">

<div class="row">
  <div class="col-2 col-sm-2 col-md-2 col-lg-1">
  <a class="btn btn-sm btn-primary" href="<?= url("nfiltro") ?>">NUEVO</a>
  </div> 
</div>


         
<div id="statusform">

</div>
<div id="grilla">
 
@include("informes.filtros.grilla")
 
</div> 

	
 


  
   <!-- MODAL TIPO DE INFORME -->
<div id="show_opc_rep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
    <a  id="info-xls" onclick="abrir_excel(event)" class="btn btn-sm btn-info" href="#" ><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <h3>EXCEL</h3></a>
   
    <a  id="info-pdf" onclick="abrir_PDF(event)"  class="btn btn-sm btn-info" href="#"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><h3>PDF</h3></a>
    <a  id="info-print" onclick="printDocument(event)" class="btn btn-sm btn-info" href="#"><i class="fa fa-print fa-2x" aria-hidden="true"></i><h3>Printer</h3></a>
    </div>
  </div>
</div>



 
@endsection 

 
<script>



function ordena_grilla(col,  sentido){
  $.ajax( {url: "<?= url("filtro-orden")?>/"+col+"/"+sentido,
    beforeSend: function(){
           $( "#grilla").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         }, 
           success: function(res){
            $( "#grilla").html(res);
           },
           error: function(){
            $( "#grilla").html("ERROR AL RECUPERAR GASTOS");
           }
          });

}


function cargar_grilla(){
  $.ajax( {url: "<?= url("filtros")?>",
    beforeSend: function(){
           $( "#grilla").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         }, 
           success: function(res){
            $( "#grilla").html(res);
           },
           error: function(){
            $( "#grilla").html("ERROR AL RECUPERAR FILTROS");
           }
          });
}
  
function jsonReceiveHandler( data, divname){// string JSON to convert     div Html Tag to display errors
  try{
             let res= JSON.parse( data);
             if( "error" in res){
               $( divname).html(  `<h6 style='color:red;'>${res.error}</h6>` ); return false; 
             }else{   return res;  }
           }catch(err){
             $(divname).html(  `<h6 style='color:red;'>${err}</h6>` );  return false;
           } return false;
}/***End Json Receiver Handler */


function borrar(ev){
    ev.preventDefault();
if( !confirm("SEGURO QUE DESEA BORRARLO?") ) return;
let divname= "#statusform";
  $.ajax(
       {
         url:  ev.currentTarget.href, 
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function(res){  
            let r= jsonReceiveHandler( res );
                      if( typeof r != "boolean"){
                          if( "error" in r) alert( r.error);
                          else{ 
                            alert("FILTRO BORRADO.");
                            $("#"+r.IDNRO).remove();
                            }
                      }/************* */
                      $( divname).html("");
         },
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );
}



function abrir_excel(ev){
  ev.preventDefault();
   //obtener id de filtro
   let filtros_parts= $("#info-pdf").attr("href").split("/");
    let id_filtro= filtros_parts[ filtros_parts.length-2];
    //Obtener nombre del filtro
    $.get("<?=url("filtro-nombre")?>/"+id_filtro, 
    function(res){
   
      //Generar xls
      $.ajax({url:  $("#info-xls").attr("href"), success: function( datos){
          callToXlsGen_with_data(  res.nombre, datos);
      }});
     
    }, 
    "json");
}


function abrir_PDF(ev ){
    ev.preventDefault();
    //obtener id de filtro
    let filtros_parts= $("#info-pdf").attr("href").split("/");
    let id_filtro= filtros_parts[ filtros_parts.length-2];
      //obtener aviso
    $.ajax(
      { url: ev.currentTarget.href , 
      success: function( r){ 
             if(   r == "") alert("Sin registros");
             else
            { $("#form-helper").attr("action", $("#info-pdf").attr("href") );
             $("#form-helper").submit();}
          
      }});
}


/**IMPRIMIR */

async function getFiltroData( url_){

let urlBill= url_;
let respuesta= await fetch( urlBill);
let html="";
if( respuesta.ok)  html=  await respuesta.text();
return html;
}


async function printDocument( ev){
    ev.preventDefault(); 
    let url=  ev.currentTarget.href;
let html= await getFiltroData( url);
  //print
let documentTitle="FILTROS";
var ventana = window.open( "", 'PRINT', 'height=400,width=600,resizable=no');
ventana.document.write("<style> @page   {  size:  auto;   margin: 0mm;  margin-left:10mm; }</style>");
ventana.document.write( html);
ventana.document.close(); 
  ventana.focus();
ventana.print();
ventana.close();
return true;
}
 




function mostrar_informe(ev){
    ev.preventDefault();
    let report_path= ev.currentTarget.href; 
   
     let xlsr=   report_path+"/xls"  ;
     let pdfr=  report_path+"/pdf" ; 
     let printr= report_path+"/pdf/S";
     $("#info-xls").attr("href", xlsr );
     $("#info-pdf").attr("href", pdfr  );
    $("#info-print").attr("href",printr );
   
       //obtener id de filtro
    let filtros_parts= $("#info-pdf").attr("href").split("/");
    let id_filtro= filtros_parts[ filtros_parts.length-2];

    //obtener aviso
    $.ajax(
      { url: "<?=url('filtro-aviso-rec')?>/"+id_filtro  ,
      dataType:"json", 
      success: function( msg){
             ///derivar pdf
             if( msg.msg != "x")
            alert(msg.msg); 
      }});
  }



 
</script>