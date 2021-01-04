
 
<?php

use App\Helpers\Helper;

?>
<table id="tctajudicial" class="table  table-sm table-bordered table-striped">
        <thead class="thead-dark">
            <tr><th></th><th></th><th></th><th class="text-right"  >FECHA</th><th class="text-right">TIPO</th><th class="text-right">IMPORTE</th><th class="text-right">TIPO MOV.</th></tr>
        </thead>
        <tbody>
          <?php 

$total_deposito=0; $total_extraccion= 0;
          if( !is_null($movi)):

          
          foreach( $movi as $it):
          
            if( $it->TIPO_MOVI=="D" )  $total_deposito+= intval($it->IMPORTE);
            if( $it->TIPO_MOVI=="E" )  $total_extraccion+= intval($it->IMPORTE);
          ?>
            <tr id="{{$it->IDNRO}}">
              <td ><p class="p-0 m-0"><a   href="<?= url("vcuentajudi/".$it->IDNRO) ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></p></td>
              <td><p class="p-0 m-0"><a    href="<?= url("ecuentajudi/".$it->IDNRO) ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></p></td>
              <td><p class="p-0 m-0"><a   onclick="borrar(event)" href="<?= url("dcuentajudi/".$it->IDNRO) ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></p></td>
              <td  class="text-right"><p class="p-0 m-0">{{ Helper::beautyDate($it->FECHA) }}</p></td>
              <td class="text-right"> <p class="p-0 m-0">{{$it->TIPO_CTA=="C" ? "CAPITAL": "LIQUIDACION"}} </p></td>
              <td  class="text-right"><p class="p-0 m-0">{{ Helper::number_f($it->IMPORTE)}}</p></td>
              <td  class="text-right"><p class="p-0 m-0">{{$it->TIPO_MOVI=="D" ?"DEPOSITO":"EXTRACCION"}}</p></td>
            </tr>

          <?php  endforeach;
          endif;
           ?>
           
        </tbody>
    </table> 
    <div class="row col-12 col-sm-12 col-md-12 col-lg-12">
      <div class="col-12 col-sm-6 col-md-6 col-lg-6">
      <span style="font-weight: 600;">TOTAL DEPÓSITO: </span>{{Helper::number_f($total_deposito) }} 
      </div>
      <div class="col-12 col-sm-6 col-md-6 col-lg-6">
      <span style="font-weight: 600;">TOTAL EXTRACCIONES:</span> {{Helper::number_f($total_extraccion)}} 
      </div> 

    </div>