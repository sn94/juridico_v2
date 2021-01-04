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
<a  href="<?= url("informes-arre-extra")?>" data-toggle="modal" data-target="#show_opc_rep" onclick="mostrar_informe(event)" style="color:black;" > <i class="mr-2 ml-2 fa fa-print {{$iconsize}}" aria-hidden="true"></i></a>
 

<form id="arreglo-search" action="<?=url("informes-arre-extra")?>" method="post"  onsubmit="actualizar_grill_parametros(event)">
@csrf
  <!--Parametros de fecha --> 
<div class="row">
<div class="col-2 col-sm-1 col-md-2  col-lg-1">
<span style="font-size: 10pt; font-weight: 600;">Desde:</span> 
</div>
  <div class="col-10 col-sm-4 col-md-4 col-lg-2">
  <input class="form-control form-control-sm" type="date" id="Desde" name="Desde"> 
  </div>

  <div class="col-2 col-sm-1 col-md-2 col-lg-1">
  <span style="font-size: 10pt; font-weight: 600;">Hasta: </span>
</div>

<div class="col-10 col-sm-4 col-md-4 col-lg-2">
 <input class="form-control form-control-sm"  type="date" id="Hasta" name="Hasta">
  </div>
  <div class="col-6 col-sm-2 col-md-3 col-lg-1 d-flex">
 <button style="background-color: #fdc673;color: #1a0c00;" type="submit" class="btn btn-sm btn-info mt-1">BUSCAR</button>
  </div>
</div>
</form>

<div id="status"></div>
<div id="grilla"  >
@include("informes.arreglo_extraju.grilla_cuotas")
</div>


 

 
<!-- MODAL TIPO DE INFORME -->
<div id="show_opc_rep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
    <a  id="info-xls" onclick="download_excel(event)" class="btn btn-sm btn-info" href="<?=url("informes-arre-extra/XLS")?>" ><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <h3>EXCEL</h3></a>
   
    <a  id="info-pdf"  onclick="download_pdf(event)" class="btn btn-sm btn-info" href="<?=url("informes-arre-extra/PDF")?>" ><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><h3>PDF</h3></a>
    <a  id="info-print" class="btn btn-sm btn-info" href="#"><i class="fa fa-print fa-2x" aria-hidden="true"></i><h3>Printer</h3></a>
    </div>
  </div>
</div>
    
@endsection


<script>


 

/**REPORTE */ 

function download_excel( e){
  e.preventDefault();
  let formu=document.getElementById("arreglo-search");

  ajaxCall( e.currentTarget.href, "#status", function(res){
    $( "#status").html("");
    callToXlsGen_with_data("ARREGLOS EXTRAJUDICIALES", res)
  },   $(formu).serialize())
}



function download_pdf( e){
  e.preventDefault();
  let formu=document.getElementById("arreglo-search");
  formu.target="_blank";
  formu.action= $("#info-pdf").attr("href");
  formu.submit();
  formu.action= "<?=url("informes-arre-extra")?>";
  let divname="#status";
  /*$.ajax(
       {
         url:   $("#arreglo-search").attr("action"),
         method: "post",
         cache: false,
         contentType: "application/json",
         processData: false,
         data:    $("#arreglo-search").serialize()  ,
         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function( res){
          
         },
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );*/
}



function mostrar_informe(ev){
    ev.preventDefault();
   
    
    let pdf= ev.currentTarget.href+"/PDF";
    let xls= ev.currentTarget.href+"/XLS";
  
     $("#info-xls").attr("href", xls );
     $("#info-pdf").attr("href", pdf  ); 
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
  $.ajax(
       {
         url:  urL,
         method: "post",
         data:  datos== undefined ? $("#"+e.target.id).serialize() : datos,
         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: succes,
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );
}


 function setting_datatable( $data){
  $('#informes_arreglo').DataTable( {
    
          paging: false,
          "language": {   "url": "<?=url("assets/Spanish.json")?>"  }
        } );
 }
 
</script>

