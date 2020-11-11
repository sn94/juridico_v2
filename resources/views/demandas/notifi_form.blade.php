 
  <form  id="formNoti" class="tab-content" method="post" action="<?= url("enotifi")?>" onsubmit="enviarSeguimiento(event)">


  <?php 
  use App\Helpers\Helper;
  if( $OPERACION != "V"): ?>

    <div class="row">
      <div class=" col-12 col-md-1">
      <button type="submit" class="btn btn-primary btn-sm" >Guardar</button>
      </div>
      <div class="col-12 col-md-2">
        <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="1000">
        <div role="alert" aria-live="assertive" aria-atomic="true" id="noti-msg">GUARDADO</div>
        </div>
      </div>
    </div>


<?php endif; ?>

  



  {{csrf_field()}} 



<div id="seguimiento-panel">
</div>

<input id="IDNRO1" type="hidden" name="IDNRO" value="{{isset($id_demanda)?$id_demanda:''}}">
<input id="CI2" type="hidden" name="CI" value="{{  !isset($ficha2) ? '' : $ficha2->CI }}">
 

<!--PRIMER PANEL-->
<div class="row p-1" >

<div class="col-12 col-sm-6 col-md-6 col-lg-3 verde1"  >

<div class="form-group"> <label for="ctactecatas">Presentado:</label>
<input         value="{{Helper::fecha_f((! isset($ficha2) ? '' : $ficha2-> PRESENTADO))}}" name="PRESENTADO" type="date"  class="form-control form-control-sm">
    </div>

    <div class="form-group"> <label for="ctactecatas">Providencia:</label> 
      <input   value="{{Helper::fecha_f( (! isset($ficha2) ? '' : $ficha2-> PROVI_1) )}}" name="PROVI_1"   type="date"   class="form-control form-control-sm   ">
      </div>

      <div class="form-group">
        <label for="ctactecatas">1° Notificación:</label>
      <input   value="{{Helper::fecha_f((! isset($ficha2) ? '' : $ficha2-> NOTIFI_1))}}" name="NOTIFI_1"   type="date"    class="form-control form-control-sm   ">
      </div>

      <div class="form-group">
        <label for="ctactecatas">Adjunto A.I.:</label>
      <input   value="{{Helper::fecha_f((! isset($ficha2) ? '' : $ficha2-> ADJ_AI))}}" name="ADJ_AI"   type="date"      class="form-control form-control-sm   ">
      </div>   

      <div class="form-group">
        <label for="ctactecatas">A.I. Nro.:</label> 
      <input maxlength="10"  oninput="formatear(event)"  value="{{Helper::number_f((! isset($ficha2) ? '' : $ficha2-> AI_NRO))}}" name="AI_NRO" type="text"   class="form-control form-control-sm   ">
      </div>

      <div class="form-group"> 
        <label for="ctactecatas">A.I. Fecha:</label> 
      <input   value="{{Helper::fecha_f((! isset($ficha2) ? '' : $ficha2-> AI_FECHA))}}" name="AI_FECHA"   type="date"     class="form-control form-control-sm   ">
      </div>

      <div class="form-group"> 
        <label for="ctactecatas">Intimación:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2-> INTIMACI_1)}}" name="INTIMACI_1"   type="date"     class="form-control form-control-sm   ">
    </div>
    <div class="form-group"> 
        <label for="ctactecatas">Noti. A.I.Titular:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->NOTIFI1_AI_TIT)}}" name="NOTIFI1_AI_TIT"   type="date"     class="form-control form-control-sm   ">
    </div>
    <div class="form-group"> 
        <label for="ctactecatas">Noti. A.I.Garante:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->NOTIFI1_AI_GAR)}}" name="NOTIFI1_AI_GAR"   type="date"     class="form-control form-control-sm   ">
    </div>

   
</div><!--COLUMNA 1-->



 <!--COLUMNA 2-->
<div class="col-12 col-sm-6 col-md-6 col-lg-3 verde1" >

<div class="form-group"> 
      <label for="ctactecatas">Intimación 2:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2-> INTIMACI_2)}}" name="INTIMACI_2"   type="date"      class="form-control form-control-sm   ">
      </div>
      <div class="form-group"> 
        <label for="ctactecatas">Notif.2 A.I.Titular:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->NOTIFI2_AI_TIT)}}" name="NOTIFI2_AI_TIT"   type="date"     class="form-control form-control-sm   ">
    </div>
    <div class="form-group"> 
        <label for="ctactecatas">Notif.2 A.I.Garante:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->NOTIFI2_AI_GAR)}}" name="NOTIFI2_AI_GAR"   type="date"     class="form-control form-control-sm   ">
    </div>
    
