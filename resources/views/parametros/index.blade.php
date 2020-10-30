@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">PARÁMETROS VARIOS</li>  
@endsection

@section('content')
    
@include("parametros.form" )
 
@endsection 

<script>

 


//inserta, modifica registros de parametros y origen de demanda
function ajaxCall( ev, divname){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault(); 
//vALIDAR CHECK
$("input[name=SHOW_COUNTERS]").val( $("#SHOW_COUNTERS").prop("checked") ?"S":"N"  );
$("input[name=DEPOSITO_CTA_JUDICI]").val( $("#DEPOSITO_CTA_JUDICI").prop("checked") ?"S":"N"  );
 $.ajax(
     {
       url:  ev.target.action,
       method: "post",
       data: $("#"+ev.target.id).serialize(),
       headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
       beforeSend: function(){
         $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: function(res){
        $(divname).html("");
           let r= JSON.parse(res);
           if("ok" in r)  alert( r.ok);
            else alert( r.error); 
       },
       error: function(){
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}/*****end ajax call* */

function number_field(ev){
  if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart );
    }
}

function decimal_field(ev){
  if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
    if(  ev.data.charCodeAt() == 46) return;
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart );
    }
}


/**Forma una cadena numerica con separador de miles */
function formatear(ev){
    console.log( ev.target.selectionStart, ev);
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


</script>