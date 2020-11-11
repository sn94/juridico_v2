
<?php

$RUTA= $OPERACION == "A" ? url("ndemandado") : url("edemandado");

?>

<form  id="form-person" onsubmit="enviarDatosPerso(event)" method="post" action="<?= $RUTA ?>">

{{csrf_field()}}

@if( $OPERACION=="M")
<input type="hidden" name="IDNRO" value="{{! isset($ficha0) ? '' : $ficha0->IDNRO}}">
@endif

<div id="persona-panel"></div>


<?php if( $OPERACION != "V"): ?>
    
    <div class="row">
      <div class=" col-12 col-md-1">
      <button type="submit" class="btn btn-primary btn-sm mb-1" >Guardar</button>
      </div>
      <div class="col-12 col-md-2">
        <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="3000">
        <div role="alert" aria-live="assertive" aria-atomic="true" id="pers-msg">GUARDADO</div>
        </div>
      </div>
    </div>


<?php endif; ?>

 
<div class="row">

<div class="col-12 col-md-6 verde1"  >
      <div class="row p-1" >
        <!--PRIMERA COLUMNA -->
        <div class="col-12 col-sm-6 col-md-12 col-lg-6">
            <div class="row">
              <div class="col-12 col-sm-3 col-md-12">  <label for="titular">Titular:</label></div>
              <div class="col-12 col-sm-9 col-md-12">  <input maxlength="60" value="{{! isset($ficha0) ? '' : $ficha0->TITULAR}}" name="TITULAR" type="text" id="titular" class="form-control form-control-sm   "></div>
            </div>

            <div class="row">
            <div class="col-2 col-sm-3">  <label for="ci">CI°:</label></div>
            <div class="col-10 col-sm-9">
            <input type="hidden" id="CI-DEFAULT" value="{{! isset($ficha0) ? '' : $ficha0->CI}}">
              <input oninput="solo_numero(event)" maxlength="9"  value="{{! isset($ficha0) ? '' : $ficha0->CI}}" name="CI" type="text" id="ci" class="form-control form-control-sm   ">
            </div>
          </div>

            <div class="row">
            <div class="col-12 col-sm-3 col-md-12 col-lg-12"><label for="direccion">Direccion:</label>  </div>
            <div class="col-12 col-sm-9 col-md-12 col-lg-12"> <input maxlength="150" value="{{! isset($ficha0) ? '' : $ficha0->DOMICILIO}}" name="DOMICILIO" type="text" id="direccion" class="form-control form-control-sm   ">
            </div></div>
            <!--telefono y celular-->
            <div class="row">
            <div class="col-12  col-sm-6 col-md-12     col-lg-12">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone fa-lg" aria-hidden="true"></i></span>
              </div> 
              <input oninput="phone_input(event)" maxlength="20" value="{{! isset($ficha0) ? '' : $ficha0->TELEFONO}}" name="TELEFONO" type="text" id="telefono" class="form-control form-control-sm   ">
          </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12    col-lg-12">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-mobile fa-lg" aria-hidden="true"></i></span>
              </div>  
              <input  oninput="phone_input(event)"  maxlength="20" value="{{! isset($ficha0) ? '' : $ficha0->CELULAR}}" name="CELULAR" type="text"   class="form-control form-control-sm   ">
          </div>
            </div>

            <div class="col-12 col-sm-6 col-md-12    col-lg-12">
            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-mobile fa-lg" aria-hidden="true"></i></span>
              </div>  
              <input  oninput="phone_input(event)" maxlength="20" value="{{! isset($ficha0) ? '' : $ficha0->CELULAR2}}" name="CELULAR2" type="text"   class="form-control form-control-sm   ">
          </div>
            </div>

            </div>
             <!--Telefono y celular-->
           
            
      

         

        </div><!--END PRIMERA COLUMNa-->

        <!-- SEGUNDA COLUMNA -->
        <div class="col-12 col-sm-6  col-md-12 col-lg-6">
            
           
          <p style="text-decoration: underline; text-align: center;">Datos laborales</p>
            <div class="row">
            <div class="col-3 col-sm-3"><label for="laboral">Lugar:</label></div>
            <div class="col-9 col-sm-9"><input maxlength="30" value="{{! isset($ficha0) ? '' : $ficha0->TRABAJO}}"  name="TRABAJO" type="text"   class="form-control form-control-sm   ">
            </div></div>

            <div class="row">
            <div class="col-12 col-sm-3 col-md-12 col-lg-12"><label for="laboral">Direccion:</label></div>
            <div class="col-12 col-sm-9 col-md-12  col-lg-12"><input maxlength="150" value="{{! isset($ficha0) ? '' : $ficha0->LABORAL}}"  name="LABORAL" type="text"   class="form-control form-control-sm   ">
            </div></div>


            <div class="input-group input-group-sm">
              <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone fa-lg" aria-hidden="true"></i></span>
              </div>
              <input  oninput="phone_input(event)" maxlength="21" value="{{! isset($ficha0) ? '' : $ficha0->TEL_TRABAJ}}" name="TEL_TRABAJ" type="text" id="tel_trabaj" class="form-control form-control-sm   ">
            </div>

             
        </div>   <!-- END SEGUNDA COLUMNA -->
        
      </div>
