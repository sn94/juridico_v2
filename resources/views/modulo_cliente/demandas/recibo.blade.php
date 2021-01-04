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
 
@media print{
   

    body{
       
        margin-top: 1cm;
        print-color-adjust: exact;
        color-adjust: exact; 
     color: #404040;
     font-family: Arial, Helvetica, sans-serif;
 }

#cabecera, #cuerpo, #container{
            width: 200pt;
}
 
#container{
    border: 1mm solid #a3a3a3;
    
}
#boton{
    display: none;
}
}


 
@page 
    {
        size:  auto;   /* auto es el valor inicial */ 
        margin: 0mm;  /* afecta el margen en la configuración de impresión */
        margin-left: 1cm;
        margin-right: 1cm;
    }

 
 body{
    margin-top: 1cm;
     color: #404040;
     font-family: Arial, Helvetica, sans-serif;
 }

#cabecera, #cuerpo, #container{
            width: 21cm;
}

#container{
    padding-top: 10px;
    border: 1mm solid #a3a3a3;
  
}
        </style>
    </head>
    <body >

@if( isset( $EDICION) )
<div id="boton">
    <button style="font-weight: 600; background-color: #252525;color:wheat;margin-bottom: .5cm;" type="button" onclick="imprimir_recibo()">IMPRIMIR</button>
</div>
@endif 

<div id="container">

          
    <div id="cabecera">
   <table style="width: 21cm;">
       <tr ><td style="padding:0px;margin:0px;"><h2 style="margin:0px;">RECIBO N° {{$NRORECIBO}} </h2></td>
       <td style="width: 150px;"></td>
       <td style="background-color: #d2d2d2;  font-size: 20px;" > G. {{ Helper::number_f($IMPORTE)}} </td></tr>
   </table>

    </div>

    <div id="cuerpo">
    <p style="text-align: right;">{{$fechaletras}}</p>
        <p>Recibí(mos) de <span style="background-color: #d2d2d2;   font-size: 14px;text-align: right;padding-left:15px;padding-right:15px;">{{$DEMANDADO}}</span> </p>
        <p>la cantidad de guaraníes <span style="background-color: #d2d2d2;  font-size: 14px;padding-left:15px;padding-right:15px;">{{ $IMPORTEL}}</span> </p>
      <form action="<?=url("arregloextr-recibo")?>" method="post"  >
      <input id="IDRECIBO" type="hidden" name="IDNRO" value="{{$NRORECIBO}}">

      <p>por concepto de 
    <input maxlength="100" id="CONCEPTO" {{ isset( $EDICION) ? ($EDICION ? '' : 'readonly'): ''}} tabindex="0" style="background-color: #d2d2d2;   font-size: 14px;padding-left:15px;padding-right:15px; width: 15cm;border: none;" type="text" name="CONCEPTO" value="{{$CONCEPTO}}" >   </p>
      
    </form>
       
    </div>
    <table style="width: 21cm;">
       <tr ><td> </td>
       <td style="width: 15cm;"></td>
       <td style=" border-top: 1px solid #070707; font-size: 14px; ">Firma y aclaración</td></tr>
   </table>


            </div>

    <script>

async function imprimir_recibo(){
  
    let ID_RECIBO= document.getElementById("IDRECIBO").value;
    let CONCEPTO= document.getElementById("CONCEPTO").value;

    let DATOS= {"CONCEPTO": CONCEPTO, "IDNRO": ID_RECIBO };

    let urlBill= "<?=url("arregloextr-recibo")?>";
    let respuesta= await fetch( urlBill, {
    method: 'POST',
    headers: {'Content-type':'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
     body: JSON.stringify(  DATOS) }  );
    let html="";
    if( respuesta.ok)  html=  await respuesta.text();
    //RESPUESTA
    console.log(  html);
    let mensaje= JSON.parse(  html);
    if(  "ok" in mensaje){ printBill(); }
}

function printBill( ){
 
window.document.close(); 
  window.focus();
window.print();
window.close();
return true;
}


    </script>
    </body>
</html> 