 
<p class="bg-dark text-center text-light" style="font-weight: 600; margin-bottom: 0px;">
PLANES
</p>

<form class="bg-dark text-light p-2" style=" padding:0px;margin-bottom:0px;  "   class="p-3"  onsubmit="ajaxCall(event,'#MENSAJE')" id="auxiform" action="<?=$RUTA?>" >
<p class="p-2" id="MENSAJE" style="color:  #041402; font-weight: bold;"></p>
{{csrf_field()}}
  
<input type="hidden" id="OPERACION" value="{{ !isset($OPERACION)?'A': $OPERACION}}">

@if( isset($OPERACION) && $OPERACION== "M")
<input type="hidden" name="IDNRO" value="{{isset($DATO)? $DATO->IDNRO: '' }}">
@endif

<div class="row"> 
<div  class="col-12 mb-1">
  
  <div  class="col-12 mb-1">
    <label for="">Descripción:</label>
      <input maxlength="100"   value="{{isset($DATO)?$DATO->DESCR:''}}"    name="DESCR"  type="text"  class="form-control form-control-sm">
    </div>

    <div  class="col-12 mb-1">
    <label for="">N° Máximo de usuarios:</label>
      <input maxlength="10"  oninput="solo_numero(event)" value="{{isset($DATO)?$DATO->MAX_USERS:''}}"    name="MAX_USERS"  type="text"  class="form-control form-control-sm">
    </div>


    <div  class="col-12 mb-1">
    <label for="">Precio:</label>
      <input maxlength="10"  oninput="solo_numero_mas_formato(event)" value="{{isset($DATO)?$DATO->PRECIO:''}}"    name="PRECIO"  type="text"  class="form-control form-control-sm">
    </div>

    <div  class="col-12 mb-1">
    <label for="">Duración:</label>
      <input maxlength="10"  oninput="solo_numero(event)" value="{{isset($DATO)?$DATO->DURACION:''}}"    name="DURACION"  type="text"  class="form-control form-control-sm">
    </div>


  <div  class="col-12">
        <button   class="btn btn-primary btn-sm"  type="submit" class="btn btn-sm btn-info">GUARDAR</button>
  </div>
</div>
 
</form>

<script>

function solo_numero_mas_formato(ev){
   
   if(  ev.data == undefined  ||  ev.data == null)  return;
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart ); 
    } 
    let val_Act= ev.target.value;  
  val_Act= val_Act.replaceAll( new RegExp(/[\.]*[,]*/), ""); 
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		$( ev.target).val(  enpuntos);
	} 


function solo_numero(ev){
   
   if(  ev.data == undefined  ||  ev.data == null)  return;
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart ); 
    } 
    
	} 


  window.onload= function(){

    $("input[name=DESCRIPCION]").focus();
  }
</script>