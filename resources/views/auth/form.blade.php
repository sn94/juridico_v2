<?php  
$ruta= isset($OPERACION)?  ($OPERACION=="A" ? url("new-user"): url("edit-user")   ) : url("new-user");
?>

 

<form  id="userform" method="POST" action="<?= $ruta?>"  onsubmit="ajaxCall(event)">
                        @csrf


<?php if( isset($OPERACION) && $OPERACION== "M"): ?>
<input type="hidden" name="IDNRO" value="{{isset($DATO)? $DATO->IDNRO: '' }}">
<?php endif; ?>

           <div class="row align-items-center "> 
           <div class="col-12 col-sm-4 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label >NICK:</label>
                            <input   maxlength="20"  value="{{isset($DATO->nick)?$DATO->nick: ''}}" name="nick"  type="text"  class="form-control form-control-sm">
                        </div>
                        </div>
                        <div class="col-12 col-sm-4 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label >PASSWORD:</label>
                            <input   <?=($OPERACION=='A') ? '' : 'disabled'?> maxlength="20"    name="pass"  type="password"  class="form-control form-control-sm">
                        </div> 
                        </div>

                        <?php  if( $OPERACION =="M"):  ?>
                        <div class="col-12 col-sm-1 col-md-1 col-lg-1 pl-0">
                          <span class="align-middle">
                          <div class="form-check">
                          <input  onclick="editar_pass()" class="form-check-input"   type="checkbox"  > 
                          <label class="form-check-label" for="defaultCheck1">
                            Editar
                          </label>
                        </div>
                          </span>
                        
                        </div>
                    <?php endif; ?>

                    <div class="col-12 col-sm-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label >E-MAIL:</label>
                            <input  maxlength="60"  value="{{isset($DATO->email)?$DATO->email: ''}}" name="email"  type="text"  class="form-control form-control-sm">
                        </div> 
                        </div>

                        <div class="col-12 col-sm-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label >CATEGORÍA:</label>
                            <select class="form-control form-control-sm" name="tipo" >
                          <option {{isset($DATO->tipo)?($DATO->tipo=='S' ? 'checked' : ''): ''}} value="S">SUPERVISOR</option>
                          <option {{isset($DATO->tipo)?($DATO->tipo=='O' ? 'checked' : ''): ''}} value="O">OPERADOR</option>
                          <option {{isset($DATO->tipo)?($DATO->tipo=='U' ? 'checked' : ''): ''}} value="U">USUARIO</option>

                            </select> 
                        </div> 
                        </div>

                        <div class="col-12 col-sm-5 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label > </label>
                            <button type="submit" class="btn btn-primary btn-sm"> REGISTRAR   </button>
                        </div> 
                      
                        </div>
                   
           </div>
                           
</form>
      
<script>

    
//inserta, modifica registros de parametros y origen de demanda
function ajaxCall( ev){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault(); 
let divname= "#viewform";
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
           if("ok" in r)  alert( r.ok);
            else alert( r.error);
            document.getElementById("userform").reset(); act_grilla();
       },
       error: function(){
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}/*****end ajax call* */




function editar_pass(){
  $("input[name=pass]").attr("disabled", false);
  $("input[name=pass]").focus();
}

</script>