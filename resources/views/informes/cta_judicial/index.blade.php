@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">ESTADOS DE CUENTAS JUDICIALES</li>  
@endsection

@section('content')

 
 

  <!--MANDAR A IMPRIMIR -->
<a  href="<?=url("informes-cuentajudicial")?>" data-toggle="modal" data-target="#show_opc_rep" onclick="mostrar_informe(event)" style="color:black;" > <i class="mr-2 ml-2 fa fa-print fa-lg" aria-hidden="true"></i></a>
 

<form class="mt-2" id="cuenta-judicial-search" action="<?=url("informes-cuentajudicial")?>" method="post"    >
@csrf
   
<div class="row">
 
<div class="col-10 col-md-3" >
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1"><button style="border: none; background: none;" type="submit"><i class="mr-2 ml-2 fa fa-search fa-lg" aria-hidden="true"></i></button></span>
  </div>
  <input id="CEDULA" placeholder="CEDULA" type="text" name="CEDULA" class="form-control form-control" value="{{isset($CEDULA)?$CEDULA:'' }}">
</div>
</div>
</div>


 

</form>

<div id="status"></div>
<div id="grilla"  >
@include("informes.cta_judicial.grilla")
</div>


 

 
<!-- MODAL TIPO DE INFORME -->
<div id="show_opc_rep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
    <a  id="info-xls" onclick="download_excel(event)" class="btn btn-sm btn-info" href="<?=url("informes-cuentajudicial/XLS")?>" ><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <h3>EXCEL</h3></a>
   
    <a  id="info-pdf"  onclick="download_pdf(event)" class="btn btn-sm btn-info" href="<?=url("informes-cuentajudicial/PDF")?>" ><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><h3>PDF</h3></a>
    <a  id="info-print" onclick="print_( event)" class="btn btn-sm btn-info" href="<?=url("informes-cuentajudicial/S")?>"><i class="fa fa-print fa-2x" aria-hidden="true"></i><h3>Printer</h3></a>
    </div>
  </div>
</div>
    
@endsection


<script>

 


 function printDocument( html){
   
  
  //print
let documentTitle="ESTADO CTA. JUDICIAL";
var ventana = window.open( "", 'PRINT', 'height=400,width=600,resizable=no');
ventana.document.write("<style> @page   {  size:  auto;   margin: 0mm;  margin-left:10mm; }</style>");
ventana.document.write( html);
ventana.document.close(); 
  ventana.focus();
ventana.print();
ventana.close();
return true;
}

 

 

/**REPORTE */ 

function download_excel( e){
  e.preventDefault();
  
  ajaxCall( e.currentTarget.href, "#status", function(res){
    $( "#status").html("");
    callToXlsGen_with_data("ESTADO DE CUENTA JUDICIAL", res)
  },   {"CEDULA" : $("#CEDULA").val() });
}



function download_pdf( e){
  e.preventDefault();
  let formu=document.getElementById("cuenta-judicial-search");
  let respath=   "<?=url("informes-cuentajudicial")?>"
  formu.target="_blank";
  formu.action= $("#info-pdf").attr("href");
  formu.submit();
  formu.action= respath;
  //QUITAR _BLANK
  formu.removeAttribute("target");
  let divname="#status";
}


function print_( e){
  e.preventDefault();
  let formu=document.getElementById("cuenta-judicial-search");
   
  ajaxCall( e.currentTarget.href, "#status", function(res){
    $( "#status").html("");
    printDocument(res);
  },   {"CEDULA" : $("#CEDULA").val() });
}

function mostrar_informe(ev){
    ev.preventDefault();
    let pdf= ev.currentTarget.href+"/PDF";
    let xls= ev.currentTarget.href+"/XLS";
    let pri=  ev.currentTarget.href+"/S";
     $("#info-xls").attr("href", xls );
     $("#info-pdf").attr("href", pdf  ); 
     $("#info-print").attr("href", pri  ); 
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
       if( datos != undefined)  setting.data= datos;
  $.ajax(  setting  );
}


 function setting_datatable( $data){
  $('#informes_arreglo').DataTable( {
    
          paging: false,
          "language": {   "url": "<?=url("assets/Spanish.json")?>"  }
        } );
 }
 
</script>

