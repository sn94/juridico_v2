 
 
  <form class="verde3"  id="formObser"   method="post" action="<?= url("eobser")?>" onsubmit="enviarObservacion(event)">

  
   <?php if( $OPERACION != "V"): ?>
   
    <div class="row">
      <div class=" col-12 col-md-1">
      <button type="submit" class="btn btn-primary btn-sm" >Guardar</button>
      </div>
      <div class="col-12 col-md-2">
        <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="1000">
        <div role="alert" aria-live="assertive" aria-atomic="true" id="obse-msg">GUARDADO</div>
        </div>
      </div>
    </div>

<?php endif; ?>



  {{csrf_field()}} 

<div id="observacion-panel">
</div>

<input id="IDNRO2"  type="hidden" name="IDNRO" value="{{isset($id_demanda)?$id_demanda:''}}">
<input id="CI3" type="hidden" name="CI" value="{{isset($ci)?$ci:''}}">

      

<div class="row p-2">
<div class="form-group col-12 col-md-6">
          <label for="ctactecatas">Preventivo:</label>
          <textarea  name="OBS_PREVEN"   cols="30" rows="3" class="form-control form-control-sm   ">
            {{! isset($ficha3) ? '' : $ficha3->OBS_PREVEN }}</textarea> 
          </div>


          <div class="form-group col-12 col-md-6">
          <label for="ctactecatas">Ejecutivo:</label>
          <textarea   name="OBS_EJECUT"   cols="30" rows="3" class="form-control form-control-sm   ">
            {{! isset($ficha3) ? '' : $ficha3->OBS_EJECUT}}</textarea> 
          </div>

</div>

  </form>
  <script> 
    //A   Nueva demanda Nuevo Demandado
  //A+ Nueva demanda para demandado ya existente
  if( document.getElementById("operacion").value=="A" || document.getElementById("operacion").value=="A+")
  habilitarCampos('formObser',false);
//Actualizacion de demandado y demanda
  if( document.getElementById("operacion").value=="M"  )
  habilitarCampos('formObser',true);
//Solo Lectura
  if( document.getElementById("operacion").value=="V"  )
  habilitarCampos('formObser',false);

window.onload= function(e){ 
  document.querySelector("textarea[name=OBS_EJECUT]" ).value=  document.querySelector("textarea[name=OBS_EJECUT]" ).value.trim();
  document.querySelector("textarea[name=OBS_PREVEN]" ).value=  document.querySelector("textarea[name=OBS_PREVEN]" ).value.trim();
};

  
function enviarObservacion( ev){ //ENVIO DE FORM OBSERVACION
 
 ev.preventDefault();  
 
       $.ajax(
       {
         url:  ev.target.action,
         method: "post",
         data: $("#"+ev.target.id).serialize(),
         dataType: "json",
         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
         beforeSend: function(){
           $("#observacion-panel").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function( res ){
            if( "error" in res){
               $("#observacion-panel").html(  "" ); 
               alert(res.error);
             }else{ 
               //Mostrar mensaje 
               $("#observacion-panel").html( "" ); //mensaje 
               $("#obse-msg").text( "GUARDADO!");
                $(".toast").toast("show"); 
             }
            
         },
         error: function(){
           $("#observacion-panel").html( "" ); 
           alert("Problemas de conexión");
         }
       }
     );
 
}/** */
  </script>