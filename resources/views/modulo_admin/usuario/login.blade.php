@extends('modulo_admin.layouts.login')



@section('contenido')

<style>
	.login100-form-title {
		background-color: red;

	}
</style>



<input type="hidden"  id="admin_index"   value="{{url('admin/welcome')}}">
<form onsubmit="login(event)" method="post" class="login100-form validate-form" action="<?= url("admin/sign-in") ?>">
	@csrf
	<div class="wrap-input100 validate-input m-b-26" data-validate="Nombre de usuario requerido!">
		<span class="label-input100">Usuario:</span>
		<input class="input100" type="text" name="NICK" placeholder="nombre de usuario">
		<span class="focus-input100"></span>
	</div>

	<div class="wrap-input100 validate-input m-b-18" data-validate="Se requiere el password!">
		<span class="label-input100">Password</span>
		<input class="input100" type="password" name="PASS" placeholder="su password">
		<span class="focus-input100"></span>
	</div>

	<?php if (isset($errorSesion)) : ?>
		<div class="alert alert-danger">
			{{$errorSesion}}
		</div>
	<?php endif; ?>

	<div class="flex-sb-m w-full p-b-30">
		<div class="contact100-form-checkbox">
			<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
			<label class="label-checkbox100" for="ckb1">
				Remember me
			</label>
		</div>

		<div>
			<a href="#" class="txt1">
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
	async function login(ev) {

		ev.preventDefault();

		if(  $("input[name=NICK]").val()  ==  ""  ||    $("input[name=PASS]").val()==""  )  return;
		let headers = {
			'Content-Type': 'application/x-www-form-urlencoded',
			'X-CRSF-TOKEN': $("input[name=_token]").val()
		};

		let config = {
			method: "POST",
			headers: headers,
			body: $(ev.target).serialize()
		}
		let req = await fetch(ev.target.action, config);

		let resp =  await req.json();
		if(  "ok"  in resp  )
		window.location=  $("#admin_index").val();
		else 
		alert(  resp.error);

	}
</script>
@endsection