
 
<?php

use App\Helpers\Helper; 

 
?>

<style> 
  tr{
    background: #a3c5fc !important;
  }
</style>

<table id="ctabancos" class="table  table-sm table-bordered table-responsive table-striped">
        <thead class="thead-dark">
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
          <?php  
          
          $DEPOTOTAL=0; $EXTRTOTAL= 0;

          foreach( $movi as $it):
          
            $DEPOTOTAL+=  intval( $it->DEPOSITO );
            $EXTRTOTAL+=  intval( $it->EXTRACCION );
          
          ?>
            <tr  >
            <td style="width:150px;">{{  $it->TITULAR}}</td>
              <td  class="text-right pt-1 mr-1 ml-1 mb-0" > {{$it->BANCO}} </td>
              <td  class="text-right pt-1 mr-1 ml-1 mb-0">{{ $it->CUENTA }} </td>
              <td class="text-right pt-1 mr-1 ml-1 mb-0" > {{Helper::number_f($it->DEPOSITO)}} </td>
              <td class="text-right pt-1 mr-1 ml-1 mb-0" > {{ Helper::number_f( $it->EXTRACCION ) }} </td>
              <td class="text-right pt-1 mr-1 ml-1 mb-0" > {{Helper::beautyDate($it->FECHA)}} </td>
            </tr>
<!-- class="text-right pt-1 mr-1 ml-1 mb-0"-->
          <?php  endforeach;
          
          
          //saldo
          $SALDO=  $DEPOTOTAL -  $EXTRTOTAL;
          ?>

          <!--TOTALES -->


          <tr style="font-size: 14px;">
            <td style="width:150px;font-weight: 600;" > SUMAS Y SALDOS</td>
              <td  class="text-right pt-1 mr-1 ml-1 mb-0" ></td>
              <td  class="text-right pt-1 mr-1 ml-1 mb-0"></td>
              <td class="text-right pt-1 mr-1 ml-1 mb-0" > {{  Helper::number_f( $DEPOTOTAL) }} </td>
              <td class="text-right pt-1 mr-1 ml-1 mb-0" >(-) {{ Helper::number_f( $EXTRTOTAL ) }} </td>

              @if( $SALDO < 0):
              <td class="text-right pt-1 mr-1 ml-1 mb-0" style='color:red;' >{{  Helper::number_f($SALDO) }} </td>
              @else
              <td class="text-right pt-1 mr-1 ml-1 mb-0"  style='color:#1a5a03;' >{{  Helper::number_f($SALDO) }} </td>
              @endif

            </tr>
        </tbody>
    </table> 