<div class="form-group"> <label for="ctactecatas">Adj. Citación:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2-> CITACION)}}" name="CITACION"   type="date"   class="form-control form-control-sm   ">
    </div>

    <div class="form-group">
      <label for="ctactecatas">Providencia de Citación:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2-> PROVI_CITA)}}" name="PROVI_CITA"   type="date"     class="form-control form-control-sm   ">
    </div> 

<div class="form-group"> <label for="ctactecatas">2° Notificación:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2-> NOTIFI_2)}}" name="NOTIFI_2"   type="date"     class="form-control form-control-sm   ">
    </div>

    <div class="form-group">
        <label for="ctactecatas">Adjunto S.D.:</label> 
       <input   value="{{  Helper::fecha_f( !isset($ficha2) ? '' : $ficha2-> ADJ_SD) }}" name="ADJ_SD" type="date"   class="form-control form-control-sm">  </div>
     
   
    <div class="form-group">  <label for="ctactecatas">Nro.S.D.:</label> 
      <input  maxlength="10"  value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2-> SD_NRO)}}" name="SD_NRO" type="text"  class="form-control form-control-sm   ">
    </div>

      <div class="form-group"> <label for="ctactecatas">Fecha S.D:</label>
      <input    value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2-> SD_FECHA)}}" 	     type="date"     name="SD_FECHA"    class="form-control form-control-sm   ">
    </div>

    <div class="form-group"> <label for="ctactecatas">Finiquito S.D:</label>
      <input  maxlength="9"   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2-> SD_FINIQUI)}}" 	     type="text"     name="SD_FINIQUI"    class="form-control form-control-sm   ">
    </div>

     <div class="form-group"> <label for="ctactecatas">3° Notificación:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->NOTIFI_3)}}" name="NOTIFI_3"   type="date"    class="form-control form-control-sm   ">
    </div>

</div><!--COLUMNA 2-->



 <!--COLUMNA 3-->
 <div class="col-12 col-sm-6 col-md-6 col-lg-3 verde2">
   <!--liquid-->
   <div class="form-group"> <label for="ctactecatas">Adj. liquidación:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2-> ADJ_LIQUI)}}" name="ADJ_LIQUI"   type="date"    class="form-control form-control-sm   ">
    </div>

    <div class="form-group"> 
      <label for="ctactecatas">Providencia:</label> 
      <input   value="{{ Helper::fecha_f( !isset($ficha2) ? '' : $ficha2-> PROVI_2) }}" name="PROVI_2" type="date"   class="form-control form-control-sm   ">
    </div>

    <!--NOTIFI 4 --> 
    <div class="form-group"> 
      <label for="ctactecatas">4° Notificación:</label> 
      <input   value="{{ Helper::fecha_f( !isset($ficha2) ? '' : $ficha2->NOTIFI_4) }}" name="NOTIFI_4" type="date"   class="form-control form-control-sm   ">
    </div>

    <div class="form-group">
      <label for="ctactecatas">Adjunto aprobación:</label>
      <input  oninput="formatear(event)"  value="{{  Helper::fecha_f( !isset($ficha2) ? '' : $ficha2-> ADJ_APROBA) }}" name="ADJ_APROBA" type="date"  class="form-control form-control-sm   ">
    </div> 

    <div class="form-group"> <label for="ctactecatas">Importe aprobación:</label>
      <input maxlength="10"  oninput="formatear(event)"  value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2-> APROB_IMPO)}}" name="APROB_IMPO" type="text"  class="form-control form-control-sm  number-format ">
    </div>  
   <div class="form-group"> <label for="ctactecatas">Adj.Oficio:</label>
      <input   value="{{   Helper::fecha_f( !isset($ficha2) ? '' : $ficha2-> ADJ_OFICIO)  }}" name="ADJ_OFICIO" type="date"  class="form-control form-control-sm   ">
    </div>

    <!-- NOTIFI_5 --> 
    <div class="form-group"> <label  >5° Notificación:</label>
      <input   value="{{   Helper::fecha_f( !isset($ficha2) ? '' : $ficha2->NOTIFI_5 )  }}" name="NOTIFI_5" type="date"  class="form-control form-control-sm   ">
    </div>

    <div class="form-group">
      <label for="ctactecatas">Embargo Liq.N°:</label>
      <input   oninput="formatear(event)" value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2-> EMBARGO_N)}}" name="EMBARGO_N" type="text"   class="form-control form-control-sm   ">
    </div> 

    
