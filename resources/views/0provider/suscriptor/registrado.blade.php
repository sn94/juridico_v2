<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Registrado</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">


      
            <?php

            use App\Mobile_Detect;
            $det=  new Mobile_Detect();
            ?>

            @if( $det->isMobile())

            <style>
                    #mensaje{
                    margin-left: 3px;
                    margin-right: 3px;
                    background-color: #6cfd74;
                    padding: 10px;

                }

            </style>
            @else
            <style>
                    #mensaje{
                    margin-top: 10%;
                    margin-left: 30%;
                    margin-right: 30%;
                    background-color: #6cfd74;
                    padding: 20px;
                }
            </style>
            @endif

            <style>
                p{
                    font-weight: 600;
                    color: #111100;
                    
                }
            </style>
        
        
    </head>
    <body style="background-image: url(<?=url("assets/img/acuerdo.jpg")?>); background-repeat: no-repeat; background-size: cover; font-family: Verdana, Geneva, Tahoma, sans-serif;">
      



        <div id="mensaje" >
    
            <h3 style="color: #093401;">Gracias por registrarse</h3>
            <p>Una vez aprobada su solicitud, recibirá un email con sus credenciales para acceder al servicio</p>
            <p>(Si no encuentra el email en el buzón de entrada, es probable que se encuentre en la bandeja de correo no deseado - spam)</p>
            <a  style="text-decoration: none; font-weight: 600;" href="http://legalex.com.py">Ir a Legalex.com</a>
        </div>

        
        <script src="" async defer></script>
    </body>
</html>