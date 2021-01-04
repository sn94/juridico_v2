<?php
use App\Helpers\Helper;

use App\Mobile_Detect;

$dete= new Mobile_Detect();
$iconsize=  $dete->isMobile() ? "": "fa-lg";
$tablaresponsiva= $dete->isMobile()?"table-responsive" : "";
?>
 

<style>
  td p a:link,   td p a:visited{
    color:black;
  }
  tr{
    background:  #a3c5fc  !important;
  }
</style>


<div class="pl-0 col-md-8 col-12">

<table id="ctabancos" class="table  table-sm table-bordered {{$tablaresponsiva}} table-striped">
        <thead class="thead-dark">
            <tr>
              <th></th>
              @if( session("tipo")=="S" )
              <th></th> 
              @endif 

              <th class="text-right">DEBE</th><th class="text-right">HABER</th>
            <th class="text-right">FECHA.</th><th>CONCEPTO</th> </tr>
        </thead>
        <tbody>
          <!--CADA CTA TENDRA ALGUN DEPOSITO, EXTRACCION O EXTRACCION POR PROYECTO-->
          <?php  foreach( $dato as $it):?>
            <tr id="{{$it->IDNRO}}"> 
              <td><p class="pt-1 mr-1 ml-1 mb-0 text-center"><a onclick="mostrar_form(event)" data-toggle="modal" data-target="#showform"   href="<?= url("emovibank/".$it->IDNRO) ?>"><i class="fa fa-pencil {{$iconsize}}" aria-hidden="true"></i></a></p></td>
             
              @if( session("tipo")=="S" )
              <td><p class="pt-1 mr-1 ml-1 mb-0 text-center"><a   onclick="borrar(event)" href="<?= url("dmovibank/".$it->IDNRO) ?>"><i class="fa fa-trash {{$iconsize}}" aria-hidden="true"></i></a></p></td>
             @endif 
             
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->TIPO_MOV=="D" ? Helper::number_f($it->IMPORTE) : '*****'}}</p></td>
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->TIPO_MOV=="E" ?  Helper::number_f($it->IMPORTE) : '*****'}}</p></td>
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->FECHA}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->CONCEPTO}}</p></td> 
            </tr>

          <?php  endforeach; ?>
        </tbody>
    </table> 
    </div>