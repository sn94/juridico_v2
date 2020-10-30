<?php

use Illuminate\Support\Facades\URL;
use App\Helpers\Helper;

$rutaEspecial="";
if( $OPERACION == "A+")  $rutaEspecial = url("demandas-agregar");
if( $OPERACION == "A" || $OPERACION == "M") $rutaEspecial=  url("demandas-editar") ;

?>
<form  onsubmit="enviarDemanda(event)" id="formDeman" class="tab-content" method="post" action="<?=  $rutaEspecial ?>">
 
{{csrf_field()}}
 
<?php if( $OPERACION != "V"): ?>
   
    <div class="row">
      <div class=" col-12 col-md-1">
      <button type="submit" class="btn btn-success btn-sm mb-1" >Guardar</button>
      </div>
      <div class="col-12 col-md-2">
        <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="1000">
        <div role="alert" aria-live="assertive" aria-atomic="true" id="dema-msg">GUARDADO</div>
        </div>
      </div>
    </div>

<?php endif; ?>

 <input id="CI1" type="hidden" name="CI"  value="{{isset($ci)?$ci:''}}">
 <?php if( $OPERACION != "A+"): ?>
    <input  id="IDNRO0"  type="hidden" name="IDNRO"  value="{{isset($ficha)?$ficha->IDNRO:''}}">
 <?php endif; ?>

 <div id="demanda-panel">

 </div>
 <div class="row p-1">
    <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4   verde1"  >
 
     
          <div class="row">
<!--Primera columna-->
<div class="col-12 col-sm-6 col-md-12 col-lg-12 p-1">

               <div class="row">
               <div class="col-12 col-sm-4 col-md-4 col-lg-4">  <label for="actuaria">Origen:</label></div>
               <div class="col-12 col-sm-8 col-md-8 col-lg-8">
                         
                         <select class="form-control form-control-sm" name="O_DEMANDA" id="">
                              <?php
                              $ori=  !isset($ficha)? '' : $ficha->O_DEMANDA;
                              foreach($origen as $it): 
                                   if( $ori == $it->CODIGO)  echo "<option selected value='{$it->CODIGO}'>{$it->NOMBRES}</option>"; 
                                   else  echo "<option value='{$it->CODIGO}'>{$it->NOMBRES}</option>"; 
                              endforeach;
                              ?>
                         </select> 
               </div>
               </div>
              
            <div class="row">
               <div class="col-12 col-sm-4 col-md-4"> <label for="actuaria">Demandante:</label> </div>
               <div class="col-12 col-sm-8 col-md-8">
                         <select name="DEMANDANTE" class="form-control form-control-sm">
                                   <?php 

                                   $demandanTE=  !isset($ficha)? '' : $ficha->DEMANDANTE;
                                   foreach($demandantes as $it): 
                                        if( $demandanTE == $it->DESCR || $demandanTE == $it->IDNRO)//Ojo
                                        echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                                        else{
                                             echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                                        }
                                        
                                   endforeach;  ?>
                         </select>
               </div></div>
                   
               <div class="row">
               <div class="col-12 col-sm-4 col-md-4">      <label for="actuaria">Cod_emp:</label> </div>
               <div class="col-12 col-sm-8 col-md-8">
               <input  name="COD_EMP"  type="text"   class="form-control form-control-sm" value="{{ !isset($ficha)? '' : $ficha->COD_EMP}}">
               </div>
               </div>
                    
               <div class="row">
               <div class="col-12 col-sm-4 col-md-4">          <label for="actuaria">Demanda:</label></div>
               <div class="col-12 col-sm-8 col-md-8"> 
                    <input name="DEMANDA"   oninput="formatear(event)"  type="text"   class="form-control form-control-sm number-format" value="{{Helper::number_f( !isset($ficha)? '' : $ficha->DEMANDA)}}">
               </div></div>
              
               <div class="row">
               <div class="col-12 col-sm-4 col-md-4"> <label for="actuaria">Saldo:</label></div>
               <div class="col-12 col-sm-8 col-md-8">
               
               <input readonly type="text" class="form-control form-control-sm number-format" value="{{Helper::number_f( !isset($ficha)? '' : $ficha->SALDO)}}">
               
               </div>
               </div>
                  
</div>

