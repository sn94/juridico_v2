@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">GASTOS</li>  
@endsection

@section('content')


@php
use App\Mobile_Detect;

$dete= new Mobile_Detect();
$iconsize=  $dete->isMobile() ? "": "fa-lg";

echo link_to('gasto', $title = "AGREGAR", $attributes = [ "class"=>"btn btn-sm btn-primary mb-1" ,  "data-toggle"=>"modal", "data-target"=>"#showform", "onclick"=> "mostrar_form(event)"], $secure = null);
 
@endphp
 

  <!--MANDAR A IMPRIMIR -->
<a  href="<?= url("rep-gastos")?>" data-toggle="modal" data-target="#show_opc_rep" onclick="mostrar_informe(event)" style="color:black;" > <i class="mr-2 ml-2 fa fa-print {{$iconsize}}" aria-hidden="true"></i></a>

{!! Form::select('', $CODGASTO, null, [ 'id'=>'CODGASTO','class'=>'form-control form-control-sm', 'onchange'=>'filtrarPorCodigo(event)']  ) !!} 


<form id="gastos-search" action="<?=url("grillgastos")?>" method="post"  onsubmit="actualizar_grill_parametros(event)">
@csrf  

<!--Filtro: ES GASTO POR DEMANDA U OTROS --> 
<div class="form-check form-check-inline">
  <input checked class="form-check-input" type="radio" name="modo" id="inlineRadio1" value="T">
  <label class="form-check-label" for="inlineRadio1">TODO</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="modo" id="inlineRadio2" value="D">
  <label class="form-check-label" for="inlineRadio2">POR DEMANDAS</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="modo" id="inlineRadio3" value="V">
  <label class="form-check-label" for="inlineRadio3">POR VARIOS</label>
</div>


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
 <button   type="submit" class="btn btn-sm btn-primary mt-1">BUSCAR</button>
  </div>
</div>
</form>


<div id="grilla"  >
 @include("gastos.grilla")
</div>


<!-- modal -->
<div id="showform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="viewform">
      
    </div>
  </div>
</div>
<!-- modal -->

 
<!-- MODAL TIPO DE INFORME -->
<div id="show_opc_rep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
    <a  id="info-xls" onclick="callToXlsGen(event, '{{$TITULO}}')" class="btn btn-sm btn-info" href="#" ><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <h3>EXCEL</h3></a>
   
    <a  id="info-pdf"  onclick="download_pdf(event)" class="btn btn-sm btn-info" href="#"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><h3>PDF</h3></a>
    <a  id="info-print"  onclick="print_(event)" class="btn btn-sm btn-info" href="#"><i class="fa fa-print fa-2x" aria-hidden="true"></i><h3>Printer</h3></a>
    </div>
  </div>
</div>
    
@endsection


<script>


function filtrarPorCodigo(ev){
 let cod= ev.currentTarget.value;
 $.ajax({
    url: "<?=url("filtrar-gastos-codigo")?>/"+cod,
    beforeSend: function(){  $("#grilla").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" )},
    success: function(resu){ $("#grilla").html( resu)  ; },
    error: function(){$("#grilla").html( "<h6>Error al recuperar datos</h6>")  ;}
  });
}

/**REPORTE */ 

function mostrar_informe(ev){
    ev.preventDefault();
    let pdf= ev.currentTarget.href+"/pdf";
    let xls= ev.currentTarget.href+"/xls";
    let prin= ev.currentTarget.href+"/PRINT";
  
     $("#info-xls").attr("href", xls );
     $("#info-pdf").attr("href", pdf  ); 
     $("#info-print").attr("href", prin  ); 
  }



/**VALIDACIONES */
    
function solo_numero(ev){
   
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart ); 
    } 
    let val_Act= ev.target.value;  
  val_Act= val_Act.replaceAll( new RegExp(/[\.]*[,]*/), ""); 
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		$( ev.target).val(  enpuntos);
	} 



//Recibe: Un campo de tipo numerico
//Efecto: Da formato de puntos al valor del campo
function numero_con_puntuacion( obj ) {
    let val_Act= obj.value;  
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		$(obj).val(  enpuntos);
   }

  function quitarSeparador( ele){ 
 ele.value=  ele.value.replaceAll(/\./g , "");
}


function mostrar_form(ev){
  ev.preventDefault();
let divname= "#viewform";
  $.ajax(
       {
         url:  ev.currentTarget.href, 
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function(res){  $(divname).html(  res );
         },
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );
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
let divname= "#viewform";
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
                            alert("CUENTA BORRADA.");
                            $("#"+r.IDNRO).remove();
                            }
                      }/************* */
         },
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );
}


function actualizar_grill(){
  $.ajax({
    url: "<?=url("grillgastos")?>",
    beforeSend: function(){  $("#grilla").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" )},
    success: function(resu){ $("#grilla").html( resu)  ; },
    error: function(){$("#grilla").html( "<h6>Error al recuperar datos</h6>")  ;}
  });
}


function actualizar_grill_parametros(e){ 
  e.preventDefault(); 
  //if( $("#Desde").val()  != "" && $("#Hasta").val()  != "")
  ajaxCall(e, "#grilla", function(resu){ $("#grilla").html( resu)  ; } );
  //else
  //alert("Proporcione las fechas")
}


 
function ajaxCall( e, divnam, succes, data){

  let urL= e;
  if( typeof e == "object")  urL= e.target.action;
  let divname=divnam;
  $.ajax(
       {
         url:  urL,
         method: "post",
         data:  data==undefined ? $("#"+e.target.id).serialize(): data,
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
function guardar( ev ){//Objeto event   DIV tag selector to display   success handler
 
ev.preventDefault();
 
if( $("#gastosform input[name=IMPORTE]").val()==""){ alert("INGRESE EL IMPORTE!"); return;}
//El gastos es por demanda ?
if( !($("#GastDema").prop("checked"))  &&  !($("#OtrosGast").prop("checked"))  ){ 
  alert("INDIQUE EL TIPO DE GASTO"); return;
}
//quitar formato
$("#gastosform .number-format").each( function( indice, obj){    quitarSeparador( obj); } );


 ajaxCall( ev, "#mensaje", function(res){
            $( "#mensaje").html(JSON.parse(res).ok ); 
            $("#showform" ).modal("hide")
            actualizar_grill();
            //recuperar formato
          $("#gastosform .number-format").each( function( indice, obj){    numero_con_puntuacion( obj); } );

         });
}/*****end ajax call* */

  
 
function cargar_grilla(){
  $.ajax( {url: "<?= url("gastos")?>",
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

function ordena_grilla(col,  sentido){
  $.ajax( {url: "<?= url("gast-orden")?>/"+col+"/"+sentido,
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

   


   
function download_pdf( e){
  e.preventDefault();
  let formu=document.getElementById("gastos-search");
  let action_old=  formu.action;
  formu.target="_blank";
  formu.action= $("#info-pdf").attr("href");
  formu.submit();
  //al estado inicial
  formu.action=  action_old;
  formu.removeAttribute("target");
  //let divname="#status";
   
}




function print_( e){
  e.preventDefault();
  let formu=document.getElementById("gastos-search");
   
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



</script>

