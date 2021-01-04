@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">LIQUIDACIONES</li> 
<li class="breadcrumb-item active" aria-current="page"> <?= ( $OPERACION == "V") ? "VER" : ( $OPERACION == "M" ?  "MODIFICAR": "NUEVO" ) ?></li> 
@endsection

@section('content')

<?php

use App\Helpers\Helper;

?>
 
<h4>{{isset( $CI)? $CI : ''}}-{{ isset( $dato->TITULAR)? $dato->TITULAR  : $TITULAR }}</h4>
<h4>Cuenta bancaria: {{ isset( $dato->CTA_BANCO)? $dato->CTA_BANCO  : ($CTA_BANCO ?? '') }}</h4>
<a  href="<?= url("liquida/".(isset( $dato->ID_DEMA)? $dato->ID_DEMA : $id_demanda)) ?>" class="btn btn-info btn-sm mb-1">LISTADO DE LIQUID.</a>
<?php  if( $OPERACION == "V" || $OPERACION == "M"  ):  ?>
<!--MANDAR A IMPRIMIR -->
<a   data-toggle="modal" data-target="#show_opc_rep"   onclick="mostrar_informe(event)" style="color:black;" href="<?=url("liquida")."/".$dato->IDNRO?>"> <i class="fa fa-print fa-lg " aria-hidden="true"></i>
</a>
<?php  endif;  ?>

<div id="myform">
@include("liquidaciones.form")
</div>
 



     <!-- MODAL TIPO DE INFORME -->

     @include("layouts.report", ["TITULO"=>"LIQUIDACIONES" ]  )


@endsection 

<script type="text/javascript"> 
 
  function quitarSeparador( ele){ 
    return ele.replaceAll(/\./g , "");
    }
  function quitarSeparadorInt( ele){ 
    if(ele.val()=="") return 0;
    else return parseInt( ele.val().replaceAll(/\./g , "") ); 
    }
    function quitarSeparadorPlus( ele){ 
      let nw= ele.val().replaceAll(/\./g , "");;
      ele.val(  nw  );  }

  /** Solo entrada numerica */
  function onlyNumber( ev){
   if(   ev.data == null) return;
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){
        ev.target.value=  ev.target.value.substr( 0, ev.target.selectionStart-1) +   ev.target.value.substr( ev.target.selectionStart );
      } 
  }
  //Borrar cualquier ocurrencias de puntos o comas en una cadena
  function formatear(ev){ 
    if( ev.data == null)  return;
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value=   ev.target.value.substr( 0, ev.target.selectionStart-1) +  ev.target.value.substr( ev.target.selectionStart );
    } 
    let val_Act= ev.target.value;  
    val_Act= val_Act.replaceAll( new RegExp(/[\.]*[,]*/), ""); 
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		$( ev.target).val(  enpuntos);
	} 

/**Formatea con separadores una cadena numerica  */
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
               $( divname).html(  `<h6 style='color:red;'>${res.error}</h6>` ); return false; 
             }else{   return res;  }
           }catch(err){
             $(divname).html(  `<h6 style='color:red;'>${err}</h6>` );  return false;
           } return false;
}/***End Json Receiver Handler */


function limpiarCampos(){
    quitarSeparadorPlus( $("#liquidaform input[name=IMP_INTERE]") ) ;
      quitarSeparadorPlus( $("#liquidaform input[name=GAST_NOTIF]") ) ;
      quitarSeparadorPlus( $("#liquidaform input[name=GAST_NOTIG]") ) ;
      quitarSeparadorPlus( $("#liquidaform input[name=GAST_EMBAR]") ) ;
      quitarSeparadorPlus( $("#liquidaform input[name=GAST_INTIM]") ) ;
      quitarSeparadorPlus( $("#finiquito") ) ;
      quitarSeparadorPlus( $("#liquidaform input[name=TOTAL]") ) ;
      quitarSeparadorPlus( $("#liquidaform input[name=EXTRAIDO]") ) ;
      quitarSeparadorPlus( $("#liquidaform input[name=HONORARIOS]") ) ;
      quitarSeparadorPlus( $("#liquidaform input[name=SALDO]") ) ;
      quitarSeparadorPlus( $("#liquidaform input[name=EXT_LIQUID]") ) ;
      quitarSeparadorPlus( $("#liquidaform input[name=NEW_SALDO]") ) ;
}
    function ajaxCall( ev, divname, success_f){//Objeto event   DIV tag selector to display   success handler

     limpiarCampos();
      $.ajax(
          {
            url:  ev.target.action,
            method: "post",
            data: $("#"+ev.target.id).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            beforeSend: function(){
              $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
              
            },
            success: success_f,
            error: function(){
              $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
            }
          }
        );
}/*****end ajax call* */



function enviarLiquida( ev){
  ev.preventDefault();
  if( confirm("CONTINUAR?") ){
    ajaxCall( ev, "#myform", function(res){
    let resu= jsonReceiveHandler(res);
    if( typeof resu == "boolean"){
      $("#myform").html(res  );
    }else{
      $( "#myform").html(  `<h6 style='color:red;'>${resu.error}</h6>` ); 
    }
  });
  } 
}



   //deshabilitar
   function habilitarCampos( targetId, hab){
    let target= document.getElementById(targetId);
    let context= target.elements;
    Array.prototype.forEach.call( context, function(ar){ar.disabled=!hab;   });
  }
 



  
  function mostrar_informe(ev){
    ev.preventDefault();
    let id= $("input[name=IDNRO]").val();
    let xls= "<?=url("jsonliquida")?>";
    let pdf= "<?=url("pdfliquida")?>";

    $("#info-xls").attr("href", xls+"/"+id );
    $("#info-pdf").attr("href", pdf+"/"+id );
    $("#info-print").attr("href", $("#info-print").attr("href")+"/"+id );
    ev.currentTarget.href.concat( id ) ;
  }




  window.onload=   function(){
    if( $("#OPERACION").val() == "V")
    habilitarCampos( "liquidaform", false);
};



</script>  


            