<div class="col-12 col-sm-6 col-md-12 col-lg-12">
              

               <div class="row">
               <div class="col-12 col-sm-3 col-md-4">  <label for="actuaria">Juzgado:</label> </div>
               <div class="col-12 col-sm-9 col-md-8">
                              <select name="JUZGADO" class="form-control form-control-sm">
                                   <?php 

                                   $JUZ=  !isset($ficha)? '' : $ficha->JUZGADO;
                                   foreach($juzgados as $it): 
                                        if( $JUZ == $it->DESCR || $JUZ == $it->IDNRO)//Ojo
                                        echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                                        else{
                                             echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                                        }
                                        
                                   endforeach;  ?>
                         </select>  
               </div> 
               </div>
              
               <div class="row">
               <div class="col-12 col-sm-3 col-md-4">  <label for="actuaria">Juez:</label> </div>
               <div class="col-12 col-sm-9 col-md-8">
                         <select name="JUEZ" class="form-control form-control-sm">
                                   <?php 

                                   $jueCES=  !isset($ficha)? '' : $ficha->JUEZ;
                                   foreach($jueces as $it): 
                                        if( $jueCES == $it->DESCR || $jueCES == $it->IDNRO)//Ojo
                                        echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                                        else{
                                             echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                                        }
                                        
                                   endforeach;  ?>
                         </select>
               </div>  </div> 
               
               <div class="row">
               <div class="col-12 col-sm-3 col-md-4"> <label for="actuaria">Actuaria:</label></div>
                         <div class="col-12 col-sm-9 col-md-8">
                         <select name="ACTUARIA" class="form-control form-control-sm">
                                             <?php 

                                             $actuariAS=  !isset($ficha)? '' : $ficha->ACTUARIA;
                                             foreach($actuarias as $it): 
                                                  if( $actuariAS == $it->DESCR || $actuariAS == $it->IDNRO)//Ojo
                                                  echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                                                  else{
                                                       echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                                                  }
                                                  
                                             endforeach;  ?>
                                   </select> 
               </div>
               </div>
               
               <div class="row">
               <div class="col-12 col-sm-3 col-md-4">  <label for="actuaria">Exped. N°:</label>  </div>
               <div class="col-12 col-sm-9 col-md-8">  <input maxlength="20"  name="EXPED_NRO"  type="text"   class="form-control form-control-sm" value="{{ !isset($ficha)? '' : $ficha->EXPED_NRO}}">  </div>        
               </div>

               <div class="row">
               <div class="col-12 col-sm-3 col-md-4"><label for="actuaria">Folio Expediente:</label></div>
               <div class="col-12 col-sm-9 col-md-8">
                              <input maxlength="20"  name="FOLIO_EXPED"  type="text"   class="form-control form-control-sm" value="{{ !isset($ficha)? '' : $ficha->FOLIO_EXPED}}">
               </div>
               </div>
                    
                                 
              
                         
                   
               </div><!--Segunda columna-->
                                
       

          </div>
     
    </div>

      <!-- fin panel 1 -->


<!--inicio Panel 2 -->
    <div class="col-12 col-sm-6 col-md-12 col-lg-4 col-xl-4 p-1 verde2"  >

    <div class="row">
          <div class="col-12 col-sm-4 col-md-4 col-lg-5"> <label for="actuaria">Embarg. Institución:</label></div>
          <div class="col-12 col-sm-8 col-md-8 col-lg-7">
                 <select name="INSTITUCIO" class="form-control form-control-sm">
                    <?php 

                     $instituc=  !isset($ficha)? '' : $ficha->INSTITUCIO;
                    foreach($instituciones as $it): 
                         if( $instituc == $it->DESCR || $instituc == $it->IDNRO)//Ojo
                           echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                         else{
                              echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                         }
                         
                    endforeach;  ?>
             </select>  
          </div> 
     </div>

    <div class="row">
          <div class="col-12 col-sm-4 col-md-4 col-lg-5">   <label for="actuaria">Embargo N°:</label></div>
          <div class="col-12 col-sm-8 col-md-8 col-lg-7"> 
                <input  name="EMBARGO_NR"  type="text"   class="form-control form-control-sm" value="{{ !isset($ficha)? '' : $ficha->EMBARGO_NR}}">
          </div>      
     </div> 
 
    <div class="row">
          <div class="col-12 col-sm-4 col-md-4 col-lg-5">  <label for="actuaria">Fecha de embargo:</label> </div>
          <div class="col-12 col-sm-8 col-md-8 col-lg-7">
          <input  name="FEC_EMBARG"    type="date"      class="form-control form-control-sm" value="{{Helper::fecha_f( !isset($ficha)? '' : $ficha->FEC_EMBARG)}}">
          </div>      
     </div>
    
     <div class="row">
          <div class="col-12 col-sm-4 col-md-4 col-lg-5"> <label for="actuaria">Banco:</label></div>
          <div class="col-12 col-sm-8 col-md-8 col-lg-7">
            <select name="BANCO" class="form-control form-control-sm">
                   <?php 

                    $loc=  !isset($ficha)? '' : $ficha->BANCO;
                   foreach($bancos as $it): 
                        if( $loc == $it->DESCR || $loc == $it->IDNRO)//Ojo
                          echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                        else{
                             echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                        }
                        
                   endforeach;  ?>
            </select> 
          </div>
     </div>


    <div class="row">
          <div class="col-12 col-sm-4 col-md-4 col-lg-5"> <label for="actuaria">Cuenta Judicial:</label></div>
          <div class="col-12 col-sm-8 col-md-8 col-lg-7">
              <input  name="CTA_BANCO"  type="text"   class="form-control form-control-sm" value="{{ !isset($ficha)? '' : $ficha->CTA_BANCO}}">
          </div>
     </div>


     
    Adj.Lev.Embargo:
     
    <div class="row">
          <div class="col-12 col-sm-4 col-md-4 col-lg-5">  <label for="actuaria">Fecha:</label></div>
          <div class="col-12 col-sm-8 col-md-8 col-lg-7">
          <input name="ADJ_LEV_EMB_FEC"   type="date"   class="form-control form-control-sm" value="{{ !isset($ficha)? '' : $ficha->ADJ_LEV_EMB_FEC}}">
           </div>
             
     </div>
     
  
  
