<?php 
use App\Helpers\Helper; 
 
?>

<input type="hidden" name="CTA_JUDICIAL" value="{{  isset( $dato) ? $dato->CTA_JUDICIAL : $CTA_JUDICIAL }}">
@if(isset( $dato)  )
<input type="hidden" name="IDNRO" value="{ $dato->IDNRO }}">
@endif

<div class="row">
<div class="col-12 col-md-2">
        <label >CI°:</label>
        <input readonly value="{{ $CI}}"   type="text"  class="form-control form-control-sm">
    </div>
    <div class="col-12 col-md-3">
        <label >TITULAR:</label>
        <input readonly value="{{ $TITULAR}}"  name="TITULAR"  type="text"  class="form-control form-control-sm">
    </div>
    <div class="col-12 col-md-2">
        <!--CREACION DE CTA JUDICIAL -->
        <label >BANCO:</label>
        <input readonly value="{{$BANCO}}"   type="text"  class="form-control form-control-sm">
        <!--END CREACION DE CTA JUDICIAL -->

    </div>
    <div class="col-12 col-md-2">
        <label >NÚMERO CTA.BANCO:</label>
        <input readonly value="{{ $CTA_BANCO}}"   type="text"  class="form-control form-control-sm">
    </div>
</div>


<!-- Movimientos -->
<div class="row mt-2">
    <div class="col-12 col-md-4">
        <label >TIPO DE CUENTA:</label>
        <div class="form-check form-check-inline">
        <input {{ isset($dato->TIPO_CTA) ? ( substr($dato->TIPO_CTA,0,1)=="C"?'checked':'') : 'checked' }} onchange="cambiar(event)"  class="form-check-input" type="radio" name="TIPO_CTA" id="inlineRadio1" value="C">
        <label class="form-check-label" for="inlineRadio1">CAPITAL</label>
        </div>
        <div class="form-check form-check-inline">
        <input {{isset($dato->TIPO_CTA)? (  substr($dato->TIPO_CTA,0,1)=="L"? 'checked': ''): ''}}  onchange="cambiar(event)" class="form-check-input" type="radio" name="TIPO_CTA" id="inlineRadio2" value="L">
        <label class="form-check-label" for="inlineRadio2">LIQUIDACIÓN</label>
        </div>
 
    </div>

    <div class="col-12 col-md-8">
        <label >TIPO DE MOVIMIENTO:</label>
        <div class="form-check form-check-inline">

        <input  {{$flag_deposito_opc}}        {{isset($dato->TIPO_MOVI)? ( substr($dato->TIPO_MOVI,0,1)=="D"?"checked":"") : ''}} onchange="cambiar(event)"  class="form-check-input" type="radio" name="TIPO_MOVI" id="inlineRadio1" value="D">
        <label class="form-check-label" for="inlineRadio1">DEPÓSITO</label>
        </div>
        <div class="form-check form-check-inline">
        <input {{isset($dato->TIPO_MOVI)? (  substr($dato->TIPO_MOVI,0,1)=="E"?"checked":""): 'checked'}}  onchange="cambiar(event)" class="form-check-input" type="radio" name="TIPO_MOVI" id="inlineRadio2" value="E">
        <label class="form-check-label" for="inlineRadio2">EXTRACCIÓN</label>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-12 col-md-3">
            <label >Fecha:</label>
            <input name="FECHA"  value="{{ isset($dato->FECHA)? Helper::fecha_f($dato->FECHA) : ''}}"  type="date"  class="form-control form-control-sm">
    </div>
    <div class="col-12 col-md-3">
            <label >Importe:</label>
            <input  maxlength="10" value="{{ isset($dato->IMPORTE)?Helper::number_f($dato->IMPORTE):''}}"   oninput="formatear(event)" name="IMPORTE" type="text"  class="form-control form-control-sm">
    </div>
   
    <div class="col-12 col-md-4"  >
        <label >TIPO DE EXTRACCIÓN:</label><br>
        <div class="form-check form-check-inline">

        <input      {{isset($dato->TIPO_EXT)? ( $dato->TIPO_EXT =="E"? "checked":"") : ''}}   class="form-check-input" type="radio" name="TIPO_EXT" id="inlineRadio1" value="E">
        <label class="form-check-label" for="inlineRadio1">EFECTIVO</label>
        </div>
        <div class="form-check form-check-inline">
        <input {{isset($dato->TIPO_EXT)? (  $dato->TIPO_EXT =="C"?"checked":""): ''}}    class="form-check-input" type="radio" name="TIPO_EXT" id="inlineRadio2" value="C">
        <label class="form-check-label" for="inlineRadio2">CHEQUE</label>
        </div>
    </div>


 
    <div id="chequenro" class="col-12 col-md-3  ">
            <label >Número de Cheque:</label>
            <input maxlength="20" value="{{ isset($dato->CHEQUE_NRO)? $dato->CHEQUE_NRO: ''}}" name="CHEQUE_NRO" type="text"  class="form-control form-control-sm"> 
    </div>
    
</div>
 

 