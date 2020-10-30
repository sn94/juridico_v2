
@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">DEMANDAS</li> 
<li class="breadcrumb-item active" aria-current="page">{{ ($OPERACION=="A" || $OPERACION=="A+")? "AGREGAR":  ($OPERACION=="M"? "EDITAR":"FICHA") }}</li> 
@endsection

@section('content')

<style>

  a{
    color:#525252;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 10pt;
  }
</style>

<?php

use App\Mobile_Detect; 

$detect= new Mobile_Detect();
if ($detect->isMobile() == false):?>
 <h4>{{ isset($ci) ? $ci." - ". $nombre  : ""}}</h4>  
<?php else: ?>
  <p class="name-titular">{{ isset($ci) ? $ci." - ". $nombre  : ""}}</p>  
<?php endif; ?>
 

@if( $OPERACION=="M" || $OPERACION=="V")
    <a  class="btn btn-info btn-sm" href="<?=url("liquida/".$ficha->IDNRO)?>">LIQUIDACIÓN</a>
    <a  class="btn btn-info btn-sm" href="<?=url("ctajudicial/".$ficha->IDNRO)?>">CTAS.JUDICIALES</a>
@endif
 


  <!-- OCULTOS --> 
<input type="hidden" id="operacion" value="{{$OPERACION}}"> 
<input type="hidden" id="tab"  value="{{isset($tab)? $tab: 1}}">

<div class="nav-tabs-responsive">
  <ul class="nav nav-tabs mb-4">
  <li class="nav-item">
      <a id="pestana-persona" href="#persona" class="nav-link active" data-toggle="tab">
        <i class="icon-lock"></i> Datos personales
      </a>
    </li>
    <li class="nav-item">
      <a id="pestana-demanda"  href="#demanda" class="nav-link" data-toggle="tab">
        <i class="icon-lock"></i> Demanda
      </a>
    </li>
    <li class="nav-item">
      <a id="pestana-seguimiento" href="#seguimiento" class="nav-link" data-toggle="tab">
        <i class="icon-user"></i> Seguimiento
      </a>
    </li>
    <li class="nav-item">
      <a id="pestana-observacion" href="#observacion" class="nav-link" data-toggle="tab">
        <i class="icon-credit-card"></i> Observacion
      </a>
    </li>

    <li class="nav-item">
      <a  id="pestana-contraparte" href="#contraparte" class="nav-link" data-toggle="tab">
        <i class="icon-credit-card"></i> Interv. contraparte
      </a>
    </li>

    <li class="nav-item">
      <a id="pestana-extrajudicial"  href="#extrajudicial" class="nav-link" data-toggle="tab">
        <i class="icon-credit-card"></i> Arreglo Extrajud.
      </a>
    </li>
    
    <li class="nav-item">
      <a id="pestana-honorarios" href="#honorarios" class="nav-link" data-toggle="tab">
        <i class="icon-credit-card"></i> Honorarios
      </a>
    </li>

  </ul>
  <div id="formOrder" class="tab-content pr-md-2"  >
  <div id="persona" class="tab-pane show active">
      <div class="mb-3">
        <a href="#persona-collapse" data-toggle="collapse">
          <i class="icon-credit-card"></i> Datos personales
        </a>
      </div>
      <div id="persona-collapse" class="collapse" data-parent="#formOrder">
     
      @include("demandas.demandado_form", [ 'OPERACION'=>$OPERACION])

      </div>
    </div>

    <div id="demanda" class="tab-pane">
      <div class="mb-3">
        <a href="#demanda-collapse" data-toggle="collapse">
          <i class="icon-lock"></i> Demanda
        </a>
      </div>
      <div id="demanda-collapse" class="collapse show" data-parent="#formOrder">
      
      <?php  if( isset($ci) ):?>
        @include("demandas.demanda_form",  [ 'ci'=>$ci, 'OPERACION'=>$OPERACION])
      <?php else:?>
        @include("demandas.demanda_form",  [  'OPERACION'=>$OPERACION])
      <?php endif;?>
     
       
      </div>
    </div>
    <div id="seguimiento" class="tab-pane">
      <div class="mb-3">
        <a href="#seguimiento-collapse" data-toggle="collapse">
          <i class="icon-user"></i> Seguimiento
        </a>
      </div>
      <div id="seguimiento-collapse" class="collapse" data-parent="#formOrder">
         
      @include("demandas.notifi_form")
      </div>
    </div>
    <div id="observacion" class="tab-pane">
      <div class="mb-3">
        <a href="#observacion-collapse" data-toggle="collapse">
          <i class="icon-credit-card"></i> Observacion
        </a>
      </div>
      <div id="observacion-collapse" class="collapse" data-parent="#formOrder">
     
      @include("demandas.observa_form")

      </div>
    </div>

    <div id="contraparte" class="tab-pane">
      <div class="mb-3">
        <a href="#contraparte-collapse" data-toggle="collapse">
          <i class="icon-credit-card"></i> Interv. contraparte
        </a>
      </div>
      <div id="contraparte-collapse" class="collapse" data-parent="#formOrder">
     
      @include("demandas.contraparte_form")

      </div>
    </div>

    <div id="extrajudicial" class="tab-pane">
      <div class="mb-3">
        <a id="pestana-extrajudicial" href="#extrajudicial-collapse" data-toggle="collapse">
          <i class="icon-credit-card"></i> Arreglo Extrajudicial
        </a>
      </div>
      <div id="extrajudicial-collapse" class="collapse" data-parent="#formOrder">
     
      @include("demandas.extrajudicial_form")

      </div>
    </div>

   
    <div id="honorarios" class="tab-pane">
      <div class="mb-3">
        <a id="pestana-honorarios" href="#honorarios-collapse" data-toggle="collapse">
          <i class="icon-credit-card"></i> Honorarios
        </a>
      </div>
      <div id="honorarios-collapse" class="collapse" data-parent="#formOrder">
     
      @include("demandas.honorarios_form")  

      </div>
    </div>
  
    <hr>
   
