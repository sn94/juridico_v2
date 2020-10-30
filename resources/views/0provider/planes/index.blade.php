@extends('0provider.app')


 

@section('content')

 

<input type="hidden" id="ruta_listado" value="{{$ruta_listado}}">



<!--BOTON INFORMES --> 
 <a   class="btn btn-primary btn-sm" href="{{$url_agregar}}" onclick="mostrarFormulario(event)" data-toggle="modal" data-target="#showform">NUEVO</a>

 
<div id="statusform" >

</div>
 
<div id="grilla">
@include("0provider.planes.grilla" )
</div>


<!-- modal -->
<div id="showform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" id="viewform">
      
    </div>
  </div>
</div>
<!-- modal -->
 



<div id="modal-eliminar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content p-2 bg-dark text-light">
     <span style="font-weight: 600;"> Seguro que desea borrar este Plan?</span>
     

      <div class="modal-footer">
        <a  id="enlace-eliminar"  class="btn btn-danger"  href="#" onclick="borrar(event)">Si</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>




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
            { $("#MENSAJE").text( r.ok);
              $("#showform").modal("hide"); 
              }
           }else    alert( r.error);
           //borrar campos
          Array.prototype.forEach.call( document.getElementById("auxiform").elements ,  function(ar){ ar.value= ""; } );
          if( "ok" in r)
          act_grilla(); 
       },
       error: function(){
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         $("#showform").modal("hide"); 
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
       success: function(res){    $( divname).html( res);  },
       error: function(){ $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" );       }
     }
   );
}/*****end ajax call* */





function prepararBorrar( ev){
ev.preventDefault();

  $("#enlace-eliminar").attr("href",  ev.currentTarget.href);
  $("#modal-eliminar").modal("show");
}



//BORRA origen de demanda
function borrar( ev){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault();
let divname="#viewform2"; 
 
$.ajax(
     {
       url:  ev.currentTarget.href,
       method: "get", beforeSend: function(){
         $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: function(res){
        $("#modal-eliminar").modal("hide");
        $( divname).html( "");
           let r= JSON.parse(res);
           if( !("ok" in r))  ( r.error) ;
            act_grilla();
       },
       error: function(){
        $("#modal-eliminar").modal("hide");
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}/*****end ajax call* */





</script>