<!--
   <div class="form-group">
            <label for="actuaria">Nro. Finca:</label>
             <input name="FINCA_NRO"   type="text"   class="form-control form-control-sm" value="">
        </div>
  


   <div class="form-group">
            <label for="actuaria">Cta.Catastral:</label>
             <input  name="CTA_CATAST"  type="text"   class="form-control form-control-sm" value="">
        </div>
               -->
   
    </div> <!-- end End panel 2 col 1 -->
     

    <!--ini panel 2 col 2-->
    <div class="col-12 col-sm-6 col-md-12 col-lg-4 col-xl-4 p-1 verde3"   >
    Lev.Embargo Capital:
   
   <div class="row">
           <div class="col-12 col-sm-4 col-md-4"> <label for="actuaria">Numero:</label></div>
           <div class="col-12 col-sm-8 col-md-8">  <input name="LEV_EMB_CAP_NRO"   type="text"   class="form-control form-control-sm" value="{{ !isset($ficha)? '' : $ficha->LEV_EMB_NRO}}"> </div>
    </div>
 
   <div class="row">
              <div class="col-12 col-sm-4 col-md-4">  <label for="actuaria">Fecha:</label> </div>
              <div class="col-12 col-sm-8 col-md-8"> <input name="LEV_EMB_CAP_FEC"   type="date"   class="form-control form-control-sm" value="{{ !isset($ficha)? '' : $ficha->LEV_EMB_FEC}}"> </div>         
    </div>

          <div class="row">
               <div class="col-12 col-sm-4 col-md-4"> <label for="actuaria">Institución:</label></div>
               <div class="col-12 col-sm-8 col-md-8">
                         <select name="LEV_EMB_CAP_INST" class="form-control form-control-sm">
                         <?php 

                              $instituc=  !isset($ficha)? '' : $ficha->LEV_EMB_CAP_INST;
                         foreach($instituciones as $it): 
                              if( $instituc == $it->DESCR || $instituc == $it->IDNRO)//Ojo
                                   echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                              else{
                                   echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                              }
                              
                         endforeach;  ?>
                    </select>  
               </div> 
          </div>
 
          <div class="row">
               <div class="col-12 col-sm-4 col-md-4"> <label for="actuaria">Tipo:</label></div>
               <div class="col-12 col-sm-8 col-md-8">
                         
                         <select name="INST_TIPO" class="form-control form-control-sm">
                         <?php 

                              $instiPO=  !isset($ficha)? '' : $ficha->INST_TIPO;
                         foreach($instipos as $it): 
                              if( $instiPO == $it->DESCR || $instiPO == $it->IDNRO)//Ojo
                                   echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                              else{
                                   echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                              }
                              
                         endforeach;  ?>
                    </select>   
               </div>
               </div>

               <div class="row">
                    <div class="col-12 col-sm-5 col-md-5"> <label >Con depósito:</label><br>  </div>
                    <div class="col-12 col-sm-7 col-md-7">
                         <div class="form-check form-check-inline">
                         <input {{isset($ficha->CON_DEPOSITO)? (  $ficha->CON_DEPOSITO =="S"?"checked":"") : ''}} onchange="cambiar(event)"  class="form-check-input" type="radio" name="CON_DEPOSITO" id="inlineRadio1" value="S">
                         <label class="form-check-label" for="inlineRadio1">SI</label>
                         </div>
                         <div class="form-check form-check-inline">
                         <input {{isset($ficha->CON_DEPOSITO)? (  $ficha->CON_DEPOSITO =="N"?"checked":""): ''}}  onchange="cambiar(event)" class="form-check-input" type="radio" name="CON_DEPOSITO" id="inlineRadio2" value="N">
                         <label class="form-check-label" for="inlineRadio2">NO</label>
                         </div>
                    </div>
               </div>

     
               <div class="row">
                         <div class="col-12 col-sm-4 col-md-4"><label>Observación</label></div>
                         <div class="col-12 col-sm-8 col-md-8">
                         <input name="OBS"   type="text"   class="form-control form-control-sm" value="{{ !isset($ficha)? '' : $ficha->OBS}}">
                         </div>
               </div>

          <div class="row">
               <div class="col-12 col-sm-7 col-md-6"> <label >Con arreglo extrajud.:</label>  </div>
               <div class="col-12 col-sm-5 col-md-6">
               {{isset($ficha->ARR_EXTRAJUDI)? (  $ficha->ARR_EXTRAJUDI =="S"?" SI ":" NO ") : '-'}}
                </div>
          </div>
    </div><!-- end  panel 2 col 2 -->
 </div><!-- end row -->
   
