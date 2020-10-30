
 
<?php

use App\Helpers\Helper;
use App\Mobile_Detect;

$detect=  new Mobile_Detect();
$icons_size= $detect->isMobile() ? "": " fa-lg";
?>
<table id="tlistaliquida" class="table  table-sm table-bordered table-striped table-responsive">
        <thead class="thead-dark">
            <tr><th></th><th></th><th></th><th></th><th class="text-right">SALDO</th><th class="text-right">ULT_PAGO</th><th class="text-right">TOTAL</th></tr>
        </thead>
        <tbody>
          <?php  foreach( $lista as $it):?>
            <tr id="{{$it->IDNRO}}">

              <td ><p class="p-0 m-0"><a  style="color:black;" href="<?= url("vliquida/".$it->IDNRO) ?>"><i class=" mr-2 ml-2 fa fa-eye " aria-hidden="true"></i></a></p></td>
              <td><p class="p-0 m-0"><a  style="color:black;"   href="<?= url("eliquida/".$it->IDNRO) ?>"><i class="mr-2 ml-2 fa fa-pencil " aria-hidden="true"></i></a></p></td>
              <td><p class="p-0 m-0"><a style="color:black;"  onclick="borrar(event)" href="<?= url("dliquida/".$it->IDNRO) ?>"><i class="mr-2 ml-2  fa fa-trash " aria-hidden="true"></i></a></p></td>
              <td>
          <!--MANDAR A IMPRIMIR -->
          <a  href="<?= url("liquida")?>" data-toggle="modal" data-target="#show_opc_rep" onclick="mostrar_informe(event)" style="color:black;" > <i class="mr-2 ml-2  fa fa-print   " aria-hidden="true"></i>
          </a> 
          </td>
              <td class="text-right"><p class="p-0 m-0">{{Helper::number_f($it->SALDO)}}</p></td>
              <td  class="text-right"><p class="p-0 m-0">{{ Helper::beautyDate($it->ULT_PAGO) }}</p></td>
              <td  class="text-right"><p class="p-0 m-0">{{Helper::number_f($it->TOTAL) }}</p></td>
            </tr>

          <?php  endforeach; ?>
        </tbody>
    </table> 




 