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
    <link rel="stylesheet" href="">
    <style>
      tr{
        font-size: 11px;;
      }
    </style>
  </head>
  <body>
    
    
  <?php

use App\Helpers\Helper; 
?>

 <style></style>

<table class="table  table-sm table-bordered  table-striped" >
        <thead class="thead-dark">
            <tr> <th>CI</th><th>TITULAR</th><th class="text-right" >DEMANDA</th><th>DEMANDANTE</th>
             <th >COD. EMP</th><th>TIPO ARREG.</th><th>TOTAL</th><th>CUOTAS</th><th>CUO.PAGADAS</th> </tr>
        </thead>
        <tbody>
          <!--CADA CTA TENDRA ALGUN DEPOSITO, EXTRACCION O EXTRACCION POR PROYECTO-->
          <?php  foreach( $lista as $it):?>
            <tr style="font-size: 9pt;">
                
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">  {{ $it->CI }}  </td>
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->TITULAR}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->DEMANDA}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->DEMANDANTE}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->COD_EMP}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->TIPO}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{ Helper::number_f($it->TOTAL)}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->CUOTAS}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{  $it->PAGADAS }}</p></td> 
            </tr>

          <?php  endforeach; ?>
        </tbody>
    </table> 
 
 
   

  </body>
</html>