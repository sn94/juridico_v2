@extends('0provider.app')

 
@section('content')


<a  onclick="mostrarForm(event)" class="btn btn-primary btn-sm mt-1" href="<?=url("p/nuevo-provider")?>">Nuevo Admin</a>


<div id="formstatus">

</div>
<div id="grilla-usuarios">
@include("0provider.usuario.grilla" )
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
     <span style="font-weight: 600;"> Seguro que quiere eliminar este administrador?</span> 
     

      <div class="modal-footer">
        <a  id="enlace-eliminar" href="#" class="btn btn-danger" onclick="eliminarUsuario(event)">Si</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>


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
  $( "#grilla-usuarios").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       
 let response_= await fetch(  "<?=url("p/usuarios")?>", { headers: {"X-Requested-With": "XMLHttpRequest"} } );
let responseData= await response_.text();

$( "#grilla-usuarios").html(  responseData);  
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