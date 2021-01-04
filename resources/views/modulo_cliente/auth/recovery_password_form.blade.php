@extends('layouts.recovery_password')

 

@section('contenido')
 

 

                <form onsubmit="validar(event)" method="post" class="login100-form validate-form"  action="<?=url("reset-password")?>" >
				@csrf
				<p>
					Por favor digite su nueva contraseña. Se recomienda combinar caracteres alfanuméricos (en minúsculas y mayúsculas) con caracteres especiales (por ejemplo: $#%&/()?¡ ) para una contraseña más segura
				</p>

				<input type="hidden" name="USUARIO"  value="{{$USUARIO}}">

				<div class="wrap-input100 validate-input m-b-26" data-validate="falta el Password!">
						<span class="label-input100">Contraseña nueva:</span>
						<input  id="pass1" onblur="emptyInputControl(event)"  oninput="emptyInputControl(event)"  class="input100" type="password" name="PASS1" >
						<span class="focus-input100"></span>
					</div> 
 

					<div class="wrap-input100 validate-input m-b-26" data-validate="Por favor reingrese el password!">
						<span class="label-input100">Repetir:</span>
						<input  id="pass2" onblur="emptyInputControl(event)"  oninput="emptyInputControl(event)"  class="input100" type="password"   >
						<span class="focus-input100"></span>
					</div> 
					 
 

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Reestablecer password
						</button>
					</div>
					 <?= isset($MENSAJE)  ?  $MENSAJE :  '' ?>
				</form>
		


<script>



function validar(ev){
	ev.preventDefault();
	if( $("#pass1").val()   ==   $("#pass2").val()  )  ev.currentTarget.submit();
	else alert("Las contraseñas deben coincidir");
}

function emptyInputControl( ev){
	let target_=  ("target" in ev) ?  ev.target :  ev;
	let value_=  ("target" in ev) ?  ev.target.value:  ev.value;
  if(  value_ == "")
$(target_).css("border", "#ff0000 solid 1px");
else 
$( target_).css("border", "1px solid #d1d3e2");
}



	function recovery_password(  ev){

		ev.preventDefault();

		if(  $("#nick").val() == ""){   emptyInputControl( document.getElementById("nick") ); return}
		if(  $("#email").val() == ""){   emptyInputControl( document.getElementById("email") ); return}
	}


</script>
				 
@endsection 