@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">AUXILIARES</li>  
@endsection

@section('content')
 


<div class="form-group">
  <label for="actuaria">TIPO:</label>
  <select class="form-control form-control-sm"   name="TABLA" onchange="cambiar_tabla(event)">
  <?php foreach(  $OPCS as $CLAVE=> $VALOR): ?>
    <option value="{{$CLAVE}}" <?= $OPC_A==$CLAVE ?'selected': ''?> >{{$VALOR}}</option>
  <?php endforeach; ?>
  </select>
</div>

<input type="hidden" id="ruta_listado" value="{{$ruta_listado}}">



<div id="statusform">

</div>
<div id="viewform">
@include("auxiliares.form" )
</div>
<div id="grilla">
@include("auxiliares.grilla" )
</div>


 

 
@endsection 

<script>


/** actualiza contexto */
function cambiar_tabla(ev){
window.location= "<?=url("auxiliar")?>/"+$(ev.currentTarget).val();
}
 


//inserta, modifica registros de parametros y origen de demanda
function ajaxCall( ev, divname){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault(); 
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
            Array.prototype.forEach.call( document.getElementById("auxiform").elements ,  function(ar){ ar.value= ""; } );
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
           if("ok" in r) {  }
            else alert( r.error) ;
            act_grilla();
       },
       error: function(){
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}/*****end ajax call* */





</script>