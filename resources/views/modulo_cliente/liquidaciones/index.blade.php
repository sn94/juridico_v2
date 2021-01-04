@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">LIQUIDACIONES</li> 
<li class="breadcrumb-item active" aria-current="page">MOVIMIENTOS</li> 
@endsection

@section('content')

 
<?php

use App\Mobile_Detect; 

$detect= new Mobile_Detect();
if ($detect->isMobile() == false):?>
 <h4>{{ isset($CI) ? $CI." - ". $TITULAR  : ""}}</h4>  
 <h4>Cuenta bancaria: {{$CTA_BANCO}}</h4>
<?php else: ?>
  <p class="name-titular">{{ isset($CI) ? $CI." - ". $TITULAR  : ""}}</p>  
  <p class="name-titular">Cuenta bancaria:{{ $CTA_BANCO}}</p>  
<?php endif; ?>



 <a href="<?= url("nliquida/$id_demanda") ?>" class="btn btn-info btn-sm mb-2">AGREGAR</a>
 
  
 
 <!--TABLA-->
 <div class="table-responsive mt-2" id="tablamovi">
   @include("liquidaciones.grilla", ["lista"=> $lista])
     
 </div>



  

<!-- MODAL TIPO DE INFORME -->
<div id="show_opc_rep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
    <a  id="info-xls" onclick="callToXlsGen(event, 'LIQUIDACIONES')" class="btn btn-sm btn-info" href="#" ><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <h3>EXCEL</h3></a>
   
    <a  id="info-pdf"  class="btn btn-sm btn-info" href="#"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><h3>PDF</h3></a>
    <a  id="info-print" onclick="printDocument(event)" class="btn btn-sm btn-info" href="#"><i class="fa fa-print fa-2x" aria-hidden="true"></i><h3>Printer</h3></a>
    </div>
  </div>
</div>

<script type="text/javascript">
  function mostrar_informe(ev){
    ev.preventDefault();
    let report_path= ev.currentTarget.href; 
    let id= (ev.currentTarget.parentNode.parentNode.id) ==undefined ? "" :  (ev.currentTarget.parentNode.parentNode.id) ;// TR ID 
     let xlsr= id == "" ?  report_path+"/xls" : report_path+"/"+id+"/xls";
     let pdfr= id == "" ?  report_path+"/pdf" : report_path+"/"+id+"/pdf";
     $("#info-xls").attr("href", xlsr );
     $("#info-pdf").attr("href", pdfr  );

    $("#info-print").attr("href", pdfr+"/S");
    ev.currentTarget.href.concat( id ) ;
  }



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
let documentTitle="LIQUIDACIONES";
var ventana = window.open( "", 'PRINT', 'height=400,width=600,resizable=no');
ventana.document.write("<style> @page   {  size:  auto;   margin: 0mm;  margin-left:10mm; }</style>");
ventana.document.write( html);
ventana.document.close(); 
  ventana.focus();
ventana.print();
ventana.close();
return true;
}



  
 

    function borrar(ev){//form vista , edit

    ev.preventDefault();
    console.log( ev.target, ev.currentTarget);
      if(confirm("Seguro que desea borrarlo?")){
        $.ajax( {
            url: ev.currentTarget.href,
            success: function(res){ 
              let ob=JSON.parse( res );

               $("#myform").html( " <div class='alert alert-success'>  <h6>Movimiento borrado</h6>  </div> "); 
              actualizarGrill();
               },
            beforeSend: function(){  
                  $("#myform").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" );       
            }, 
            error: function(err){  $("#myform").html( "<h6 style='color:red;'>"+err+"</h6>" ); }
        });
      }
    }




function actualizarGrill(){
  $.ajax( {
            url: "<?= url("lliquida/$id_demanda")?>",
            success: function(res){  
               $("#tablamovi").html( res);  
               },
            beforeSend: function(){  
                  $("#tablamovi").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" );       
            }, 
            error: function(err){  $("#tablamovi").html( "<h6 style='color:red;'>"+err+"</h6>" ); }
        });
}

   
  /*
  Recibe una cadena de numeros
  Devuelve la cadena con separadores de puntos
  */
  function formatear_string(obj){
    let val_Act= String( obj);
    val_Act= val_Act.replaceAll( new RegExp(/[\.]*[,]*/), ""); 
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		return enpuntos;
	} 

  function jsonReceiveHandler( data, divname){// string JSON to convert     div Html Tag to display errors
  try{
             let res= JSON.parse( data);
             if( "error" in res){
               $( divname).html(  "<h6 style='color:red;'>"+res.error+"</h6>" ); return false; 
             }else{   return res;  }
           }catch(err){
             $(divname).html(  "<h6 style='color:red;'>"+err+"</h6>" );  return false;
           } return false;
}/***End Json Receiver Handler */



    


 


 
 


/**Verificar tabla vacia */
window.onload= function(){
  if( $("#tlistaliquida tbody").children().length <= 0 )
  alert("NO SE REGISTRAN LIQUIDACIONES EN ESTE JUICIO");
};


</script>  


            


@endsection 