</div>
</div>

 



<script>

//PESTANA SELECCIONADA
window.onload= function(){

let tab= document.getElementById("tab").value;
tab_selected( tab);
   // establecer SALDO CAPITAL   INICIAL



  //hAY INTERVENCION
  if( document.querySelector("#formContra input[name=ABOGADO]").value != "")
  $("#pestana-contraparte").css("background-color", "#ffaaaa");
 };


 function tab_selected( tab_n){
  //6 ARREGLO EXTRAJUDICIAL
  
   switch(tab_n){
    case "1": 
      $("#honorarios,#demanda,#seguimiento,#observacion,#contraparte,#extrajudicial").removeClass("active");
    $("#pestana-honorarios,#pestana-demanda,#pestana-seguimiento,#pestana-observacion,#pestana-contraparte,#pestana-extrajudicial").removeClass("active");
   $("#pestana-persona").addClass("active");
    $("#persona").addClass("active");
    break;
    case "2": 
      $("#honorarios,#persona,#seguimiento,#observacion,#contraparte,#extrajudicial").removeClass("active");
    $("#pestana-honorarios,#pestana-persona,#pestana-seguimiento,#pestana-observacion,#pestana-contraparte,#pestana-extrajudicial").removeClass("active");
    $("#pestana-demanda").addClass("active");
    $("#demanda").addClass("active");
    break;
    case "3": 
      $("#honorarios,#demanda,#persona,#observacion,#contraparte,#extrajudicial").removeClass("active");
    $("#pestana-honorarios,#pestana-demanda,#pestana-persona,#pestana-observacion,#pestana-contraparte,#pestana-extrajudicial").removeClass("active");
    $("#pestana-seguimiento").addClass("active");
    $("#seguimiento").addClass("active");
    break;
    case "4": 
      $("#honorarios,#demanda,#seguimiento,#persona,#contraparte,#extrajudicial").removeClass("active");
    $("#pestana-honorarios,#pestana-demanda,#pestana-seguimiento,#pestana-persona,#pestana-contraparte,#pestana-extrajudicial").removeClass("active");
    $("#pestana-observacion").addClass("active");
    $("#observacion").addClass("active");
    break;
     case "5": 
      $("#honorarios,#demanda,#seguimiento,#observacion,#persona,#extrajudicial").removeClass("active");
    $("#pestana-honorarios,#pestana-demanda,#pestana-seguimiento,#pestana-observacion,#pestana-persona,#pestana-extrajudicial").removeClass("active");
    $("#pestana-contraparte").addClass("active");
    $("#contraparte").addClass("active");
    break;
    case "6": 
      $("#honorarios,#demanda,#seguimiento,#observacion,#contraparte,#persona").removeClass("active");
    $("#pestana-honorarios,#pestana-demanda,#pestana-seguimiento,#pestana-observacion,#pestana-contraparte,#pestana-persona").removeClass("active");
    $("#pestana-extrajudicial").addClass("active");
    $("#extrajudicial").addClass("active");
    break;
    case "7": 
      $("#demanda,#seguimiento,#observacion,#contraparte,#persona,#extrajudicial").removeClass("active");
    $("#pestana-demanda,#pestana-seguimiento,#pestana-observacion,#pestana-contraparte,#pestana-persona,#pestana-extrajudicial").removeClass("active");
    $("#pestana-honorarios").addClass("active");
    $("#honorarios").addClass("active");
    break;
   } 
 }