</form>
<script>

var Operstr= document.getElementById("operacion").value;
// Operacion A-gregar, deshabilitar inicialmente
//Nueva Demandado y Nueva demanda
if( Operstr =="A")  
 habilitarCampos('formDeman',false);
 //Nueva Demanda para Demandado ya existente en la BD  A+
 //Actualizacion de datos de demandado y demanda       M

if(Operstr =="A+"  || Operstr =="M")
habilitarCampos('formDeman', true);

     
// Deshabilitar campos para Vista de solo lectura V
if(Operstr =="V"  )
habilitarCampos('formDeman', false);




//Elimina los puntos separadores para campos numericos con formato
function limpiar_campos_dema(){ 
  $("#formDeman .number-format").each( function( indice, obj){    quitarSeparador( obj); } );
}
//Restaura el formato de millares para campos numericos
function rec_formato_numerico_dema(){ 
  $("#formDeman .number-format").each( function( indice, obj){    numero_con_puntuacion( obj); } );
}



function control_post_registro(res){
     console.log("control_post_registro", res );
     if($("#operacion").val() == "A+"){//rEGISTRO DE DEMANDADO YA EXISTENTE, SOLO SE LE CARGA UN NUEVO JUICIO
     //Asignar ID DE DEMANDA
     $("#formNoti input[name=IDNRO],#formObser input[name=IDNRO],#formContra input[name=IDNRO],#formExtrajudi input[name=IDNRO]").val( res.id_demanda);
     //Asignar el numero de cedula
     $("input[name=CI]").val(  res.ci);
     //HABILITAR FORMULARIOS RESTANTES
     habilitarCampos("formNoti",true); 
     habilitarCampos("formObser",true);
     habilitarCampos("formContra",true);
     habilitarCampos("formExtrajudi",true);
               
     } 
     //cambiar a edicion
     if($("#operacion").val() == "A+"   ){//rEGISTRO DE DEMANDADO YA EXISTENTE, SOLO SE LE CARGA UN NUEVO JUICIO
     document.getElementById("operacion").value= "M";
     show_edit_demanda_form(   res.id_demanda);
     }
}
 
function enviarDemanda( ev){ // ENVIO FORM DEMANDA
  
     ev.preventDefault();  
     //limpiar campo demanda 
     limpiar_campos_dema();
      $.ajax(
      {
        url:  ev.target.action,
        method: "post",
        data: $("#"+ev.target.id).serialize(),
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        beforeSend: function(){
          $("#demanda-panel").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
          
        },
        success: function( res ){  
           
           console.log( res);
            if( "error" in res){
              $("#demanda-panel").html( "" ); 
              alert( res.error);
            }else{ 
              //Mostrar mensaje 
              $("#demanda-panel").html(  ""  ); //mensaje 
              if ($("#operacion").val() == "M" )
               {  $("#dema-msg").text( "GUARDADO!");$(".toast").toast("show"); }


              control_post_registro( res );
            }
            rec_formato_numerico_dema();
        },
        error: function(){ 
           $("#demanda-panel").html(  "" );
           alert("Problemas de conexión");
           rec_formato_numerico_dema();
              }
      }
    );//fin ajax

}




function   show_edit_demanda_form(  id_demanda){

          $.ajax(  {
          url: "<?=url("demandas-editar")?>"+"/"+id_demanda,
          beforeSend: function(){
                    $("#demanda-collapse").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
                    
               },
          success: function(  form){
              
               $("#demanda-collapse").html( form ); 
               $("#dema-msg").text( "GUARDADO!");$(".toast").toast("show"); 
          }, 
          error: function(){ 
                    $("#demanda-collapse").html(  "" );
                    alert("Problemas de conexión"); 
                    }

          });
}



 </script>
  

  

 