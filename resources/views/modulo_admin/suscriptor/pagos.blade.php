@extends('modulo_admin.app')

 
@section('content')

 

 <h4>Histórico de pagos de {{$RAZONSOCIAL}}</h4>

@if( isset($IDCLIENTE ) )
 <a   class="btn btn-primary" href="<?=url("p/pago/".$IDCLIENTE)?>" onclick="mostrarForm(event)">Nuevo Pago</a>
 @else 
 <a class="btn btn-primary" href="#">Nuevo Pago</a>
 @endif

<div id="formstatus">

</div>
<div id="grilla-pagos">
    
    @include("modulo_admin.suscriptor.pagos_grilla")
</div>

 <!-- modal -->
<div id="showform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content text-light bg-dark" id="viewform"  >
      
    </div>
  </div>
</div>
<!-- modal -->
 

<script>





function mostrarForm(ev){
  ev.preventDefault();
  $.ajax({
     url: ev.currentTarget.href,
     success: function(res){    $("#showform").modal("show");  $("#viewform").html(res);     },
     beforeSend: function(){
         $( "#viewform").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       }
   });
}





async function actualizarGrilla(){
  $("#showform").modal("hide");
  $( "#grilla-pagos").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       
 let response_= await fetch(  "<?=url("p/pagos/".$IDCLIENTE)?>", { headers: {"X-Requested-With": "XMLHttpRequest"} } );
let responseData= await response_.text();

$( "#grilla-pagos").html(  responseData);  
}

 

 function prepararBorrar( ev){
   ev.preventDefault();
$("#enlace-eliminar").attr("href",  ev.currentTarget.href );
$("#modal-eliminar").modal("show");
}

async function eliminarUsuario( ev){

ev.preventDefault();
 
let src= ev.currentTarget.href;

let response_=  await fetch( src);
let responseJson= await response_.json();
if( "ok" in responseJson)
{
   $("#modal-eliminar").modal("hide");
  actualizarGrilla();
  }
else 
{$("#modal-eliminar").modal("hide");
alert(  responseJson.error);}
}



</script>
    
@endsection