<div class="form-group">
  <label for="ctactecatas">Fecha Emb.Liq.:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->EMB_FECHA)}}" 	     type="date"     name="EMB_FECHA"   class="form-control form-control-sm   ">
    </div> 

<div class="form-group">
       <label for="ctactecatas">Institución Emb.:</label>
       <select name="OTRA_INSTI" class="form-control form-control-sm">
                    <?php 

                     $instituc=  !isset($ficha2)? '' : $ficha2->OTRA_INSTI;
                    foreach($instituciones as $it): 
                         if( $instituc == $it->DESCR || $instituc == $it->IDNRO)//Ojo
                           echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                         else{
                              echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                         }
                         
                    endforeach;  ?>
             </select>   
</div> 

     <div class="form-group">
       <label for="ctactecatas">Monto Liquid.:</label>
      <input maxlength="10"  oninput="formatear(event)"  value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2-> LIQUIDACIO)}}" name="LIQUIDACIO" type="text"   class="form-control form-control-sm number-format  ">
    </div> 



 </div><!-- ************** -->



  <!--COLUMNA 4-->
  <div class="col-12 col-sm-6 col-md-6 col-lg-3 verde2"  >
    
<div class="form-group">
  <label for="ctactecatas">Saldo Liq.:</label>
      <input readonly maxlength="10" name="SALDO_LIQUI"   value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->SALDO_LIQUI)}}"  type="text"  class="form-control form-control-sm  number-format ">
      </div> 
<!--DESHABILITADO 
    <div class="form-group">
      <label for="ctactecatas">Importe:</label>
      <input maxlength="10"  oninput="formatear(event)"  value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->IMPORT_LIQUI)}}" name="IMPORT_LIQUI" type="text"   class="form-control form-control-sm number-format  ">
    </div> 
                  -->
   <div class="form-group">
     <label for="ctactecatas">Notif. Liquid.:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->NOTIFI_LIQUI)}}" name="NOTIFI_LIQUI"   type="date"   class="form-control form-control-sm   ">
    </div> 

    <div class="form-group">
      <label for="ctactecatas">Aprobación A.I:</label>
      <input maxlength="10"   value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->APROBA_AI)}}" name="APROBA_AI" type="text"   class="form-control form-control-sm  number-format ">
    </div>  

    <div class="form-group">
      <label for="ctactecatas">Fecha aprob. AI:</label> 
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->APRO_FECHA)}}" 	   type="date"     name="APRO_FECHA"     class="form-control form-control-sm   ">
      </div>  

    <div class="form-group">
      <label for="ctactecatas">Honorarios+IVA:</label>
      <input  maxlength="10"  value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->HONO_MAS_IVA )}}" name="HONO_MAS_IVA" type="text"  class="form-control form-control-sm  number-format ">
    </div>  

    

    <div class="form-group">
      <label for="ctactecatas">Notif. Honorarios:</label>
      <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->NOTIFI_HONOIVA )}}" name="NOTIFI_HONOIVA"   type="date"     class="form-control form-control-sm   ">
    </div> 

    <div class="row">
                    <div class="col-12 col-sm-5 col-md-6"> <label >Con depósito:</label><br>  </div>
                    <div class="col-12 col-sm-7 col-md-6">
                         <div class="form-check form-check-inline">
                         <input {{isset($ficha2->CON_DEPOSITO)? (  $ficha2->CON_DEPOSITO =="S"?"checked":"") : ''}} onchange="cambiar(event)"  class="form-check-input" type="radio" name="CON_DEPOSITO" id="inlineRadio1" value="S">
                         <label class="form-check-label" for="inlineRadio1">SI</label>
                         </div>
                         <div class="form-check form-check-inline">
                         <input {{isset($ficha2->CON_DEPOSITO)? (  $ficha2->CON_DEPOSITO =="N"?"checked":""): ''}}  onchange="cambiar(event)" class="form-check-input" type="radio" name="CON_DEPOSITO" id="inlineRadio2" value="N">
                         <label class="form-check-label" for="inlineRadio2">NO</label>
                         </div>
                    </div>
    </div>

    <div class="form-group">
      <label>Observación</label>
      <input maxlength="100" name="OBS"   type="text"   class="form-control form-control-sm" value="{{ !isset($ficha)? '' : $ficha->OBS}}">                
    </div>

  </div><!-- ************ -->
</div> <!--END PRIMER PANEL-->
 



 
 

 <!--tercer PANEL -->
 
