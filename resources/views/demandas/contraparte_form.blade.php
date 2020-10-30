 
 
  <form  id="formContra"   method="post" action="<?= url("contraparte")?>" onsubmit="enviarContraparte(event)">

  
   <?php if( $OPERACION != "V"): ?>
   
    <div class="row">
      <div class=" col-12 col-md-1">
      <button type="submit" class="btn btn-success btn-sm" >Guardar</button>
      </div>
      <div class="col-12 col-md-2">
        <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="1000">
        <div role="alert" aria-live="assertive" aria-atomic="true" id="contra-msg">GUARDADO</div>
        </div>
      </div>
    </div>

<?php endif; ?>



  {{csrf_field()}} 

<div id="contraparte-panel">
</div>

<input id="IDNRO3"  type="hidden" name="IDNRO" value="{{isset($id_demanda)?$id_demanda:''}}">

<!---HERE -->
<div class="row">
  
<div class="col-12 col-sm-12 col-md-12 col-lg-4"> 
<div class="row">
<div class="col-12  col-sm-12 col-md-12"> 
    <div class="form-group">
        <label for="ctactecatas">Abogado:</label>
        <input maxlength="40" value="{{! isset($ficha4) ? '' : $ficha4->ABOGADO}}" name="ABOGADO" type="text"  class="form-control form-control-sm   ">
    </div>
    
  </div>
  <div class="col-12 col-sm-12 col-md-12"> 
    <div class="form-group">
        <label for="ctactecatas">Dirección Legal:</label>
        <input maxlength="80" value="{{! isset($ficha4) ? '' : $ficha4->DIRLEGAL}}" name="DIRLEGAL" type="text"  class="form-control form-control-sm   ">
    </div>
  </div>
</div>
</div>
 


  <div class="col-12  col-sm-12 col-md-4 col-lg-4"> 
    <div class="form-group">
        <label for="">Observación:</label>
        @php
    echo Form::textarea('OBS', (! isset($ficha4) ? '' : $ficha4->OBS), [   'class'=> 'form-control form-control-sm','rows'=>4]);
    @endphp 
      </div>
  </div>




</div> 


  </form>
  <script> 
  if( document.getElementById("operacion").value=="A" || document.getElementById("operacion").value=="A+")
  habilitarCampos('formContra',false);

  if( document.getElementById("operacion").value=="M"  )
  habilitarCampos('formContra',true);

  if( document.getElementById("operacion").value=="V"  )
  habilitarCampos('formContra',false);




  function enviarContraparte(ev){
    
 ev.preventDefault();  
 
 $.ajax(
 {
   url:  ev.target.action,
   method: "post",
   data: $("#"+ev.target.id).serialize(),
   dataType: "json",
   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
   beforeSend: function(){
     $("#contraparte-panel").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
   },
   success: function( res ){
      if( "error" in res){
         $("#contraparte-panel").html(  "" ); 
         alert(res.error);
       }else{ 
         //Mostrar mensaje 
         $("#contraparte-panel").html( "" ); //mensaje 
         $("#contra-msg").text( "GUARDADO!");
          $(".toast").toast("show"); 
       }
      
   },
   error: function(){
     $("#contraparte-panel").html( "" ); 
     alert("Problemas de conexión");
   }
 }
);

  }
  </script>