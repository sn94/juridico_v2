@extends('modulo_admin.app')

 
@section('content')

 
<div id="stickyLayer" style="position:fixed;text-align:left;left:0px;top:50%;margin-top:39px;width:140px;height:63px;z-index:5;">
        </div>
        <form  name="popupForm"   action="<?=url("p/suscriptor/aprobar/".$cliente->IDNRO)?>"  onsubmit="aprobarCliente(event)" >
        @csrf
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header"> 
        <h4 class="text-center">APROBACIÓN</h4>
        </div>
        <div class="modal-body"> 
        <label for="" id="nameLabel" style="display:block;width:100%;z-index:0;">Razón Social:</label>
        <input type="text" id="name" class="form-control form-control-sm" value="{{$cliente->RAZON_SOCIAL}}" spellcheck="false">
        <label for="" id="emailLabel" style="display:block;width:100%;z-index:2;">Email:</label>
        <input type="text" id="email" class="form-control form-control-sm" style="display:block;width: 100%;height:28px;z-index:3;"   value="{{$cliente->EMAIL}}" spellcheck="false">
        <label for="" id="TELLabel" style="display:block;width:100%;z-index:2;">Teléfono:</label>
        <input type="text" id="tel" class="form-control form-control-sm" style="display:block;width: 100%;height:28px;z-index:3;"  value="{{$cliente->TELEFONO}}" spellcheck="false">
        <label for="" id="CELLabel" style="display:block;width:100%;z-index:2;">Celular:</label>
        <input type="text" id="cel" class="form-control form-control-sm" style="display:block;width: 100%;height:28px;z-index:3;"   value="{{$cliente->CELULAR}}" spellcheck="false">
        <label for="" id="CELLabel" style="display:block;width:100%;z-index:2;">Nombre de Base de datos:</label>
        <input type="text" id="cel" class="form-control form-control-sm" style="display:block;width: 100%;height:28px;z-index:3;"   value="<?= "cli_".$cliente->IDNRO?>" spellcheck="false">
        

        <p>La aprobación de esta solicitud solo tendra efecto si ya ha creado la base de datos con el nombre indicado</p>


        <input class="btn btn-primary" type="submit" id="submitButton" name="" value="Guardar"  >
        </div>
        </div>
        </div>
        </form>


<script>




 

 async function aprobarCliente( event){

    ev.preventDefault();

    let url__=  (ev.currentTarget.action); 
    let response_=  await fetch( url__);
    let responseJson= await response_.json();
    if( "ok" in responseJson)
    {
      alert(  "Aprobado"); 
      }
    else 
    alert(  responseJson.error);
}


 



</script>
    
@endsection