</script>

  
@endsection



<script>
 
var formEnviado= false;




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

function ajaxCall( ev, divname, success_f){//Objeto event   DIV tag selector to display   success handler
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
           $( divname).html(  "" ); 
           alert("Problemas de conexión");
         }
       }
     );
}/*****end ajax call* */








//Limpiador
//Recibe una cadena numerica
//Elimina todos los puntos separadores
function numeroSinFormato( ele){ 
  if( ele =="") return 0;
  else return ele.replaceAll("[.]", "");
}


//Limpiador
//Recibe un campo numerico con formato de millares
//Elimina todos los puntos separadores
function quitarSeparador( obj){ 
let w=  obj.value.replaceAll(/\./g , "");
obj.value= w;
}
   

function phone_input(ev){
     if( ev.data == null) return;
     
    if( (ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57)  && ev.data.charCodeAt()!= 32   ){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + " "
      ev.target.value.substr( ev.target.selectionStart );
    }  }

  //Validacion para controlar entradas de teclado
  //Permite solo entrada numerica
   function solo_numero(ev){
     if( ev.data == null) return;
     
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart );
    }  }

//Recibe: Un campo de tipo numerico
//Efecto: Da formato de puntos al valor del campo
   function numero_con_puntuacion( obj ) {
    
    let val_Act= typeof obj == "object" ? obj.value : obj;  
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
    if( typeof obj == "object"){
      $(obj).val(  enpuntos);
      }else{
return enpuntos;
      }
   }


//Validacion
//Permite solo entrada numerica
//A la vez, da formato de millares al valor del campo que se esta controlando
  function formatear(ev){
    if( ev.data == undefined) return; 
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart );
    }
     //Formato de millares
    let val_Act= ev.target.value;  
  val_Act= val_Act.replaceAll( new RegExp(/[\.]*[,]*/), ""); 
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		$( ev.target).val(  enpuntos);
	} 



//Habilita y deshabilita campos de un formato
//proporcionando el ID de formulario, y un valor booleano como bandera para habilitar/deshabilitar
  function habilitarCampos( targetId, hab){
    let target= document.getElementById(targetId);
    let context= target.elements;
    Array.prototype.forEach.call( context, function(ar){
      if( ar.type.toString() != "hidden")
      ar.disabled=!hab; 
        }
        );
  }

 
 


 


 

    </script>