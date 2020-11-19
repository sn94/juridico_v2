
<?php

$ruta_form=   $OPERACION == "A" ?  url("abogados/create")  :  url("abogados/edit".(  isset($DATO)? "/".$DATO->IDNRO : "" ) );
?>


 <style>
     
     input.form-control{
         font-weight: 600;
     }
     input.form-control::placeholder{
        color: #020022;
        font-weight: 600;
    }


 </style>

<div id="formstatus"></div>

<form onsubmit="enviar( event )" action="<?=$ruta_form?>" method="POST"> 
    
@csrf 

@if( $OPERACION == "M")
<input type="hidden" name="IDNRO"  value="{{ (isset($DATO))?$DATO->IDNRO : ''}}">
@endif 

<div class="input-group">
<input id="CEDULA"  oninput="solo_numero_mas_formato(event)" class="form-control mb-1 form-control-sm mb-1" value="{{isset($DATO)?$DATO->CEDULA: ''}}"  maxlength="9" class="input--style-1" type="text" placeholder="Cédula" name="CEDULA">
</div>


<div class="input-group">
<input id="NOMBRE"  class="form-control mb-1 form-control-sm mb-1" value="{{isset($DATO)?$DATO->NOMBRE: ''}}" maxlength="60" class="input--style-1" type="text" placeholder="Nombres" name="NOMBRE">
</div>

<div class="input-group">
<input id="APELLIDO"  class="form-control mb-1 form-control-sm  mb-1"  value="{{isset($DATO)?$DATO->APELLIDO: ''}}" maxlength="60" class="input--style-1" type="text" placeholder="Apellidos" name="APELLIDO">
</div>

<div class="input-group">
<input  id="EMAIL" class="form-control mb-1 form-control-sm mb-1" value="{{isset($DATO)?$DATO->EMAIL: ''}}"  maxlength="60" class="input--style-1" type="text" placeholder="E-mail" name="EMAIL">
</div>
						
						
<div class="input-group">
<input  class="form-control mb-1 form-control-sm mb-1" value="{{isset($DATO)?$DATO->TELEFONO: ''}}" oninput="phone_input(event)" maxlength="20" class="input--style-1" type="text" placeholder="Teléfono" name="TELEFONO">
</div>


<div class="input-group">
<input  class="form-control mb-1 form-control-sm mb-1" value="{{isset($DATO)?$DATO->CELULAR: ''}}" oninput="phone_input(event)" maxlength="20" class="input--style-1" type="text" placeholder="Celular" name="CELULAR">
</div>
                        
 
<div class="p-t-20">
<button id="btnGUARDAR" class="mt-2 btn btn-primary btn-sm btn--radius btn--green" type="submit">Guardar</button>
</div>


</form>

<script>

function solo_numero_mas_formato(ev){
   
   if(  ev.data == undefined  ||  ev.data == null)  return;
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart ); 
    } 
    let val_Act= ev.target.value;  
  val_Act= val_Act.replaceAll( new RegExp(/[\.]*[,]*/), ""); 
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		$( ev.target).val(  enpuntos);
	} 




    function phone_input(ev){
     if( ev.data == null) return;
     
    if( (ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57)  && ev.data.charCodeAt()!= 32   ){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + " "
      ev.target.value.substr( ev.target.selectionStart );
    }  }

    

async    function enviar(ev){
        ev.preventDefault();

        //CAMPOS VACIOS
      if( $("#CEDULA").val()==""  ||  $("#NOMBRE").val()==""  ||  $("#APELLIDO").val()=="" ||  $("#EMAIL").val()=="")
      {
        alert(" POR FAVOR COMPLETAR LOS CAMPOS VACIOS"); return;  
      }


        $( "#formstatus").html(  "<div  style='z-index:10000; position: absolute; left: 45%;'   class='spinner mx-auto'><div class='spinner-bar'></div></div>" );

        let config= { method: 'POST',  body: $(ev.target).serialize(), headers: { 'Content-Type':'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }  } ;
        let res= ev.target.action;
        let resp_en_br= await fetch(  res, config);
        let resp_json= await resp_en_br.json();
        if( "idnro" in resp_json ){      
            $("#formstatus").html(    "" );
            $("#modal-form").modal("hide");
            if( "act_grilla" in window )  act_grilla();

        }  else{   $("#formstatus").html( "" ); alert( respuesta1.error); }
    }


</script>