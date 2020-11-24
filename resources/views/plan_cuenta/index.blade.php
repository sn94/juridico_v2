@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">PLAN DE CUENTAS</li>  
@endsection

@section('content')

 

<input type="hidden" id="ruta_listado" value="{{$ruta_listado}}">



<!--BOTON INFORMES --> 
<a  href="<?= url("plan-cuentas-rep")?>" data-toggle="modal" data-target="#show_opc_rep" onclick="mostrar_informe(event)" style="color:black;" > <i class="mr-2 ml-2 fa fa-print fa-lg" aria-hidden="true"></i></a>
<a class="btn btn-primary btn-sm" href="{{$url_agregar}}" onclick="mostrarFormulario(event)" data-toggle="modal" data-target="#showform">NUEVO</a>

 
<div id="statusform" >

</div>
 
<div id="grilla">
@include("plan_cuenta.grilla" )
</div>


<!-- modal -->
<div id="showform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" id="viewform">
      
    </div>
  </div>
</div>
<!-- modal -->
 

 
 <!-- REPORTES --> 
 @include("layouts.report", ['TITULO'=>'GASTOS - PLAN DE CUENTAS'])



@endsection 

<script>

 function mostrarFormulario(ev){
   ev.preventDefault();
   $.ajax({
     url: ev.currentTarget.href,
     success: function(res){  $("#viewform").html(res); },
     beforeSend: function(){
         $( "#viewform").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       }
   });
  
 }


//inserta, modifica registros de parametros y origen de demanda
function ajaxCall( ev, divname){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault(); 
//Controlar Tambien redundacia de CODIGO DE GASTO
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
           if( "ok" in r){
             $("#MENSAJE").text( r.ok);
           }else    alert( r.error);
           //borrar campos
          Array.prototype.forEach.call( document.getElementById("auxiform").elements ,  function(ar){ ar.value= ""; } );
          if( "ok" in r)
          act_grilla(); 
       },
       error: function(){
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}/*****end ajax call* */




/** actualiza grilla de origenes de demanda */
function act_grilla(){
  $.ajax(
     {
       url: $("#ruta_listado").val(),
       method: "get", 
       beforeSend: function(){ $( "#grilla").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: function(res){    $( "#grilla").html(res)  },
       error: function(){  $("#grilla").html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}


//inserta, modifica registros de parametros y origen de demanda
function editar( ev){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault();
let divname="#viewform";  
$.ajax(
     {
       url:  ev.currentTarget.href,
       method: "get",
      beforeSend: function(){     $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: function(res){    $( divname).html( res);   },
       error: function(){ $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" );       }
     }
   );
}/*****end ajax call* */


//BORRA origen de demanda
function borrar( ev){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault();
let divname="#viewform2"; 
if(  ! confirm("SEGURO QUE QUIERE BORRARLO?") ) return;
$.ajax(
     {
       url:  ev.currentTarget.href,
       method: "get", beforeSend: function(){
         $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: function(res){
        $( divname).html( "");
           let r= JSON.parse(res);
           if( !("ok" in r))  ( r.error) ;
            act_grilla();
       },
       error: function(){
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}/*****end ajax call* */





</script>