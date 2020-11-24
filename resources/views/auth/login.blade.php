@extends('layouts.login')

 

@section('contenido')
 

 

                <form  onsubmit="validarLogin(event)" method="post" class="login100-form validate-form"  action="<?=url("signin")?>" >
                @csrf
					<div class="wrap-input100 validate-input m-b-26" data-validate="Nombre de usuario requerido!">
						<span class="label-input100">Usuario:</span>
						<input id="nick"  value="{{ isset($nick)? $nick: '' }}" class="input100" type="text" name="nick" placeholder="nombre de usuario">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Se requiere el password!">
						<span class="label-input100">Password</span>
						<input   class="input100" type="password" name="pass" placeholder="su password">
						<span class="focus-input100"></span>
					</div>

					<?php if( isset( $errorSesion) ): ?>
					<div class="alert alert-danger">
						{{$errorSesion}}
					</div>
				<?php  endif; ?>
	   
					<div class="flex-sb-m w-full p-b-30">
						<div class="contact100-form-checkbox">
							<a style="font-weight: 600; text-decoration: none; font-family: Verdana, Geneva, Tahoma, sans-serif;" href="<?=url("suscripcion")?>">REGISTRARME</a>
						</div>

						<div>
							<a href="<?=url("recovery-password")?>" class="txt1">
								Olvidaste tu contraseña?
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Entrar
						</button>
					</div>
				</form>
		


				<script>


				async	function  validarLogin(ev){
						ev.preventDefault();
						let nick= document.getElementById("nick").value;
						let resp= await fetch("<?=url("usuario-existe")?>/"+nick );
						let resjson= await  resp.json();
						if( "error"  in   resjson){
							alert(  resjson.error);
						}
						else ev.target.submit();

					}
				</script>
				 
@endsection 