@extends('layouts.recovery_password')

 

@section('contenido')
 

 

                <form method="post" class="login100-form validate-form"  action="<?=url("recovery-password")?>" >
				@csrf
				<p>
					Ingrese su usuario y la dirección de correo electrónico con la cual usted se ha registrado. Le enviaremos un enlace para la 
					recuperación del acceso
				</p>

				<div class="wrap-input100 validate-input m-b-26" data-validate="Nick requerido!">
						<span class="label-input100">Usuario:</span>
						<input  id="nick" onblur="emptyInputControl(event)"  oninput="emptyInputControl(event)"  class="input100" type="text" name="NICK" >
						<span class="focus-input100"></span>
					</div> 
 

					<div class="wrap-input100 validate-input m-b-26" data-validate="Direccion de correo electronico requerida!">
						<span class="label-input100">Correo electrónico:</span>
						<input  id="email" onblur="emptyInputControl(event)" oninput="emptyInputControl(event)"   class="input100" type="text" name="EMAIL" placeholder="El e-mail debe ser el mismo con el cual se ha registrado">
						<span class="focus-input100"></span>
					</div> 
 

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Reestablecer password
						</button>
					</div>
					{{  isset($MENSAJE)  ?  $MENSAJE :  '' }}
				</form>
		


<script>



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