<!--- ***************************-->
<div class="row">
    <div class="col-12 col-md-12 col-lg-8">
      <div class="row pt-1 verde3"  >
      <p> Adj.Informe al registro</p>
              <div class="col-12 col-sm-1 col-md-2 col-lg-1"><label for="ctactecatas">Fecha:</label></div>
              <div class="col-12 col-sm-3 col-md-4 col-lg-3">
                <input   oninput="formatear(event)"  value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->ADJ_INFO_FECHA )}}" name="ADJ_INFO_FECHA" type="date"  class="form-control form-control-sm   ">
          </div>
      </div> 
 

<div class="row p-1 verde4"  >

  <!-- PRIMER COL -->
  <div class="col-12 col-sm-4 col-md-4 ">
  <div class="row"><!-- INF. AUTOMOTORES -->
        <div class="form-group"><label for="ctactecatas">Inform. automotores:</label>
         <input  maxlength="30"    value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->INFO_AUTOMOTOR )}}" name="INFO_AUTOMOTOR" type="text"   class="form-control form-control-sm   ">
        </div>

        <div class="form-group"> <label for="ctactecatas">Vehículo:</label>
          <input maxlength="30"    value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->INFO_AUTOVEHIC )}}" name="INFO_AUTOVEHIC" type="text"  class="form-control form-control-sm   ">
        </div>
        
        <div class="form-group"> <label for="ctactecatas">Chasis:</label> 
        <input maxlength="30"     value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->INFO_AUTOCHASI )}}" name="INFO_AUTOCHASI" type="text"   class="form-control form-control-sm   ">
      </div>
    </div><!-- END  INF. AUTOMOTORES -->
  </div><!-- PRIMER COL -->


    <!-- SEGUNDO COL -->
  <div class="col-12 col-sm-4  col-md-4 ">
  <div class="row p-1 "><!-- INF. INMUEBLES -->
          <div class="form-group"> <label for="ctactecatas">Inform.inmuebles:</label>
          <input  maxlength="30"    value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->INFO_INMUEBLES )}}" name="INFO_INMUEBLES " type="text"  class="form-control form-control-sm   "></div>
        <div class="form-group"><label for="ctactecatas">Finca:</label>
        <input maxlength="30"    value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->INFO_INMUFINCA )}}" name="INFO_INMUFINCA " type="text"   class="form-control form-control-sm   "></div>
        <div class="form-group"> <label for="ctactecatas">Distrito:</label>
        <input maxlength="30"  value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->INFO_INMUDISTRI )}}" name="INFO_INMUDISTRI " type="text"  class="form-control form-control-sm   "></div>  
    </div><!-- END INF. INMUEBLES -->
</div> <!-- SEGUNDO COL -->


  <!-- TERCER COL -->
<div class="col-12 col-sm-4 col-md-4 ">

   <!-- EMBARGO -->
 <p style="text-decoration: underline; text-align: center;">  Embargo </p>
   <div class="row">
      <div class="col-6 col-sm-6 col-md-12">
      <div class="form-group"> <label >Inmueble:</label><br> 
                         <div class="form-check form-check-inline">
                         <input {{isset($ficha2->EMB_INMUEBLE)? (  $ficha2->EMB_INMUEBLE =="S"?"checked":"") : ''}} onchange="cambiar(event)"  class="form-check-input" type="radio" name="EMB_INMUEBLE" id="inlineRadio1" value="S">
                         <label class="form-check-label" for="inlineRadio1">SI</label>
                         </div>
                         <div class="form-check form-check-inline">
                         <input {{isset($ficha2->EMB_INMUEBLE)? (  $ficha2->EMB_INMUEBLE =="N"?"checked":""): ''}}  onchange="cambiar(event)" class="form-check-input" type="radio" name="EMB_INMUEBLE" id="inlineRadio2" value="N">
                         <label class="form-check-label" for="inlineRadio2">NO</label>
                         </div>
                    </div>
      </div>
      <div class="col-6 col-sm-6 col-md-12">
      <div class="form-group"> <label >Vehículo:</label><br>
                    
                    <div class="form-check form-check-inline">
                    <input {{isset($ficha2->EMB_VEHICULO)? (  $ficha2->EMB_VEHICULO =="S"?"checked":"") : ''}} onchange="cambiar(event)"  class="form-check-input" type="radio" name="EMB_VEHICULO" id="inlineRadio1" value="S">
                    <label class="form-check-label" for="inlineRadio1">SI</label>
                    </div>
                    <div class="form-check form-check-inline">
                    <input {{isset($ficha2->EMB_VEHICULO)? (  $ficha2->EMB_VEHICULO =="N"?"checked":""): ''}}  onchange="cambiar(event)" class="form-check-input" type="radio" name="EMB_VEHICULO" id="inlineRadio2" value="N">
                    <label class="form-check-label" for="inlineRadio2">NO</label>
                    </div>
               </div> 
      </div>
   </div>
                   
         
       
         <!-- END EMBARGO -->
