
 
<?php

use App\Helpers\Helper;
use App\Mobile_Detect;

 
?>

<style>
  td p a:link,   td p a:visited{
    color:black;
  }
  tr{
    background: #a3c5fc !important;
  }
</style>

<table id="ctabancos" class="table  table-sm table-bordered table-responsive table-striped">
        <thead class="thead-dark">
            <tr>
              <th></th>
              <th></th>
              @if( session("tipo")=="S" )
              <th></th>
              @endif 
               <th></th><th>DEPÓS.</th><th>EXTR.</th><th class="text-right">BANCO</th><th class="text-right">CUENTA</th>
            <th class="text-right">TIPO CTA.</th><th>TITULAR</th><th>SALDO</th></tr>
        </thead>
        <tbody>
          <!--CADA CTA TENDRA ALGUN DEPOSITO, EXTRACCION O EXTRACCION POR PROYECTO-->
          <?php  foreach( $movi as $it):?>
            <tr  >
              <td ><p class="pt-1 mr-1 ml-1 mb-0 text-center"><a   href="<?=url("vbank")."/$it->IDNRO"?>"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></a></p></td>
              <td><p class="pt-1 mr-1 ml-1 mb-0 text-center"><a onclick="mostrar_form(event)" data-toggle="modal" data-target="#showform"   href="<?= url("ebank/".$it->IDNRO) ?>"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a></p></td>
              @if( session("tipo")=="S" )
              <td><p class="pt-1 mr-1 ml-1 mb-0 text-center"><a   onclick="borrar(event)" href="<?= url("dbank/".$it->IDNRO) ?>"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></p></td>
              @endif
              <td>
               <!--MANDAR A IMPRIMIR -->
               <p class="pt-1 mr-1 ml-1 mb-0 text-center">
              <a  href="<?= url("bank"."/$it->IDNRO")?>" data-toggle="modal" data-target="#show_opc_rep" onclick="mostrar_informe(event)" style="color:black;" > <i class="fa fa-print fa-lg" aria-hidden="true"></i>
              </a></p>
              </td>
              <td> <p class="pt-1 mr-1 ml-1 mb-0 text-center"><a data-toggle="modal" data-target="#showform"    onclick="mostrar_form(event)" href="<?= url("depobank/".$it->IDNRO) ?>"><i class="fa fa-plus-square fa-lg" aria-hidden="true"></i></a> </p></td>
              <td> <p class="pt-1 mr-1 ml-1 mb-0 text-center"><a data-toggle="modal" data-target="#showform"    onclick="mostrar_form(event)" href="<?= url("extrbank/".$it->IDNRO) ?>"><i class="fa fa-minus-square fa-lg" aria-hidden="true"></i></a> </p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->BANCO}}</p></td>
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{ $it->CUENTA }}</p></td>
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->TIPO_CTA}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->TITULAR}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0 text-right">{{ Helper::number_f( intval($it->SALDO) < 0 ? "0" : $it->SALDO ) }}</p></td>
            </tr>

          <?php  endforeach; ?>
        </tbody>
    </table> 