</div>


<div class="col-12 col-md-6 verde2"  >
<p style="text-decoration: underline;text-align: center;">Garante </p>
    <div class="row" >
      <!--TERCERA COLUMNA -->
      <div class="col-12 col-sm-6 col-md-12 col-lg-6">
          <div class="row">
          <div class="col-12 col-sm-3 col-lg-12 col-xl-3"><label for="garante">Nombres:</label></div>
          <div class="col-12 col-sm-9 col-lg-12 col-xl-9"><input maxlength="35" value="{{! isset($ficha0) ? '' : $ficha0->GARANTE}}"  name="GARANTE" type="text" id="garante" class="form-control form-control-sm   ">
          </div></div>
          <div class="row">
          <div class="col-2 col-sm-3"><label for="cigarante">CI°:</label></div>
          <div class="col-10 col-sm-9"><input maxlength="9" value="{{! isset($ficha0) ? '' : $ficha0->CI_GARANTE}}"  name="CI_GARANTE" type="text" id="cigarante" class="form-control form-control-sm   ">
          </div>  
        </div>
          <div class="row">
          <div class="col-12 col-sm-3 col-md-12 "> <label for="dgarante">Direccion:</label></div>
          <div class="col-12 col-sm-9 col-md-12"> <input maxlength="150" value="{{! isset($ficha0) ? '' : $ficha0->DOM_GARANT}}"  name="DOM_GARANT" type="text" id="dgarante" class="form-control form-control-sm   ">
          </div></div>
          <!--TELEFONO Y CELULAR-->
          <div class="row">
          <div class="col-12 col-sm-6  col-lg-12">
          <div class="input-group input-group-sm">
          <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone fa-lg" aria-hidden="true"></i></span>
          </div>
          <input  oninput="phone_input(event)"   maxlength="20" value="{{! isset($ficha0) ? '' : $ficha0->TEL_GARANT}}" name="TEL_GARANT" type="text" id="tgarante" class="form-control form-control-sm   ">
          </div>
          </div>
          <div class="col-12 col-sm-6   col-lg-12">
          <div class="input-group input-group-sm">
          <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1"><i class="fa fa-mobile fa-lg" aria-hidden="true"></i></span>
          </div>
          <input  oninput="phone_input(event)"  maxlength="20" value="{{! isset($ficha0) ? '' : $ficha0->CEL_GARANT}}" name="CEL_GARANT" type="text" id="tgarante" class="form-control form-control-sm   ">
          </div>
          </div>
          </div> <!--TELEFONO Y CELULAR-->

        

            

      </div><!--END TERCERA COL-->

<!--CUARTA COL-->
      <div class="col-12  col-sm-6 col-md-12 col-lg-6">
      
      <div class="row">
      <div class="col-12 col-sm-4"><label for="dlabogarante">Trabajo:</label></div>
      <div class="col-12 col-sm-8"><input maxlength="30" value="{{! isset($ficha0) ? '' : $ficha0->TRABAJO_G}}" name="TRABAJO_G" type="text"   class="form-control form-control-sm   ">
          </div></div>

          <div class="row">
             <div class="col-12 col-sm-4 col-md-12"><label for="dlabogarante">Dir.Laboral:</label></div>
             <div class="col-12 col-sm-8 col-md-12"><input maxlength="150" value="{{! isset($ficha0) ? '' : $ficha0->LABORAL_G}}" name="LABORAL_G" type="text"   class="form-control form-control-sm   ">
          </div></div>

          <div class="input-group input-group-sm">
              <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone fa-lg" aria-hidden="true"></i></span>
              </div>
              <input  oninput="phone_input(event)"  maxlength="20" value="{{! isset($ficha0) ? '' : $ficha0->TEL_LAB_G}}" name="TEL_LAB_G" type="text"   class="form-control form-control-sm   ">
        </div>

         
      </div>
     <!--CUARTA COL-->


    </div>
</div>
</div><!-- fin FILA UNO  -->



<!--contenedor panel 3 y 4-->
<div class="row">
<!--Inicio panel 3-->

