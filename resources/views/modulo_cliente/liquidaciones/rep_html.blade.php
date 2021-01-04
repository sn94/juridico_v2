<?php

use App\Helpers\Helper;


?>


<div class="row">
  <div class="col-12 col-md-3">
          <div class="form-group">
              <label >CAPITAL:</label>
              <input readonly value="{{isset( $dato->CAPITAL )?  Helper::number_f($dato->CAPITAL)  : Helper::number_f($CAPITAL)  }}" name="CAPITAL"  type="text"  class="form-control form-control-sm">
          </div>
          <div class="form-group">
              <label >ULT.PAGO:</label>
              <input  onchange="calc_cta_meses()"    value="{{isset($dato->ULT_PAGO) ? Helper::fecha_f($dato->ULT_PAGO) : ''}}" name="ULT_PAGO"  type="date"  class="form-control form-control-sm">
          </div>
          <div class="form-group">
              <label >ULT.CHEQUE:</label>
              <input onchange="calc_cta_meses()"  value="{{isset($dato->ULT_CHEQUE)? Helper::fecha_f($dato->ULT_CHEQUE) : ''}}" name="ULT_CHEQUE"  type="date"  class="form-control form-control-sm">
          </div>
          <div class="form-group">
              <label >CTA.MESES:</label>
              <input readonly  value="{{isset($dato->CTA_MESES)?$dato->CTA_MESES: ''}}" name="CTA_MESES"  type="text"  class="form-control form-control-sm">
          </div>
          <div class="form-group">
              <label >INTERESES %:</label>
              <input maxlength="2" oninput="onlyNumber(event)" name="INT_X_MES" value="{{isset($dato->INT_X_MES)?$dato->INT_X_MES: ''}}" type="text"  class="form-control form-control-sm">
          </div>
       

    </div>
    <div class="col-12 col-md-2">
    <div class="form-group">
              <label >IMP. INTERESES:</label>
              <input onchange="calc_honorarios()"  maxlength="10" oninput="calc_total(event)" name="IMP_INTERE" value="{{isset($dato->IMP_INTERE)?$dato->IMP_INTERE: ''}}" type="text"  class="form-control form-control-sm">
          </div>
    <div class="form-group">
              <label >GST.NOTIFICACION:</label>
              <input maxlength="10"  oninput="calc_total(event)" name="GAST_NOTIF" value="{{isset($dato->GAST_NOTIF)?$dato->GAST_NOTIF: ''}}" type="text"  class="form-control form-control-sm">
          </div>
          <div class="form-group">
              <label >GST.NOTIF.GTE:</label>
              <input  maxlength="10"oninput="calc_total(event)"  name="GAST_NOTIG" value="{{isset($dato->GAST_NOTIG)?$dato->GAST_NOTIG: ''}}" type="text"  class="form-control form-control-sm">
          </div>
          <div class="form-group">
              <label >GST. EMBARGO:</label>
              <input maxlength="10"  oninput="calc_total(event)"  name="GAST_EMBAR" value="{{isset($dato->GAST_EMBAR)?$dato->GAST_EMBAR: ''}}" type="text"  class="form-control form-control-sm">
          </div>
          <div class="form-group">
              <label >GST.ESTIMACIÓN:</label>
              <input maxlength="10" oninput="calc_total(event)"  name="GAST_INTIM" value="{{isset($dato->GAST_INTIM)?$dato->GAST_INTIM: ''}}" type="text"  class="form-control form-control-sm">
          </div>
        

    </div>
  
    <div class="col-12 col-md-2">
          <div class="form-group">
              <label >%HONORARIOS:</label>
              <input oninput="calc_honorarios()" maxlength="2"  oninput="onlyNumber(event)" name="HONO_PORCE" value="{{isset($dato->HONO_PORCE)?$dato->HONO_PORCE: ''}}" type="text"  class="form-control form-control-sm">
          </div>
          <div class="form-group">
              <label >HONORARIOS:</label>
              <input  readonly    name="HONORARIOS" value="{{isset($dato->HONORARIOS)?$dato->HONORARIOS: ''}}" type="text"  class="form-control form-control-sm">
          </div>
        <div class="form-group">
              <label >I.V.A:</label>
              <input readonly maxlength="2"  oninput="onlyNumber(event)"  name="IVA" value="{{isset($dato->IVA)?$dato->IVA: ''}}" type="text"  class="form-control form-control-sm">
          </div>
        <div class="form-group">
              <label >FINIQUITO:</label>
              <input oninput="calc_total(event)" id="finiquito" type="text"  class="form-control form-control-sm">
        </div>
        <div class="form-group">
        <label >TOTAL:</label>
        <input  readonly name="TOTAL" value="{{isset($dato->TOTAL)?$dato->TOTAL: ''}}" type="text"  class="form-control form-control-sm">
      </div>
    </div>
    <div class="col-12 col-md-2">
 
      <div class="form-group">
          <label >IMP.EXTRAÍDO:</label>
          <input  maxlength="10"  oninput="calc_total(event)" name="EXTRAIDO" value="{{isset($dato->EXTRAIDO)?$dato->EXTRAIDO: ''}}" type="text"  class="form-control form-control-sm">
        </div>
        <div class="form-group">
          <label >SALDO:</label>
          <input readonly name="SALDO" value="{{isset($dato->SALDO)? Helper::number_f($dato->SALDO) : Helper::number_f($SALDO) }}" type="text"  class="form-control form-control-sm">
        </div>
      <div class="form-group">
        <label >EXTRAC.LIQUID.:</label>
        <input maxlength="10"  oninput="formatear(event)"  name="EXT_LIQUID" value="{{isset($dato->EXT_LIQUID)?$dato->EXT_LIQUID: ''}}" type="text"  class="form-control form-control-sm">
      </div>
      <div class="form-group">
        <label >NUEVO SALDO:</label>
        <input maxlength="10" oninput="formatear(event)" name="NEW_SALDO" value="{{isset($dato->NEW_SALDO)?$dato->NEW_SALDO: ''}}" type="text"  class="form-control form-control-sm">
      </div>
    </div>
 
  </div>