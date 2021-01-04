@php 

 
$DESCR=  isset($DATO)?$DATO->DESCR:'';
$MAX_USERS= isset($DATO)?$DATO->MAX_USERS:'';
$PRECIO= isset($DATO)?$DATO->PRECIO:'0';
$DURACION= isset($DATO)?$DATO->DURACION:'';
@endphp

<div  class="row">
  
  <div  class="col-12 mb-1">
    <label for="">Descripción:</label>
      <input maxlength="100"   value="{{$DESCR}}"    name="DESCR"  type="text"  class="form-control form-control-sm">
    </div>

    <div  class="col-12 mb-1">
    <label for="">N° Máximo de usuarios:</label>
      <input maxlength="10"  oninput="solo_numero(event)" value="{{$MAX_USERS}}"    name="MAX_USERS"  type="text"  class="form-control form-control-sm">
    </div>


    <div  class="col-12 mb-1">
    <label for="">Precio:</label>
      <input maxlength="10"  onfocus="if(this.value=='') this.value='';" onblur="if(this.value=='') this.value='0';"  oninput="solo_numero_mas_formato(event)" value="{{$PRECIO}}"    name="PRECIO"  type="text"  class="form-control form-control-sm">
    </div>

    <div  class="col-12 mb-1">
    <label for="">Duración:</label>
      <input maxlength="10"  oninput="solo_numero(event)" value="{{$DURACION}}"    name="DURACION"  type="text"  class="form-control form-control-sm">
    </div>


  <div  class="col-12">
        <button   class="btn btn-primary btn-sm"  type="submit" class="btn btn-sm btn-info">GUARDAR</button>
  </div>
</div>