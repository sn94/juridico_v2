@extends('modulo_admin.layouts.app')

 
@section('content')


@if(  $numero_solicitantes  > 0)
<a class="btn btn-primary btn-sm mt-1" href="<?=url("p/solicitantes")?>">
Aprobar solicitudes
<span class="badge badge-light">{{$numero_solicitantes}}</span>
</a>
@endif

<div id="grilla-clientes">
@include("modulo_admin.suscriptor.grilla" )
</div>




<input type="hidden"   id="NUMERO_SOLICITANTES"  value="{{$numero_solicitantes}}">
<div id="modal-aviso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content p-2  bg-warning "    >
     
   <p style="font-weight: 600; font-family: Verdana, Geneva, Tahoma, sans-serif; color: #333;"> 
   Falta revisar {{$numero_solicitantes}} solicitud(es)</p>

      <div class="modal-footer"> 
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>

    </div>
  </div>
</div>
 


 
<div id="modal-eliminar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content p-2 bg-dark text-light">
     <span style="font-weight: 600;"> La eliminación del registro del Cliente</span> implica
      el borrado permanente de los datos asociados al sistema del mismo.
      Este proceso será comunicado por e-mail al Cliente.
      Desea continuar?

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="eliminarCliente()">Si</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>


<script>




async function actualizarGrilla(){
  $( "#grilla-clientes").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       
 let response_= await fetch(  "<?=url("p/clientes")?>", { headers: {"X-Requested-With": "XMLHttpRequest"} } );
let responseData= await response_.text();

$( "#grilla-clientes").html(  responseData);  
}

 async function actualizar_estado( ev, idcli){

    ev.preventDefault();
    let mensaje=  (ev.currentTarget.checked)? "¿Habilitar?" : "¿Deshabilitar?";
    if( !confirm(  mensaje) ) {   ev.currentTarget.checked=  !ev.currentTarget.checked;  return ; };
    let src= ev.currentTarget.href;
    if( ev.currentTarget.checked)
    //habilitar
    src= "<?=url("p/suscriptor/alta")?>/"+idcli;
    else src= "<?=url("p/suscriptor/baja")?>/"+idcli;//deshabilitar

    let response_=  await fetch( src);
    let responseJson= await response_.json();
    if( "ok" in responseJson)
    {
      alert(  responseJson.ok); 
      }
    else 
    alert(  responseJson.error);
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




async function regenerarCredenciales( ev){

ev.preventDefault();
 

let src= ev.currentTarget.href;

let response_=  await fetch( src);
let responseJson= await response_.json();
if( "ok" in responseJson)
{
  alert(  responseJson.ok); 
  }
else 
alert(  responseJson.error);
}





window.onload= function(){

  if(  parseInt($("#NUMERO_SOLICITANTES").val())    > 0)
  $("#modal-aviso").modal("show");
}

</script>
    
@endsection