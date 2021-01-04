@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">CTA.BANCO</li> 
<li class="breadcrumb-item" aria-current="page">MOVIMIENTOS</li> 
@endsection

@section('content')

<?php


use App\Mobile_Detect;

$dete= new Mobile_Detect();
$iconsize=  $dete->isMobile() ? "": "fa-lg";
?>



 
<h5>{{$TITULAR}}</h5>
{{$BANCO}} &nbsp;CTA.N°&nbsp;{{$CUENTA}}


<a data-toggle="modal" data-target="#showform"    onclick="mostrar_form(event)" href="<?= url("depobank/".$IDNRO) ?>"><i class="fa fa-plus-square {{$iconsize}}" aria-hidden="true"></i>DEPOSITAR</a> 
<a data-toggle="modal" data-target="#showform"    onclick="mostrar_form(event)" href="<?= url("extrbank/".$IDNRO) ?>"><i class="fa fa-minus-square {{$iconsize}}" aria-hidden="true"></i>EXTRAER</a>
             
<div id="viewform">

</div>
<div id="grilla">
@include("bancos.grilla_mov")

</div>


<div id="showform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" id="viewformmodal">
      
    </div>
  </div>
</div>




@endsection


<script>

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

  function quitarSeparador( ele){ 
return ele.replaceAll(/\./g , "");
}


function mostrar_form(ev){
let divname= "#viewformmodal";
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
                      $( divname).html(  ""); 
         },
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );
}


function actualizar_grill(){
  $.ajax({
    url: "{{$LINK}}",
    beforeSend: function(){  $("#grilla").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" )},
    success: function(resu){ $("#grilla").html( resu)  ; },
    error: function(){$("#grilla").html( "<h6>Error al recuperar datos</h6>")  ;}
  })
}



function noempty_fields(){
  if($("input[name=TITULAR]").val() =="") alert("FALTA NOMBRE DEL TITULAR!");
  if($("input[name=CUENTA]").val() =="") alert("FALTA EL NUMERO DE CUENTA!");
  if($("input[name=BANCO]").val() =="") alert("FALTA EL BANCO!");
  return !($("input[name=TITULAR]").val()=="" || $("input[name=CUENTA]").val() =="" || $("input[name=BANCO]").val() =="" );
}


function ajaxCall( e, divnam, succes){

  let divname=divnam;
  $.ajax(
       {
         url:  e.target.action,
         method: "post",
         data: $("#"+e.target.id).serialize(),
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
 
 

function movimiento(ev){
  ev.preventDefault();
  if( $("#formmovi input[name=IMPORTE]").val()==""){ alert("INGRESE EL IMPORTE!"); return;}
 
if ( ! noempty_fields( )) return;
 
$("#formmovi input[name=IMPORTE]").val(  quitarSeparador( $("#formmovi input[name=IMPORTE]").val()   )  );
 ajaxCall( ev, "#mensaje-movi", function(res){
            $( "#mensaje-movi").html(JSON.parse(res).ok ); 
           // $('#showform').modal('hide')
            actualizar_grill();
         });
}


</script>

