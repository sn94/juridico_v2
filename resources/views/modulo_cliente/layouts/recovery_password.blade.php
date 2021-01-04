<!DOCTYPE html>
<html lang="en">
<head>
	<title>Recuperacion de password </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=url("login/vendor/bootstrap/css/bootstrap.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=url("login/fonts/font-awesome-4.7.0/css/font-awesome.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=url("login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=url("login/vendor/animate/animate.css")?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=url("login/vendor/css-hamburgers/hamburgers.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=url("login/vendor/animsition/css/animsition.min.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=url("login/vendor/select2/select2.min.css")?>">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="<?=url("login/vendor/daterangepicker/daterangepicker.css")?>">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=url("login/css/util.css")?>">
	<link rel="stylesheet" type="text/css" href="<?=url("login/css/main.css")?>">
<!--===============================================================================================-->
</head>
<body >
	
	<div class="limiter" >
		<div class="container-login100" style="background-color: black !important;">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(<?=url("login/images/bg-01.jpg")?>);">
					<span class="login100-form-title-1">
						Olvido de contraseña
					</span>
				</div>

				@yield('contenido')

                
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="<?=url("login/vendor/jquery/jquery-3.2.1.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=url("login/vendor/animsition/js/animsition.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=url("login/vendor/bootstrap/js/popper.js")?>"></script>
	<script src="<?=url("login/vendor/bootstrap/js/bootstrap.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=url("login/vendor/select2/select2.min.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=url("login/vendor/daterangepicker/moment.min.js")?>"></script>
	<script src="<?=url("login/vendor/daterangepicker/daterangepicker.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=url("login/vendor/countdowntime/countdowntime.js")?>"></script>
<!--===============================================================================================-->
	<script src="<?=url("login/js/main.js")?>"></script>

</body>
</html>