</div><!-- TERCER COL -->
 
    </div>
    </div>

    <div class="col-12 col-md-12 col-lg-4 p-1 verde5"  >
 <!--INHIBICION -->
  
 <p>Adj.Inhibición</p>
 <div class="row">
          <div class="col-12 col-md-5">   <label for="ctactecatas">Fecha:</label></div>
          <div class="col-12 col-md-7"> 
             <input   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->ADJ_INHI_FEC)}}"     type="date"     name="ADJ_INHI_FEC"    class="form-control form-control-sm   "></div>
</div>
 
  Inhibición
<div class="row">
          <div class="col-12 col-md-5">  <label for="ctactecatas">A.I. N°:</label></div>
          <div class="col-12 col-md-7">
            <input maxlength="10"  oninput="formatear(event)"   value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->INHI_AI_NRO)}}" name="INHI_AI_NRO" type="text"   class="form-control form-control-sm   "></div>
</div>

  <div class="row">
          <div class="col-12 col-md-5">    <label for="ctactecatas">Fecha A.I.:</label></div>
          <div class="col-12 col-md-7">
            <input   oninput="formatear(event)"   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2->INHI_AI_FEC)}}" name="INHI_AI_FEC" type="date"   class="form-control form-control-sm   ">
  </div></div>

  <div class="row">
          <div class="col-12 col-md-5"> <label for="ctactecatas">Inhibición N°:</label></div>
          <div class="col-12 col-md-7"><input maxlength="10"  oninput="formatear(event)"   value="{{Helper::number_f(! isset($ficha2) ? '' : $ficha2->INHI_NRO)}}" name="INHI_NRO" type="text"  class="form-control form-control-sm   ">
  </div></div>

 <div class="row">
          <div class="col-12 col-md-5"> <label for="ctactecatas">Fecha Inhibición:</label></div>
          <div class="col-12 col-md-7">
            <input   oninput="formatear(event)"   value="{{Helper::fecha_f(! isset($ficha2) ? '' : $ficha2-> FEC_INIVI)}}" name="FEC_INIVI" type="date"  class="form-control form-control-sm   ">
  </div></div>
 
   <!--end INHIBICION-->
    </div>
    </div><!--- ***************************-->

 
  </form>



<script>
  var operacSt= document.getElementById("operacion").value;
  //A   Nueva demanda Nuevo Demandado
  //A+ Nueva demanda para demandado ya existente
if(  operacSt =="A" || operacSt == "A+")
habilitarCampos('formNoti',false);
//Actualizacion de demandado y demanda
if(operacSt =="M")
habilitarCampos("formNoti", true);
 //Solo lectura
 if( operacSt =="V")
 habilitarCampos("formNoti", false);


  function sele_desele( target){
    let input= target.id;
    if( target.checked){
      document.querySelector("input[name="+input+"]").value= "s";
    }else{
      document.querySelector("input[name="+input+"]").value= "n";
    } 
  }






  function limpiar_campos_seg(){ 
  $("#formNoti .number-format").each( function( indice, obj){    quitarSeparador( obj); } );
}
function rec_formato_numerico_noti(){ 
  $("#formNoti .number-format").each( function( indice, obj){    numero_con_puntuacion( obj); } );
}




function enviarSeguimiento( ev){ //envio DE FORM SEGUIMIENTO
  ev.preventDefault();  
  limpiar_campos_seg();
        $.ajax(
        {
          url:  ev.target.action,
          method: "post",
          data: $("#"+ev.target.id).serialize(),
          dataType: "json",
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          beforeSend: function(){
            $("#seguimiento-panel").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
          },
          success: function( res ){ 
              if( "error" in res){ 
                $("#seguimiento-panel").html( "" ); 
                alert(res.error);
              }else{ 
                //Mostrar mensaje 
                $("#seguimiento-panel").html( "" ); 
                $("#noti-msg").text( "GUARDADO!");
                $(".toast").toast("show"); 
              }
              rec_formato_numerico_noti();
              
          },
          error: function(){
            $("#seguimiento-panel").html( "" ); 
            alert(  "Problemas de conexión ");
            rec_formato_numerico_noti();
          }
        }
      );
  
}/** */






</script>


 