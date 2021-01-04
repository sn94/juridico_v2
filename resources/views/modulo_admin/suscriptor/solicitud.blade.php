<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>suscripcion</title>

    <!-- Icons font CSS-->
    <link href="<?=url("suscripcion-form")?>/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="<?=url("suscripcion-form")?>/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="<?=url("suscripcion-form")?>/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?=url("suscripcion-form")?>/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
	<link href="<?=url("suscripcion-form")?>/css/main.css" rel="stylesheet" media="all">
	
	<style>

.bg-blue{
	background-color: black;
}
.card-1 .card-heading{
	background-image: url(<?=url("assets/img/lawyer.jpg")?>);
}

.p-t-100{
	padding: 10px;
}

	s:hover{
	
	font-size: 25px;
	color: yellow;
}
	</style>
</head>

<body>


<div id="viewplanes" style="position: fixed; z-index: -1; background-color: #030121; height: 100%; width: 100%; padding-top: 10px;">
<a id="buttonplan" onclick="ocultarPlanes()" href="#" style="text-decoration:none; background-color: red; font-size: 18px; color: white; font-weight: 600; border-radius: 25px;  padding: 4px 8px;"> Cerrar</a>
@foreach($planes as $plan )

<div style=" font-size: 20px; color: white; border: 1px solid #7c7cfc; margin-top: 20px; margin-left: 20px; margin-right:  20px; margin-bottom:  20px;">
	<p> {{$plan->DESCR}}</p>
	<p>Precio:  {{$plan->PRECIO}}</p>
	<p>N° máximo de usuarios:  {{$plan->MAX_USERS}}</p>
</div>

@endforeach
 
</div>


    <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
					<h2 class="title">Registro</h2>
					<a  style="display:block; text-align: right; font-weight: 600; text-decoration: none; font-family: Verdana, Geneva, Tahoma, sans-serif;"  href="<?=url("/signin")?>">YA TENGO UNA CUENTA</a>
					<form method="post" action="<?= url("suscripcion")?>">
					@csrf
              
                    @include("modulo_admin.suscriptor.form")
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="<?=url("suscripcion-form")?>/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="<?=url("suscripcion-form")?>/vendor/select2/select2.min.js"></script>
    <script src="<?=url("suscripcion-form")?>/vendor/datepicker/moment.min.js"></script>
    <script src="<?=url("suscripcion-form")?>/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="<?=url("suscripcion-form")?>/js/global.js"></script>



	<script>

function phone_input(ev){
     if( ev.data == null) return;
     
    if( (ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57)  && ev.data.charCodeAt()!= 32   ){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + " "
      ev.target.value.substr( ev.target.selectionStart );
    }  }




function  mostrarPlanes(){
	let planes= document.getElementById("viewplanes");
	planes.style.zIndex= 1000000000;
}


function  ocultarPlanes(){
	let planes= document.getElementById("viewplanes");
	planes.style.zIndex= -1;
}


	</script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->
