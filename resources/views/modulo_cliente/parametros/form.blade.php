<?php

use App\Helpers\Helper; 
?>


<div id="viewform">

</div>
<form id="paraform" action="<?= url("nparam") ?>" method="post" onsubmit="ajaxCall(event,'#viewform')">

{{csrf_field()}}

<div class="row">
<div class="col-12 col-sm-3 col-md-3 col-lg-3">
    <div class="form-group">
    <label >INTERÉS:</label>
<input oninput="decimal_field(event)"  maxlength="4" value="{{isset($DATO)? Helper::fromComaToDot($DATO->INTERES) : '' }}"   name="INTERES"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
    <div class="form-group">
    <label >MORA:</label>
    <input oninput="decimal_field(event)"  maxlength="4" value="{{isset($DATO)?  Helper::fromComaToDot($DATO->MORA)  : '' }}"   name="MORA"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
    <div class="form-group">
    <label >SEGURO:</label>
    <input oninput="decimal_field(event)"  maxlength="4"  value="{{isset($DATO)?  Helper::fromComaToDot($DATO->SEGURO) : '' }}"   name="SEGURO"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
    <div class="form-group">
    <label >REDONDEO:</label>
    <input  value="{{isset($DATO)?$DATO->REDONDEO : '' }}"   name="REDONDEO"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
    <div class="form-group">
    <label >%HONORARIOS:</label>
    <input oninput="decimal_field(event)"  value="{{isset($DATO)?  Helper::fromComaToDot($DATO->HONORARIOS) : '' }}"   name="HONORARIOS"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
    <div class="form-group">
    <label >I.V.A:</label>
    <input oninput="decimal_field(event)" maxlength="4"  value="{{isset($DATO)?  Helper::fromComaToDot($DATO->IVA) : '' }}"  name="IVA"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
    <div class="form-group">
    <label >PUNITORIO:</label>
    <input oninput="decimal_field(event)"  maxlength="4" value="{{isset($DATO)?  Helper::fromComaToDot($DATO->PUNITORIO) : '' }}"   name="PUNITORIO"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
    <div class="form-group">
    <label >GAST.ADMIN.:</label>
    <input oninput="decimal_field(event)"  maxlength="4"  value="{{isset($DATO)?  Helper::fromComaToDot($DATO->GASTOSADMIN) : '' }}"   name="GASTOSADMIN"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
  <div class="form-group">
    <label >DIASVTO.:</label>
    <input maxlength="2" oninput="number_field(event)"   value="{{isset($DATO)?$DATO->DIASVTO : '' }}"  name="DIASVTO"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
 
  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
  <div class="form-group">
    <label >FACTURA:</label>
    <input  oninput="number_field(event)"  value="{{isset($DATO)?$DATO->FACTURA : '' }}"  name="FACTURA"  type="text"  class="form-control form-control-sm">
    </div>
  </div>

  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
  <div class="form-group">
    <label >RECIBO:</label>
    <input   oninput="number_field(event)"  value="{{isset($DATO)?$DATO->RECIBO : '' }}"  name="RECIBO"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
 

  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
  <div class="form-group">
    <label >FECHA MIN.:</label>
    <input    value="{{isset($DATO)?  Helper::fecha_f($DATO->FECMIN) : '' }}"  name="FECMIN"  type="date"  class="form-control form-control-sm">
    </div>
  </div>


  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
  <div class="form-group">
    <label >FECHA MAX..:</label>
    <input   value="{{isset($DATO)? Helper::fecha_f($DATO->FECMAX) : '' }}"  name="FECMAX"  type="date"  class="form-control form-control-sm">
    </div>
  </div>
  <div class="col-12 col-sm-3 col-md-3 col-lg-3">
  <div class="form-group">
    <label >E-MAIL DE CONTROL:</label>
    <input   value="{{isset($DATO)? Helper::fecha_f($DATO->EMAIL) : '' }}"  name="EMAIL"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
 
 
  <div class="col-12 col-sm-5 col-md-5 col-lg-5">
    <input type="hidden" name="SHOW_COUNTERS">
  <div class="form-group">
    <label >Mostrar datos en pantalla principal:</label>
    <label class="switch switch-to-primary">
  <span class="mr-1">No</span>
  <input id="SHOW_COUNTERS" {{isset($DATO)? ($DATO->SHOW_COUNTERS=="S" ? 'checked': '') : '' }}    value="S" type="checkbox"/>
  <span class="switch-slider"></span>
  <span class="ml-1">Si</span>
</label> 
 </div>
  </div>

  <!--PARAMETRO ESTADO DEPOSITO CTA JUDICIAL -->
  <div class="col-12 col-sm-5 col-md-5 col-lg-5">
    <input type="hidden" name="DEPOSITO_CTA_JUDICI">
  <div class="form-group">
    <label >ACTIVAR OPC. DEPÓSITO EN CTA.JUDICIAL:</label>
    <label class="switch switch-to-primary">
  <span class="mr-1">No</span>
  <input id="DEPOSITO_CTA_JUDICI" {{isset($DATO)? ($DATO->DEPOSITO_CTA_JUDICI=="S" ? 'checked': '') : '' }}    value="S" type="checkbox"/>
  <span class="switch-slider"></span>
  <span class="ml-1">Si</span>
</label> 
 </div>
  </div>


  <div  class="col-12 col-sm-3 col-md-3 col-lg-3 d-flex align-items-center">
  <button type="submit" class="btn btn-sm btn-info">GUARDAR</button>
  </div>
</div>


</form>
  