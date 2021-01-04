<?php

use App\Helpers\Helper; 
use App\Mobile_Detect;

$detect= new Mobile_Detect();
if( $detect->isMobile() == false){
  ?>
<style>
  table{
    font-size:16px !important;
  }
</style>

<?php
} 
?>


<table class="table table-striped table-bordered table-responsive">
      <thead class="thead-dark ">
      <th class="pb-0"></th>
      <th class="pb-0"></th>
      <th  class="pb-0"> {{$tipo=="E" ?"DESTINATARIO" : "REMITENTE"}}</th>
      <th class="pb-0">FECHA/HORA</th>  
     
      <th class="pb-0">LEÍDO</th>
  
     </thead>
      <tbody>
        <?php  foreach( $lista as  $it) :?>
        <tr id="{{$it->IDNRO}}"> 
          <td><a data-toggle="modal" data-target="#showform" onclick="leer(event)" href="<?=url("ver-msg/".$it->IDNRO)?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
          <td><a onclick="borrar(event)" href="<?=url("del-msg/".$it->IDNRO)?>" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
          <td>{{ $it->nick}}</td>
          <td> {{ Helper::beautyDate($it->created_at) }}   </td>   
          
          <td class="d-flex align-items-center">
            <input class="form-control form-control-sm" onchange="event.target.checked= !event.target.checked;"  type="checkbox" {{$it->LEIDO=="N" ? "" : "checked" }} >
          </td>
           
      </tr>
        <?php endforeach; ?>
       
      </tbody>
    </table>
    @if(  sizeof( $lista ) <=0 )
        <p class="ml-2">No hay mensajes</p>
        @endif