<div class="col-12 col-sm-6 col-md-6 p-1 verde3"  >
<p style="text-decoration: underline; text-align: center;">3er Garante </p>

    <div class="row ">
    <div class="col-2 col-sm-3 col-lg-2 col-xl-2"> <label for="ctactecatas">Cedula:</label></div>
    <div class="col-10 col-sm-9 col-lg-3 col-xl-3">
        <input maxlength="8"  oninput="solo_numero(event)"  value="{{! isset($ficha0) ? '' : $ficha0->CI_GAR_3}}" name="CI_GAR_3" type="text" id="ctactecatas" class="form-control form-control-sm   ">
    </div>
    <div class="col-12 col-sm-3 col-lg-2 col-xl-2"><label for="ctactecatas">Nombres:</label></div>
    <div class="col-12 col-sm-9 col-lg-5 col-xl-5"><input maxlength="35" value="{{! isset($ficha0) ? '' : $ficha0->GARANTE_3}}" name="GARANTE_3" type="text" id="ctactecatas" class="form-control form-control-sm   ">
      </div>
  </div>

     


      <div class="row">
      <div class="col-12 col-sm-3 col-md-3 col-lg-2"><label for="ctactecatas">Domicilio:</label></div>
      <div class="col-12 col-sm-9 col-md-9 col-lg-10"><input maxlength="50" value="{{! isset($ficha0) ? '' : $ficha0->DIR_GAR_3}}" name="DIR_GAR_3" type="text" id="ctactecatas" class="form-control form-control-sm   ">
    </div></div>
<!--TELEFONO Y CELULAR -->
    <div class="row">
      <div class="col-12 col-sm-6 col-md-12 col-lg-6">
      <div class="input-group input-group-sm">
              <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone fa-lg" aria-hidden="true"></i></span>
              </div>
              <input  oninput="phone_input(event)"  maxlength="17" value="{{! isset($ficha0) ? '' : $ficha0->TEL_GAR_3}}" name="TEL_GAR_3" type="text" id="ctactecatas" class="form-control form-control-sm   ">
    </div>
      </div>
      <div class="col-12 col-sm-6 col-md-12  col-lg-6">
      <div class="input-group input-group-sm">
              <div class="input-group-prepend">
              <span class="input-group-text" id="basic-addon1"><i class="fa fa-mobile fa-lg" aria-hidden="true"></i></span>
              </div>
              <input  oninput="phone_input(event)"  maxlength="17" value="{{! isset($ficha0) ? '' : $ficha0->CEL_GAR_3}}" name="CEL_GAR_3" type="text" id="ctactecatas" class="form-control form-control-sm   ">
    </div>
      </div>
    </div><!--TELEFONO Y CELULAR -->


</div>
<!--end panel 3-->



<!--panel 4-->
<div class="col-12 col-sm-6 col-md-6 p-1 verde4"  >
   
    <div class="row">
    <div class="col-12 col-sm-4"><label for="actuaria">Domic. denunciado:</label></div>
    <div class="col-12 col-sm-8"><input name="DOC_DENUNC" maxlength="75"  type="text"   class="form-control form-control-sm" value="{{ !isset($ficha0)? '' : $ficha0->DOC_DENUNC}}">
    </div> </div> 
  

    <div class="row">
    <div class="col-3 col-sm-4"><label for="actuaria">Localidad:</label></div>
    <div class="col-9 col-sm-8"><select name="LOCALIDAD" class="form-control form-control-sm">
                    <?php 

                     $loc=  !isset($ficha0)? '' : $ficha0->LOCALIDAD;
                    foreach($localidades as $it): 
                         if( $loc == $it->DESCR || $loc == $it->IDNRO)//Ojo
                           echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                         else{
                              echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                         }
                         
                    endforeach;  ?>
             </select> </div>
         </div>

    

 
    <div class="row">
    <div class="col-12 col-sm-4"><label for="actuaria">Dom.denun. Gte:</label></div>
    <div class="col-12 col-sm-8"><input   maxlength="75" name="DOC_DEN_GA"  type="text"   class="form-control form-control-sm" value="{{ !isset($ficha0)? '' : $ficha0->DOC_DEN_GA}}">
         </div></div>

    <div class="row">
    <div class="col-12 col-sm-4"><label for="actuaria">Localidad del Gte.:</label></div>
    <div class="col-12 col-sm-8"><select name="LOCALIDA_G" class="form-control form-control-sm">
                    <?php 

                     $loc=  !isset($ficha0)? '' : $ficha0->LOCALIDA_G;
                    foreach($localidades as $it): 
                         if( $loc == $it->DESCR || $loc == $it->IDNRO)//Ojo
                           echo "<option selected value='{$it->IDNRO}'>{$it->DESCR}</option>"; 
                         else{
                              echo "<option value='{$it->IDNRO}'>{$it->DESCR}</option>";      
                         }
                         
                    endforeach;  ?>
             </select>  </div>
         </div>

  
   
