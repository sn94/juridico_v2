<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= url("app.css") ?>" rel="stylesheet">
    <style>
    
    .alert{
    margin: 0 auto;
    width: 350px;
    background-color: #b5f9a4;
 
    border: 10px solid #62f25e;
    border-radius: 20px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    padding: 4px 4px;
    }

    a{
    display: block;
    margin: 0 auto;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-weight: 600;
    }

    </style>
  </head>
  <body style="background-color: black;">
   
    
    
      

<div class="alert alert-sucess">

<h4>E-mail enviado</h4>

<i class="fa fa-check-circle"></i>
Se ha enviado un enlace a <span style="font-weight: 600; color: #040053;"> {{$EMAIL}}</span>


 
<a href="http://www.legalex.com">Ir a Legalex</a>
</div>









  </body>
</html>