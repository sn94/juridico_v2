<?php

use App\Helpers\Helper;

?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
        @page {
            size: auto;
            /* auto es el valor inicial */
            margin: 0mm;
            /* afecta el margen en la configuración de impresión */
            margin-left: 1cm;
            margin-right: 1cm;
        }


        body {
            margin-top: 1cm;
            color: #404040;
            font-family: Arial, Helvetica, sans-serif;
        }

        #cabecera,
        #cuerpo,
        #container {
            width: 21cm;
        }

        #container {
            padding-top: 10px;
            border: 1mm solid #a3a3a3;

        }
        input::placeholder{
            color: #444 !important;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div id="email-panel" class=" p-3">

        <h4 >Enviar por email</h4>
        <form onsubmit="envioMail(event)" action="<?= url("recibos-free/mailto") ?>" method="POST">
            @csrf
            <input class="form-control mb-1" name="NRORECIBO" type="hidden" value="{{$NRORECIBO}}">
            <input class="form-control mb-1" placeholder="ASUNTO" type="text"  id="ASUNTO" name="ASUNTO">
            <input class="form-control mb-1" placeholder="NOMBRE DEL REMITENTE" type="text" id="REMITENTE" name="REMITENTE">
            <input class="form-control mb-1" placeholder="DESTINATARIO" type="text" id="DESTINATARIO" name="DESTINATARIO">
            <button class="btn btn-primary" type="submit">Enviar</button>
        </form>

    </div>



    <script>
        async function envioMail(ev) {
            ev.preventDefault();

            if( $("#ASUNTO").val()=="" || $("#REMITENTE").val()==""  || $("#DESTINATARIO").val()=="" ){
                alert("Por favor llene todos los campos");  return; 
            }
            let action = ev.target.action;
            let data = $(ev.target).serialize();
            $("#viewform").html('<img style="width: 100%; height: 100%;"  src="<?=url("assets/img/mail.gif")?>" />');
            let req = await fetch(action, {
                body: data,
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': $("input[name=_token]").val(),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            let resp = await req.json();
            if ("ok" in resp) {
                $("#viewform").html("<div class='alert alert-success'><h1>" + resp.ok + "</h1></div>");
            } else {
                $("#viewform").html("<div class='alert alert-danger'><h1>" + resp.error + "</h1></div>")
            }
        }
    </script>

</body>

</html>