<?php

use App\Mobile_Detect;
use App\Helpers\Helper;

$detect= new Mobile_Detect();
if( $detect->isMobile() == false){
  ?>
<style>
  #plancuenta a:link, #plancuenta a:visited{
    color:black;
  }
  tr{
    background: #fdc673 !important;
  }
</style>


<?php
} 
?>


<table id="plancuenta" class="table table-striped table-bordered table-responsive">
      <thead class="thead-dark ">
      <th class="pb-0"></th>
      @if( session("tipo") == "S")
      <th class="pb-0"></th>
      @endif 

      <th class="pb-0">CÓDIGO</th>  
        <th class="pb-0">DESCRIPCION</th>  
        <th class="pb-0">CREADO</th> 
        </thead>
      <tbody>
        <?php  foreach( $lista as $it) :?>
        <tr> 
          <td><a data-toggle="modal" data-target="#showform" onclick="editar(event)" href="<?=url("plan-cuenta/M/".$it->IDNRO)?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
          
          @if( session("tipo") == "S")
          <td><a onclick="borrar(event)" href="<?=url("del-plan-cuenta/".$it->IDNRO)?>" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
          @endif 

          <td> {{ $it->CODIGO }}   </td>
           <td> {{ $it->DESCRIPCION }}   </td> 
           <td> {{ Helper::beautyDate( $it->created_at )}}   </td>  
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>


    @if( $lista->count())

          {{$lista->links()}}

    @endif