 
<p style="text-align: center;font-weight: 600; background-color: #f9a84f; color: white;margin-bottom: 0px;">
CUENTA DE GASTO
</p>

<form style="background-color: #fdc673; padding:0px;margin-bottom:0px;  "   class="p-3"  onsubmit="ajaxCall(event,'#MENSAJE')" id="auxiform" action="<?=$RUTA?>" >
<p class="p-2" id="MENSAJE" style="color:  #041402; font-weight: bold;"></p>
{{csrf_field()}}
  
<input type="hidden" id="OPERACION" value="{{ !isset($OPERACION)?'A': $OPERACION}}">

@if( isset($OPERACION) && $OPERACION== "M")
<input type="hidden" name="IDNRO" value="{{isset($DATO)? $DATO->IDNRO: '' }}">
@endif

<div class="row"> 
<div  class="col-12 mb-1">
  <label for="">CÓDIGO:</label>
      <input  maxlength="10"   value="{{isset($DATO)?$DATO->CODIGO:''}}"    name="CODIGO"  type="text"  class="form-control form-control-sm">
    </div>
  <div  class="col-12 mb-1">
    <label for="">DESCRIPCIÓN</label>
      <input maxlength="50"   value="{{isset($DATO)?$DATO->DESCRIPCION:''}}"    name="DESCRIPCION"  type="text"  class="form-control form-control-sm">
    </div>
  <div  class="col-12">
        <button style="background-color: #fa640a;" class="btn btn-info btn-sm"  type="submit" class="btn btn-sm btn-info">GUARDAR</button>
  </div>
</div>
 
</form>

<script>

  window.onload= function(){

    $("input[name=DESCRIPCION]").focus();
  }
</script>