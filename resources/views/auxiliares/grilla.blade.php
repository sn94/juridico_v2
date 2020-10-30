<?php

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
        <th class="pb-0">DESCRIPCION</th> 
        <?php if($TABLA=='odemanda'):?>
          <th class="pb-0">TELÉFONO</th>
          <th class="pb-0">OBS</th>
        <?php endif; ?>
        </thead>
      <tbody>
        <?php  foreach( $lista as $it) :?>
        <tr> 
          <td><a onclick="editar(event)" href="<?=url("editaux/".$TABLA."/".$it->IDNRO)?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
          <td><a onclick="borrar(event)" href="<?=url("delaux/".$TABLA."/".$it->IDNRO)?>" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
          
          <?php if($TABLA=='odemanda'):?>
            <td> {{  $it->NOMBRES }}   </td> 
            <td> {{  $it->TELEFONO }}   </td> 
            <td> {{  $it->OBS }} </td> 
          <?php  else:?>
            <td> {{ $it->DESCR }}   </td> 
          <?php   endif;?>
          
            
      
      </tr>
        <?php endforeach; ?>
      </tbody>
    </table>