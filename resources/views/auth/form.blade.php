<?php  
$ruta= isset($OPERACION)?  ($OPERACION=="A" ? url("new-user"): url("edit-user")   ) : url("new-user");
?>

 

<form   id="userform" method="POST" action="<?= $ruta?>"  onsubmit="ajaxCall(event)">

@csrf


<?php if( isset($OPERACION) && $OPERACION== "M"): ?>
<input type="hidden" name="IDNRO" value="{{isset($DATO)? $DATO->IDNRO: '' }}">
<?php endif; ?>

           <div class="row align-items-center "> 
           <div class="col-12 col-sm-4 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label >NICK:</label>
                            
                            <input prefijo="{{session('system').'_'}}" oninput="keepPrefix(event)"   maxlength="20"  value="<?=isset($DATO->nick)?$DATO->nick: (session("system")."_") ?>" name="nick"  type="text"  class="form-control form-control-sm">
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

                        @if( !isset($DATO)  ||   ($DATO->tipo  != "SA"  && $DATO->tipo  != "S") )
                        <div class="col-12 col-sm-3 col-md-4 col-lg-3">
                        <div class="form-group">
                            <label >CATEGORÍA:</label>
                            <select style="border-radius: 20px;" class="form-control form-control-sm" name="tipo" >
                <!--          <option isset($DATO->tipo)?($DATO->tipo=='S' ? 'checked' : ''): ''   value="S">SUPERVISOR</option> -->
                          <option {{isset($DATO->tipo)?($DATO->tipo=='O' ? 'checked' : ''): ''}} value="O">OPERADOR</option>
                          <option {{isset($DATO->tipo)?($DATO->tipo=='U' ? 'checked' : ''): ''}} value="U">USUARIO</option>

                            </select> 
                        </div> 
                        </div>
                        @endif

                        @if( !isset($DATO)  || ($DATO->tipo  != "SA"  && $DATO->tipo  != "S"))
                        <div class="col-12 col-sm-5 col-md-4 col-lg-3">
                        <div class="form-group">
                          <label for="">Asignar asistente al abogado :</label>
                          <select name="ABOGADO" class="form-control form-control-sm" style="border-radius: 20px;"  id="ABOGADO-LIST">
                          @foreach( $abogados as $abo)
                          <option value="{{$abo->IDNRO}}">  {{$abo->NOMBRES}}</option>
                          @endforeach
                          </select>
                        </div>
                        </div>
                        @elseif(  session("tipo") == "S")
                        <input type="hidden" name="ABOGADO" value="{{session('abogado')}}">
                        @endif
                       


                        <div class="col-12 col-sm-5 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label > </label>
                            <button type="submit" class="btn btn-primary btn-sm"> REGISTRAR   </button>
                        </div> 
                      
                        </div>
                   
           </div>

        
                           
</form>
      
<script>

 

  
  function keepPrefix(ev){
    let posicionRef=  ev.target.value.indexOf("_");
    let prefij= $(ev.target).attr("prefijo");
    let l_prefij=  prefij.length;

    let parts= ev.target.value.split( prefij );
    let resto= parts[1]== undefined ? "" :  parts[1];
    ev.target.value= prefij+ resto;
    console.log(  ev,   $(ev.target).val() ); 

     
    
  }




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