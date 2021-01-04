<?php

use App\Helpers\Helper;
$ruta=  $OPERACION == "A" ? url("nliquida") : url("eliquida");
 ?>

<input type="hidden" id="OPERACION"  value="{{$OPERACION}}">


<form id="liquidaform" action="<?= $ruta?>" method="post" onsubmit="enviarLiquida(event)" >
  
{{csrf_field()}}


<?php if( $OPERACION != "V"): ?> 
   <button type="submit" class="btn btn-success btn-sm" >GUARDAR</button>
<?php endif; 
if( $OPERACION == "M" || $OPERACION == "V"  ): ?> <input type="hidden" name="IDNRO" value="{{ $dato->IDNRO }}" >
<?php endif; ?>


 

<input type="hidden" name="ID_DEMA" value="{{isset( $dato->ID_DEMA)? $dato->ID_DEMA : $id_demanda}}" >
<input type="hidden" name="TITULAR" value="{{isset( $dato->TITULAR)? $dato->TITULAR  : $TITULAR }}" >
<input type="hidden" name="CTA_BANCO" value="{{isset( $dato->CTA_BANCO)? $dato->CTA_BANCO  : ($CTA_BANCO ?? '') }}" >

<div class="row">
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >CAPITAL:</label>
              <input readonly value="{{isset( $dato->CAPITAL )?  Helper::number_f($dato->CAPITAL)  : Helper::number_f($CAPITAL)  }}" name="CAPITAL"  type="text"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >ULT.PAGO:</label>
              <input  onchange="calc_cta_meses()"    value="{{isset($dato->ULT_PAGO) ? Helper::fecha_f($dato->ULT_PAGO) : ''}}" name="ULT_PAGO"  type="date"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >ULT.CHEQUE:</label>
              <input onchange="calc_cta_meses()"  value="{{isset($dato->ULT_CHEQUE)? Helper::fecha_f($dato->ULT_CHEQUE) : ''}}" name="ULT_CHEQUE"  type="date"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >CTA.MESES:</label>
              <input readonly  value="{{isset($dato->CTA_MESES)?$dato->CTA_MESES: ''}}" name="CTA_MESES"  type="text"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >INTERESES %:</label>
              <input maxlength="2" oninput="onlyNumber(event)" name="INT_X_MES" value="{{isset($dato->INT_X_MES)?$dato->INT_X_MES: ''}}" type="text"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >IMP. INTERESES:</label>
              <input onchange="calc_honorarios()"  maxlength="10" oninput="calc_total(event)" name="IMP_INTERE" value="{{isset($dato->IMP_INTERE)?$dato->IMP_INTERE: ''}}" type="text"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >GST.NOTIFICACION:</label>
              <input maxlength="10"  oninput="calc_total(event)" name="GAST_NOTIF" value="{{isset($dato->GAST_NOTIF)?$dato->GAST_NOTIF: ''}}" type="text"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >GST.NOTIF.GTE:</label>
              <input  maxlength="10"oninput="calc_total(event)"  name="GAST_NOTIG" value="{{isset($dato->GAST_NOTIG)?$dato->GAST_NOTIG: ''}}" type="text"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >GST. EMBARGO:</label>
              <input maxlength="10"  oninput="calc_total(event)"  name="GAST_EMBAR" value="{{isset($dato->GAST_EMBAR)?$dato->GAST_EMBAR: ''}}" type="text"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >GST.ESTIMACIÓN:</label>
              <input maxlength="10" oninput="calc_total(event)"  name="GAST_INTIM" value="{{isset($dato->GAST_INTIM)?$dato->GAST_INTIM: ''}}" type="text"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-2 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >%HONORARIOS:</label>
              <input oninput="calc_honorarios()" maxlength="2"  oninput="onlyNumber(event)" name="HONO_PORCE" value="{{isset($dato->HONO_PORCE)?$dato->HONO_PORCE: ''}}" type="text"  class="form-control form-control-sm">
          </div>
  </div> 
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >HONORARIOS:</label>
              <input  readonly    name="HONORARIOS" value="{{isset($dato->HONORARIOS)?$dato->HONORARIOS: ''}}" type="text"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >I.V.A:</label>
              <input readonly maxlength="2"  oninput="onlyNumber(event)"  name="IVA" value="{{isset($dato->IVA)?$dato->IVA: ''}}" type="text"  class="form-control form-control-sm">
          </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
              <label >FINIQUITO:</label>
              <input oninput="calc_total(event)" id="finiquito" type="text"  class="form-control form-control-sm">
        </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
        <label >TOTAL:</label>
        <input  readonly name="TOTAL" value="{{isset($dato->TOTAL)?$dato->TOTAL: ''}}" type="text"  class="form-control form-control-sm">
      </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
          <label >IMP.EXTRAÍDO:</label>
          <input  maxlength="10"  oninput="calc_total(event)" name="EXTRAIDO" value="{{isset($dato->EXTRAIDO)?$dato->EXTRAIDO: ''}}" type="text"  class="form-control form-control-sm">
        </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
          <label >SALDO:</label>
          <input readonly name="SALDO" value="{{isset($dato->SALDO)? Helper::number_f($dato->SALDO) : Helper::number_f($SALDO) }}" type="text"  class="form-control form-control-sm">
        </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
        <label >EXTRAC.LIQUID.:</label>
        <input maxlength="10"  oninput="formatear(event)"  name="EXT_LIQUID" value="{{isset($dato->EXT_LIQUID)?$dato->EXT_LIQUID: ''}}" type="text"  class="form-control form-control-sm">
      </div>
  </div>
  <div class="col-12 col-sm-4  col-md-4 col-lg-3 col-xl-2">
  <div class="form-group">
        <label >NUEVO SALDO:</label>
        <input maxlength="10" oninput="formatear(event)" name="NEW_SALDO" value="{{isset($dato->NEW_SALDO)?$dato->NEW_SALDO: ''}}" type="text"  class="form-control form-control-sm">
      </div>
  </div>
  
 
  </div>
  
