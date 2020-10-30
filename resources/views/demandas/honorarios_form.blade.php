 
 
<form  id="formHonorarios"   method="post" action="<?= url("honorarios")?>" onsubmit="enviarHonorarios(event)">

  
<?php if( $OPERACION != "V"): ?>

 <div class="row">
   <div class=" col-12 col-md-1">
   <button type="submit" class="btn btn-success btn-sm" >Guardar</button>
   </div>
   <div class="col-12 col-md-2">
     <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="1000">
     <div role="alert" aria-live="assertive" aria-atomic="true" id="honor-msg">GUARDADO</div>
     </div>
   </div>
 </div>

<?php endif; ?>



{{csrf_field()}} 

<div id="honorarios-panel">
</div>

<input id="IDNRO3"  type="hidden" name="IDNRO" value="{{isset($id_demanda)?$id_demanda:''}}">

<!---HERE --> 

<div class="row">

<div class="col-12  col-sm-12 col-md-4"> 
<div class="form-group">
   <label for="ctactecatas">Adj. Honorarios:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->ADJ_HONORARIOS }}" name="ADJ_HONORARIOS"   type="date"     class="form-control form-control-sm   ">
</div> 

<div class="form-group">
   <label for="ctactecatas">A.I N°:</label>
   <input maxlength="20"  value="{{! isset($ficha6) ? '' : $ficha6->AI_NRO }}" name="AI_NRO"   type="text"     class="form-control form-control-sm   ">
</div> 



<div class="form-group">
   <label for="ctactecatas">Fecha:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->FECHA }}" name="FECHA"   type="date"     class="form-control form-control-sm   ">
</div> 

<div class="form-group">
   <label for="ctactecatas">Gs:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->GS }}" name="GS"   type="text"     class="form-control form-control-sm number-format   ">
</div> 

<div class="form-group">
   <label for="ctactecatas">Notificación 1:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->NOTIFI_1 }}" name="NOTIFI_1"   type="date"     class="form-control form-control-sm   ">
</div> 
</div> 



<div class="col-12  col-sm-12 col-md-4"> 

<div class="form-group">
   <label for="ctactecatas">Adj. Citación:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->ADJ_CITA }}" name="ADJ_CITA"   type="date"     class="form-control form-control-sm   ">
</div> 

<div class="form-group">
   <label for="ctactecatas">Providencia:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->PROVIDENCIA }}" name="PROVIDENCIA"   type="date"     class="form-control form-control-sm   ">
</div> 

<div class="form-group">
   <label for="ctactecatas">Notificación 2:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->NOTIFI_2 }}" name="NOTIFI_2"   type="date"     class="form-control form-control-sm   ">
</div> 

<div class="form-group">
   <label for="ctactecatas">Adj. S.D:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->ADJ_SD }}" name="ADJ_SD"   type="date"     class="form-control form-control-sm   ">
</div> 

<div class="form-group">
   <label for="ctactecatas">SD N°:</label>
   <input maxlength="20"  value="{{! isset($ficha6) ? '' : $ficha6->SD_NRO }}" name="SD_NRO"   type="text"     class="form-control form-control-sm   ">
</div>
</div>


<div class="col-12  col-sm-12 col-md-4"> 


<div class="form-group">
   <label for="ctactecatas">FECHA:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->FECHA_SD }}" name="FECHA_SD"   type="date"     class="form-control form-control-sm   ">
</div> 

<div class="form-group">
   <label for="ctactecatas">Notificación 3:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->NOTIFI_3 }}" name="NOTIFI_3"   type="date"     class="form-control form-control-sm   ">
</div> 

   <label for="ctactecatas" style="text-decoration: underline;">EMBARGO HONORARIOS:</label>

   <div class="form-group">
    <label for="ctactecatas">Institución:</label>
    <select name="INSTI" class="form-control form-control-sm">
                 <?php 

                  $instituc=  !isset($ficha6)? '' : $ficha6->INSTI;
                 foreach($instituciones as $it): 
                      if( $instituc == $it->DESCR || $instituc == $it->IDNRO)//Ojo
                        echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                      else{
                           echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                      }
                      
                 endforeach;  ?>
          </select>   
</div> 


   <div class="form-group">
   <label for="ctactecatas">FECHA:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->FECHA_EMB }}" name="FECHA_EMB"   type="date"     class="form-control form-control-sm   ">
   </div> 

   <div class="form-group">
   <label for="ctactecatas">GS:</label>
   <input   value="{{! isset($ficha6) ? '' : $ficha6->GS2 }}" name="GS2"   type="text"     class="form-control form-control-sm  number-format ">
   </div> 


</div>


</div>


</form>
<script> 
if( document.getElementById("operacion").value=="A" || document.getElementById("operacion").value=="A+")
habilitarCampos('formHonorarios',false);

if( document.getElementById("operacion").value=="M"  )
habilitarCampos('formHonorarios',true);

if( document.getElementById("operacion").value=="V"  )
habilitarCampos('formHonorarios',false);





function limpiar_campos_hono(){ 
$("#formHonorarios .number-format").each( function( indice, obj){    quitarSeparador( obj); } );
}
function rec_formato_numerico_hono(){ 
$("#formHonorarios .number-format").each( function( indice, obj){    numero_con_puntuacion( obj); } );
}


function enviarHonorarios(ev){
 
ev.preventDefault();  
limpiar_campos_hono();
$.ajax(
{
url:  ev.target.action,
method: "post",
data: $("#"+ev.target.id).serialize(),
dataType: "json",
headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
beforeSend: function(){
  $("#honorarios-panel").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
},
success: function( res ){
   if( "error" in res){
      $("#honorarios-panel").html(  "" ); 
      alert(res.error);
    }else{ 
      //Mostrar mensaje 
      $("#honorarios-panel").html( "" ); //mensaje 
      $("#honor-msg").text( "GUARDADO!");
       $(".toast").toast("show"); 
    }
   rec_formato_numerico_hono();
},
error: function(){
 rec_formato_numerico_hono();
  $("#honorarios-panel").html( "" ); 
  alert("Problemas de conexión");
}
}
);

}
</script>