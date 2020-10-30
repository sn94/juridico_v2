@extends('0provider.app')

 
@section('content')

 
<div id="grilla-clientes">
@include("0provider.suscriptor.grilla_solicitudes" )
</div>

 
<div id="modalComponent" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content p-2 bg-dark text-light" >
     <div id="modalContenido">

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger"data-dismiss="modal">Ok</button> 
      </div>

    </div>
  </div>
</div>


<script>




async function actualizarGrilla(){
  $( "#grilla-clientes").html(  "<div  class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       
 let response_= await fetch(  "<?=url("p/solicitantes")?>", { headers: {"X-Requested-With": "XMLHttpRequest"} } );
let responseData= await response_.text();

$( "#grilla-clientes").html(  responseData);  
}

 



async function eliminarCliente( ev){

ev.preventDefault();
if( !confirm("Seguro que desea borrar los datos?")) return;

let src= ev.currentTarget.href;

let response_=  await fetch( src);
let responseJson= await response_.json();
if( "ok" in responseJson)
{
  alert(  responseJson.ok);
  actualizarGrilla();
  }
else 
alert(  responseJson.error);
}




async function aprobarCliente( ev){

ev.preventDefault();

let url__=  (ev.currentTarget.href); 
let response_=  await fetch( url__);
let responseJson= await response_.json();
  if( "ok" in responseJson)
  {
    $("#modalContenido").html(  responseJson.ok);
    $("#modalComponent").modal("show"); 
    }
  else 
  {
    
    $("#modalContenido").html(  responseJson.error);
    $("#modalComponent").modal("show");
  }
}


</script>
    
@endsection