</form>
<script>

  //Calculos de valores de campos correlativos

  //aplicar a ult_cheque
  function calc_cta_meses(){
    let ult_pago= $("input[name=ULT_PAGO]").val();
    let ult_cheque= $("input[name=ULT_CHEQUE]").val();
    if( ult_pago != ""  &&  ult_cheque != ""){
        //diferencias de fechas
        let fecha1 = moment(ult_cheque);
        let fecha2 = moment( ult_pago);
        let diferen= Math.round( fecha1.diff(fecha2, 'days')   / 30  ); 
        $("input[name=CTA_MESES]").val(  diferen);
    } 
  }


//aplicar a hono_porce
  function calc_honorarios(){
    if( $("input[name=IMP_INTERE]").val() != ""  &&  $("input[name=HONO_PORCE]").val()!="" ){
    let capital= quitarSeparador( $("input[name=CAPITAL]").val() );
    let imp_intere= $("input[name=IMP_INTERE]").val();
    let hono_porce= $("input[name=HONO_PORCE]").val();
    let honorarios=  ((capital+imp_intere)*hono_porce)/100;
    console.log( "honora", honorarios);
    //FORMATEAR
    $("input[name=HONORARIOS]").val(  formatear_string( honorarios ) ); 
    //calcular IVA
    let iva= honorarios* 0.10;
    $("input[name=IVA]").val( iva) ;
    }
  }


  //aplicar a finiquito
  function calc_total(ev){
    if( ev.data== null ) return;
//Validar entrada
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value=   ev.target.value.substr( 0, ev.target.selectionStart-1) +  ev.target.value.substr( ev.target.selectionStart );
    } 
    //formato puntos
    let val_Act= ev.target.value;  
    val_Act= val_Act.replaceAll( new RegExp(/[\.]*[,]*/), ""); 
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		$( ev.target).val(  enpuntos);
  //Valores 
    let capital= quitarSeparadorInt( $("input[name=CAPITAL]"));
    let imp_intere= quitarSeparadorInt($("input[name=IMP_INTERE]"));
    let gast_notif= quitarSeparadorInt($("input[name=GAST_NOTIF]") );
    let gast_notig= quitarSeparadorInt($("input[name=GAST_NOTIG]") ); 
    let gast_embar= quitarSeparadorInt($("input[name=GAST_EMBAR]") );
    let gast_intim= quitarSeparadorInt($("input[name=GAST_INTIM]"));
    let honorarios= quitarSeparadorInt($("input[name=HONORARIOS]") );
    let iva= quitarSeparadorInt($("input[name=IVA]"));
    let finiquito= quitarSeparadorInt($("#finiquito") );
//inicializacion
    if( capital == "") capital= 0;
    if( imp_intere=="") imp_intere= 0;
    if( gast_notif=="") gast_notif= 0;
    if( gast_notig == "") gast_notig=0;
    if( gast_embar=="") gast_embar= 0;
    if( gast_intim=="") gast_intim=0;
    if(honorarios=="") honorarios= 0;
    if(iva=="") iva=0;
    if(finiquito=="") finiquito= 0;
    let total= capital+imp_intere+gast_notif+gast_notig+gast_embar+gast_intim+honorarios+iva+finiquito;
    $("input[name=TOTAL]").val( formatear_string( total ));

    //importe extraido
    let extraido= quitarSeparadorInt($("input[name=EXTRAIDO]") );
    let saldo=   total - extraido; 
    $("input[name=SALDO]").val( formatear_string( saldo ) );


  }





  
</script>