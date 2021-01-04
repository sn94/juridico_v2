@extends('layouts.app')
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">Módulo de Abogados</li>  
@endsection
@section('content')
  
 
 





<div id="status-result">

</div>



@if( isset($sin_abogados) )

<p  style="font-family: Verdana, Geneva, Tahoma, sans-serif;">Sin registros de abogados. Debe crear al menos un registro para utilizar las funciones del sistema</p>

@endif


<a onclick="mostrarFormulario(event)" class="btn btn-primary" href="<?= url("abogados/create")?>">Registrar</a>


<div id="list-abogado">
@include("abogado.grilla" )
</div>


<div id="modal-form" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content p-2 bg-dark text-light" >

    <div class="modal-header">
        <h5 class="modal-title">Datos personales</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div id="viewform">

      </div>

      <div class="modal-footer">
       
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
     success: function(res){  $("#viewform").html(res);  $("#modal-form").modal("show"); },
     beforeSend: function(){
         $( "#viewform").html(  "<div style='z-index:10000; position: absolute; left: 45%;'  class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       }
   });
  
 }




function act_grilla(){
  $.ajax(
     {
       url: "<?=url("abogados")?>",
       method: "get", 
       beforeSend: function(){ $( "#list-abogado").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: function(res){    $(  "#list-abogado").html(res)  },
       error: function(){  $( "#list-abogado" ).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}




</script>