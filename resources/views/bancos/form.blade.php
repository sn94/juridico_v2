<style>

#ctabcoform{
background: #6f72ff;
margin: 0;
}

    #ctabcoform label{
        color: #000128;
    }

    #ctabcoform h6{
        background-color: #6266ff;
        color: wheat;
    }

    #buttonSave{
background-color: #373dff;
    }
</style>

<?php 
use App\Helpers\Helper; 

?>

<form id="ctabcoform" onsubmit="guardar(event)" action="{{$RUTA}}" method="post">

@csrf
<?php if( isset($OPERACION) && $OPERACION == "M"): ?>
<input type="hidden" name="IDNRO" value="{{$dato->IDNRO}}" >
<?php endif;?>

<h6  class="text-center">{{$OPERACION=="A"?"NUEVA CUENTA":'ACTUALIZAR CTA.'}}</h6>


<p id="mensaje" style="text-align: center; font-weight: bold; color: #000128 ;"></p>
<div class="row p-2">
<div class="col-12 col-md-12">
        <label >TITULAR:</label>
        <input maxlength="60" value="{{isset( $dato->TITULAR)?$dato->TITULAR:''}}" name="TITULAR"  type="text"  class="form-control form-control-sm">
    </div>
    <div class="col-12 col-md-12">
        <label >BANCO:</label>
        <input maxlength="20" value="{{isset($dato->BANCO) ? $dato->BANCO : '' }}" name="BANCO"  type="text"  class="form-control form-control-sm">
    </div>
    <div class="col-12 col-md-12"> 
        <label >CUENTA:</label>
        <input maxlength="20"  value="{{isset($dato->CUENTA)? $dato->CUENTA: ''}}" name="CUENTA"  type="text"  class="form-control form-control-sm">
     </div>
    <div class="col-12 col-md-12">
        <label >TIPO DE CTA.:</label>
        <input readonly  value="{{isset($dato->TIPO_CTA)?$dato->TIPO_CTA: 'CtaCte'}}" name="TIPO_CTA"  type="text"  class="form-control form-control-sm">
    </div>
    <div class="col-12 col-md-12 d-flex align-items-center mt-1">
    <button id="buttonSave" class="btn btn-sm btn-info" type="submit">GUARDAR</button>
    </div>
</div> 

</form>

 
