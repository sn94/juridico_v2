<?php  
$rutaOdema= isset($OPERACION)?  ($OPERACION=="A" ? url("nuevoaux"): url("editaux")   ) : url("nuevoaux");
?>

 

<form  onsubmit="ajaxCall(event,'#statusform')" id="auxiform" action="<?=$rutaOdema?>" >
  
{{csrf_field()}}
  
<input type="hidden" id="OPERACION" value="{{ !isset($OPERACION)?'A': $OPERACION}}">
<input type="hidden" name="TABLA" value="{{  $TABLA}}">


<?php if( isset($OPERACION) && $OPERACION== "M"): ?>
<input type="hidden" name="IDNRO" value="{{isset($DATO)? $DATO->IDNRO: '' }}">
<?php endif; ?>


<?php  if( $TABLA == "odemanda") : ?>

  <div class="row"> 
  <div  class="col-12 col-sm-3 col-md-2 col-lg-2">
    <div class="form-group">
      <label for="CODIGO">CÓDIGO</label>
      <input value="{{isset($DATO)?$DATO->CODIGO:''}}"    name="CODIGO"  type="text"  class="form-control form-control-sm">
    </div>
    </div>

    <div  class="col-12 col-sm-3 col-md-2 col-lg-2">
    <div class="form-group">
      <label for="CODIGO:">NOMBRES:</label>
      <input maxlength="50" value="{{isset($DATO)?$DATO->NOMBRES:''}}"    name="NOMBRES"  type="text"  class="form-control form-control-sm">
    </div>
    </div>

    <div  class="col-12 col-sm-3 col-md-2 col-lg-2">
    <div class="form-group">
      <label for="CODIGO:">TELÉFONO</label>
      <input value="{{isset($DATO)?$DATO->TELEFONO:''}}"    name="TELEFONO"  type="text"  class="form-control form-control-sm">
    </div>
    </div>

    <div  class="col-12 col-sm-3 col-md-2 col-lg-2">
    <div class="form-group">
      <label for="CODIGO:">OBS</label>
      <input value="{{isset($DATO)?$DATO->OBS:''}}"    name="OBS"  type="text"  class="form-control form-control-sm">
    </div>
    </div>

   

  <div  class="col-12 col-sm-3 col-md-2 col-lg-2 d-flex align-items-center">
        <button type="submit" class="btn btn-sm btn-info">GUARDAR</button>
  </div>
</div>

  
<?php  else:?>

<div class="row"> 
  <div  class="col-12 col-sm-3 col-md-2 col-lg-2">
      <input maxlength="50"   value="{{isset($DATO)?$DATO->DESCR:''}}"    name="DESCR"  type="text"  class="form-control form-control-sm">
    </div>
  <div  class="col-12 col-sm-3 col-md-3 col-lg-2">
        <button type="submit" class="btn btn-sm btn-info">GUARDAR</button>
  </div>
</div>

<?php  endif; ?>





</form>