</div>

</div><!--contenedor panel 3 y 4 -->

</form>
 
<script>

var operacSt= document.getElementById("operacion").value;
//Solo Lectura
if(    operacSt == "V")
habilitarCampos('form-person',false);



//aL REGISTRAR UN NUEVO DEMANDADO, SE VERIFICA LA EXISTENCIA  DEL NUMERO DE CEDULA REGISTRADO
//Si se trata de una operacion de Actualizacion, se pasa por alto el control
function existeCI( handler){

let ci= $("#form-person input[name=CI]").val();//Numero de cedula ingresado
let rta= "<?=url("existe-ci")?>/"+ci;  
$.ajax( {url: rta, success: (re)=>{
  let resp=jsonReceiveHandler(re);
  if( typeof resp != "boolean"){
      if( resp.existe == "s"){  
        if( $("#CI-DEFAULT").val()== $("#form-person input[name=CI]").val())
         handler();
         else alert("EL CI N° "+ci+" ya existe"); 
      }else{
        //permitir grabar
        handler();
      } 
  }  
  }    }  )
}/***End existe ci */




//Validacion
function campos_vacios(){
   if( $("#titular").val()=="") alert("INGRESE EL NOMBRE COMPLETO");
   if( $("#ci").val()=="") alert("INGRESE EL NUMERO DE CEDULA");
   return  ($("#titular").val()==""  ||   $("#ci").val()=="");
 }



//Tras crear el registro de demandado
//Se habilitan los formularios de demanda, seguimiento,observacion, y otros
 function habilitarFormJudiciales(){
              habilitarCampos("formDeman",true);  
               habilitarCampos("formNoti",true); 
               habilitarCampos("formObser",true);
               habilitarCampos("formContra",true);
               habilitarCampos("formExtrajudi",true);
               habilitarCampos("formHonorarios",true);
}



//Distribuir la clave de id_demanda entre los formularios
//TRAS haber registrado al demandado
function distribuirClavesGene( id_demanda, cedula){

  $("#formDeman input[name=IDNRO],#formNoti input[name=IDNRO],#formObser input[name=IDNRO],#formContra input[name=IDNRO],#formExtrajudi input[name=IDNRO],#formHonorarios input[name=IDNRO]").val(id_demanda);
//Asignacion de clave a Demanda,Seguimiento,Observacion,Contraparte,Arreglo Extraj.
//Asignar el numero de cedula
$("input[name=CI]").val(  cedula); 
}




function enviarDatosPerso( ev){ 

 
 ev.preventDefault(); 

 if( campos_vacios() ) return;

 let handler= function(){ 
   let divname= "#persona-panel";
   let success= function( resp ){
   let res= jsonReceiveHandler( resp, divname);
   if( typeof res != "boolean" ){
               formEnviado= true;
               
               //Mostrar mensaje 
               $(divname).html(  ""  ); //mensaje 
               $("#pers-msg").text( "GUARDADO!");
               $(".toast").toast("show"); 
               //CONVERTIR A FORM DE EDICION
               if( "IDNRO" in res){
                  //obtener vista de edicion
                  $.get("<?=url("edemandado")?>/"+res.IDNRO, function(vista){  $("#persona-collapse").html( vista);}  );
                
               }
               //Asignar ID DE DEMANDA si existe
               if( "id_demanda" in res) 
               distribuirClavesGene( res.id_demanda, res.ci );
               //HABILITAR FORMULARIOS RESTANTES
               habilitarFormJudiciales();
               //Cambiar form de edicion
               if(  $("#operacion")=="A"){
                show_edit_demandado_form(  res.IDNRO);
                $("#operacion").val("M");
               }

   }
};
ajaxCall(ev, divname, success);  }   ;//end handler

existeCI(  handler) ;
}/** */


function   show_edit_demandado_form(  id_demandado){

$.ajax(  {
url: "<?=url("edemandado")?>"+"/"+id_demandado,
beforeSend: function(){
          $("#persona-collapse").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
          
     },
success: function(  form){
    
     $("#persona-collapse").html( form ); 
     $("#dema-msg").text( "GUARDADO!");$(".toast").toast("show"); 
}, 
error: function(){ 
          $("#persona-collapse").html(  "" );
          alert("Problemas de conexión"); 
          }

});
}

</script>
