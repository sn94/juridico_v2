@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">SEGUIMIENTO DE NOTIFICACIONES</li>  
@endsection


@section('content')

 


<div class="container-fluid">

    
<form id="noti-search" action="<?=url("dema-noti-venc")?>" method="post"  onsubmit="actualizar_grill_parametros(event)">
@csrf  




<!--Parametros de fecha --> 
<div class="row">


<div class="col-12 col-md-4">
<!--Filtro: ES GASTO POR DEMANDA U OTROS --> 
<div class="form-check form-check-inline">
  <input checked class="form-check-input" type="radio" name="modo" id="inlineRadio1" value="T">
  <label class="form-check-label" for="inlineRadio1">TODO</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="modo" id="inlineRadio2" value="V">
  <label class="form-check-label" for="inlineRadio2">VENCIDOS</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="modo" id="inlineRadio3" value="NV">
  <label class="form-check-label" for="inlineRadio3">POR VENCER</label>
</div>
</div>


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


<a   id="info-print"  data-target="#show_opc_rep" data-toggle="modal" style="color: black;" href="#">
<i class="fa fa-print fa-2x" aria-hidden="true"></i></a>


 <div id="grilla">
   @include("notificaciones.grilla")
 </div>
  

 <!--BORRADO --> 
 @if(session("tipo")=='S')
 <a    href="<?=url("del-noti-venc")?>" style="font-size: 10pt; color: #420000;font-weight: 600; " > «BORRAR NOTIFICACIONES VENCIDAS» </a>
@endif 



 <!-- MODAL TIPO DE INFORME -->
<div id="show_opc_rep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
    <a  id="info-xls" onclick="download_excel(event)" class="btn btn-sm btn-info" href="<?=url("rep-notificaciones/XLS")?>" ><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <h3>EXCEL</h3></a>
   
    <a  id="info-pdf" onclick="download_pdf(event)"  class="btn btn-sm btn-info" href="<?=url("rep-notificaciones/PDF")?>"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><h3>PDF</h3></a>
    <a  id="info-print" onclick="print_(event)" class="btn btn-sm btn-info" href="<?=url("rep-notificaciones/PRINT")?>" ><i class="fa fa-print fa-2x" aria-hidden="true"></i><h3>Printer</h3></a>
    </div>
  </div>
</div>

@endsection

<script>

function download_excel( e){
  e.preventDefault();
  let formu=document.getElementById("noti-search");

  ajaxCall( e.currentTarget.href, "#status", function(res){
    $( "#status").html("");
    callToXlsGen_with_data("NOTIFICACIONES", res)
  },   $(formu).serialize())
}



function download_pdf( e){
  e.preventDefault();
  let formu=document.getElementById("noti-search");
  let oldaction= formu.action;
  formu.target="_blank";
  formu.action= $("#info-pdf").attr("href");
  formu.submit();
  formu.action= oldaction;
  let divname="#status";}


 


 
function print_( e){
  e.preventDefault();
  let formu=document.getElementById("noti-search");
   
  ajaxCall( e.currentTarget.href, "#status", function(res){
    $( "#status").html("");
    printDocument(res);
  } ,  $(formu).serialize() );
}

function printDocument( html){
   
  
   //print
 let documentTitle="GASTOS";
 var ventana = window.open( "", 'PRINT', 'height=400,width=600,resizable=no');
 ventana.document.write("<style> @page   {  size:  auto;   margin: 0mm;  margin-left:10mm; }</style>");
 ventana.document.write( html);
 ventana.document.close(); 
   ventana.focus();
 ventana.print();
 ventana.close();
 return true;
 }






function ajaxCall( e, divnam, succes, DATOS){

let urL= e;
if( typeof e == "object")  urL= e.target.action;
let divname=divnam;
$.ajax(
     {
       url:  urL,
       method: "post",
       data:  DATOS==undefined? $("#"+e.target.id).serialize(): DATOS,
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


function actualizar_grill_parametros(e){ 
  e.preventDefault(); 
  //if( $("#Desde").val()  != "" && $("#Hasta").val()  != "")
  ajaxCall(e, "#grilla", function(resu){ $("#grilla").html( resu)  ; } );
  //else
  //alert("Proporcione las fechas")
}



/*
document.onreadystatechange = () => {
  if (document.readyState === 'complete') {
    // document ready
    $('#demandatable').DataTable(
      {   
            "ordering": false,
            "language": {
              "url": "<?=url("assets/Spanish.json")?>"
            }
          }
    );
  }
};*/



       
    </script>