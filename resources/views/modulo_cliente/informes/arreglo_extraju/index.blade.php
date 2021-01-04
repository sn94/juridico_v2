@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">ARREGLOS EXTRAJUDICIALES</li>  
@endsection

@section('content')


@php
use App\Mobile_Detect;

$dete= new Mobile_Detect();
$iconsize=  $dete->isMobile() ? "": "fa-lg";

@endphp
 

  <!--MANDAR A IMPRIMIR -->
<a  href="<?=url("informes-arregloextrajudicial")?>" data-toggle="modal" data-target="#show_opc_rep" onclick="mostrar_informe(event)" style="color:black;" > <i class="mr-2 ml-2 fa fa-print {{$iconsize}}" aria-hidden="true"></i></a>
 

<form id="arreglo-search" action="<?=url("informes-arregloextrajudicial")?>" method="post"  onsubmit="actualizar_grill_parametros(event)">
@csrf
<div class="row">
<div class="col-12 col-sm-4 col-md-4  col-lg-3 no-gutters">
<span style="font-size: 10pt; font-weight: 600; ">Desde:</span> 
<input class="form-control form-control-sm" type="date" id="Desde" name="Desde"> 
</div>
   
<div class="col-12 col-sm-4 col-md-4 col-lg-3">
<span style="font-size: 10pt; font-weight: 600;">Hasta: </span>
 <input class="form-control form-control-sm"  type="date" id="Hasta" name="Hasta" >
  </div>
  <div class="col-12 col-sm-2 col-md-2 col-lg-1 d-flex">
 <button style="background-color: #a3c5fc;color: #1a0c00;" type="submit" class="btn btn-sm btn-info mt-1">BUSCAR</button>
  </div>
  
</div>
</form>

<div id="status"></div>
<div id="grilla"  >
@include("informes.arreglo_extraju.grilla")
</div>


 

 
<!-- MODAL TIPO DE INFORME -->
<div id="show_opc_rep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
    <a  id="info-xls" onclick="download_excel(event)" class="btn btn-sm btn-info" href="<?=url("informes-arre-extra/XLS")?>" ><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <h3>EXCEL</h3></a>
   
    <a  id="info-pdf"  onclick="download_pdf(event)" class="btn btn-sm btn-info" href="<?=url("informes-arre-extra/PDF")?>" ><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><h3>PDF</h3></a>
    <a  id="info-print"  onclick="print_(event)" class="btn btn-sm btn-info" href="#"><i class="fa fa-print fa-2x" aria-hidden="true"></i><h3>Printer</h3></a>
    </div>
  </div>
</div>
    
@endsection


<script>


 

/**REPORTE */ 

function download_excel( e){
  e.preventDefault();
  
  ajaxCall( e.currentTarget.href, "#status", function(res){
    $( "#status").html("");
    callToXlsGen_with_data("ARREGLOS EXTRAJUDICIALES", res)
  });
}



function download_pdf( e){
  e.preventDefault();
  let formu=document.getElementById("arreglo-search");
  let respath=   "<?=url("informes-arregloextrajudicial")?>"
  formu.target="_blank";
  formu.action= $("#info-pdf").attr("href");
  formu.submit();
  formu.action= respath;
  let divname="#status";
   
}



function print_( e){
  e.preventDefault();
  let formu=document.getElementById("arreglo-search");
   
  ajaxCall( e.currentTarget.href, "#status", function(res){
    $( "#status").html("");
    printDocument(res);
  } );
}

function printDocument( html){
   
  
   //print
 let documentTitle="ARREGLOS EXTRAJUDICIALES";
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
   
    
    let pdf= ev.currentTarget.href+"/PDF";
    let xls= ev.currentTarget.href+"/XLS";
    let PRI= ev.currentTarget.href+"/PRINT";

     $("#info-xls").attr("href", xls );
     $("#info-pdf").attr("href", pdf  ); 
     $("#info-print").attr("href", PRI  ); 
  }



 
 
 

function actualizar_grill_parametros(e){ 
  e.preventDefault(); 
  if( $("#Desde").val()  != "" && $("#Hasta").val()  != "")
  ajaxCall(e, "#grilla", function(resu){ 
              //Recibir un json
                          $("#grilla").html( resu)  ; 
              } );
  else
  alert("Proporcione las fechas")
}


 
function ajaxCall( e, divnam, succes, datos){
console.log( datos);
  let urL= e;
  if( typeof e == "object")  urL= e.target.action;
  let divname=divnam;
  let setting=  {
         url:  urL,
         method: "post",
         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: succes,
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       };
       if( datos != undefined)  setting.data= $("#"+e.target.id).serialize();
  $.ajax(  setting  );
}


 function setting_datatable( $data){
  $('#informes_arreglo').DataTable( {
    
          paging: false,
          "language": {   "url": "<?=url("assets/Spanish.json")?>"  }
        } );
 }
 
</script>

