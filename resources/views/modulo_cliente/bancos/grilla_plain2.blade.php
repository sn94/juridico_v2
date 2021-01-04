
 
<?php

use App\Helpers\Helper; 

 
?>

<style> 
  tr{
    background: #a3c5fc !important;
  }
</style>

<table id="ctabancos">
        <thead  >
            <tr>
              <th style="width:150px;">TITULAR</th>
              <th class="text-right">BANCO</th>
              <th class="text-right">CUENTA</th>
            <th class="text-right">DEPÓSITO</th> 
            <th class="text-right">EXTRACCIÓN</th> 
            <th class="text-right" >FECHA</th> 
          
          </tr>
        </thead>
        <tbody>
          <!--CADA CTA TENDRA ALGUN DEPOSITO, EXTRACCION O EXTRACCION POR PROYECTO-->
          <?php  foreach( $movi as $it):?>
            <tr  >
            <td style="width:150px;">{{$it->TITULAR}}</td>
              <td  class="text-right pt-1 mr-1 ml-1 mb-0" > {{$it->BANCO}} </td>
              <td  class="text-right pt-1 mr-1 ml-1 mb-0">{{ $it->CUENTA }} </td>
              <td class="text-right pt-1 mr-1 ml-1 mb-0" > {{Helper::number_f($it->DEPOSITO)}} </td>
              <td class="text-right pt-1 mr-1 ml-1 mb-0" > {{ Helper::number_f( $it->EXTRACCION ) }} </td>
              <td class="text-right pt-1 mr-1 ml-1 mb-0" > {{Helper::beautyDate($it->FECHA)}} </td>
            </tr>
<!-- class="text-right pt-1 mr-1 ml-1 mb-0"-->
          <?php  endforeach; ?>
        </tbody>
    </table> 