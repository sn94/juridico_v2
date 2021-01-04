 <div class="container bg-dark text-light">  
  
      
        @csrf
        <label for="" id="nameLabel" style="display:block;width:100%;z-index:0;">Usuario:</label>
        <input onblur="controlUserName(event)"  oninput="controlUserName(event)" type="text" id="name" class="form-control form-control-sm" name="NICK" value="{{isset($DATO)? $DATO->NICK : '' }}" spellcheck="false">
        <label  for="" id="emailLabel" style="display:block;width:100%;z-index:2;">Email:</label>
        <input onblur="emptyInputControl(event)"  oninput="emptyInputControl(event)" type="text" id="email" class="form-control form-control-sm" value="{{isset($DATO)? $DATO->EMAIL : '' }}"  style="display:block;width: 100%;height:28px;z-index:3;" name="EMAIL" value="" spellcheck="false">
       
       
        @if(  isset($OPERACION)   &&  $OPERACION == 'M')
       <input type="checkbox"  onchange="habilitarInputPass(event)" >Editar password
       @endif 
        <label for="" id="passLabel" style="display:block;width:100%;z-index:2;">Password:</label>

        @php 
        $habilita_pass=  isset($OPERACION) ? ($OPERACION =='M' ? 'disabled' : '' ) : '';
        @endphp

        <input  {{$habilita_pass}}     onblur="emptyInputControl(event)"  oninput="emptyInputControl(event)" type="password" id="pass" class="form-control form-control-sm" style="display:block;width: 100%;height:28px;z-index:3;" name="PASS" value="" spellcheck="false">
       
        <input class="btn btn-primary mt-1" type="submit" id="submitButton" name="" value="Guardar"  >
     
 </div>



<script>




function  habilitarInputPass( ev){
$("#pass").attr("disabled",   ! (ev.currentTarget.checked) );
}


//Sin espacios
function controlUserName( ev){
if( ev.data != undefined  && ev.data!= null){
   if(  ev.data.charCodeAt() == 32){
    ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart ); 
   }
}
emptyInputControl(  ev );
}

function emptyInputControl( ev){
  if( ev.target.value == "")
$(ev.target).css("border", "#ff0000 solid 1px");
else 
$( ev.target).css("border", "1px solid #d1d3e2");
}

 


async function crear_usuario( ev){
  ev.preventDefault();

  if(  $("#name").val() == "") {$("#name").css("border", "#ff0000 solid 1px"); return; }
  if(  $("#email").val() == "") {$("#email").css("border", "#ff0000 solid 1px"); return; }
  if( !($("#pass").attr("disabled"))  &&  $("#pass").val() == "") {$("#pass").css("border", "#ff0000 solid 1px"); return; }


  /**Nick ya existente */
  let operacionTipo=  $("#OPERACION").val();
 // let peticionusunick= await fetch( "<?=url("p/existe-provider")?>/"+ $("#name").val()+ "/"+operacionTipo );
  //let respuestausunick= await peticionusunick.json();
  //if(  "SI" in respuestausunick ){  alert("Este nombre de usuario ya existe"); return; }
//***************************** */

//Creando cliente
//*************************** */
    $( "#formstatus").html(  "<div  style='z-index:10000; position: absolute; left: 45%;'   class='spinner mx-auto'><div class='spinner-bar'></div></div>" );
    let config= { method: 'POST',  
    body: $(ev.target).serialize(), 
    headers: { 'Content-Type':'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }  } ;
     
    let peticion1= await fetch( ev.target.action,  config );
    let respuesta1= await peticion1.json();
    $("#showform").modal("hide");
    if( "idnro" in respuesta1 ) {  $("#formstatus").html(  "" ); actualizarGrilla();}
    else      $("#formstatus").html(  "Error" );

    
}


 
async function actualizarGrilla(){
  $( "#grilla-usuarios").html(  "<div  style='z-index:10000; position: absolute; left: 45%;'  class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       
 let response_= await fetch(  "<?=url("p/usuarios")?>", { headers: {"X-Requested-With": "XMLHttpRequest"} } );
let responseData= await response_.text();

$( "#grilla-usuarios").html(  responseData);  

}

 

 


</script> 