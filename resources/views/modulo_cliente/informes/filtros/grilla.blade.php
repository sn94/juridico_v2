<?php

use App\Mobile_Detect;

$detect= new Mobile_Detect();  
$icons_size= $detect->isMobile() ? "": " fa-lg";
if( $detect->isMobile() == false){
  ?>
<style>
  table{
    font-size:16px !important;
  }
  thead tr{
    
    font-size: 14px;
  }
</style>

<?php
} 
?>

 
<table id="filterstable" class="table table-striped table-bordered <?= $detect->isMobile()? "table-responsive" :"" ?>">
      <thead class="thead-dark ">

      <th class="pb-0 pt-0"></th>

      @if( session("tipo")=="S" )
      <th class="pb-0 pt-0"></th>
      @endif 
      
      <th class="pb-0 pt-0"></th>

      <th class="pb-0 pt-0">ID
      <a onclick="ordena_grilla('NRO','A')" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
      <a onclick="ordena_grilla('NRO','D')" href="#"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
      </th>

      <th class="pb-0 pt-0">NOMBRE
      <a onclick="ordena_grilla('NOMBRE','A')" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
      <a onclick="ordena_grilla('NOMBRE','D')" href="#"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
      </th>  

       </thead>
      <tbody>
        <?php  foreach( $lista as $it) :?>
        <tr id="{{$it->NRO}}"   style="background-color: rgba(0, 150, 166, 0.12);"> 
          <td><a   href="<?=url("efiltro/M/".$it->NRO)?>" style="color:black;"><i class="mr-2 ml-2 fa fa-pencil {{$icons_size}}" aria-hidden="true"></i></a></td>
          
          @if( session("tipo")=="S" )
          <td><a onclick="borrar(event)" href="<?=url("dfiltro/".$it->NRO)?>" style="color:black;" ><i class="mr-2 ml-2 fa fa-trash {{$icons_size}}" aria-hidden="true"></i></a></td>
          @endif 

          <td> 
           <!--MANDAR A IMPRIMIR -->
           <a  href="<?= url("filtro")."/$it->NRO"?>" data-toggle="modal" data-target="#show_opc_rep" onclick="mostrar_informe(event)" style="color:black;" > <i class="mr-2 ml-2 fa fa-print {{$icons_size}}" aria-hidden="true"></i></a> 
          </td>
          <td>{{$it->NRO}}</td>
          <td>{{$it->NOMBRE }}</td>
           </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
   

    @if( method_exists( $lista, "links") )

    {{$lista->links()}}
    @endif 

    <script>

 
/*
   $("#filterstable").DataTable(   {   
   "ordering": true,
   "language": {
       "url": "<?=url("assets/Spanish.json")?>"
   },
   "autoWidth": false
 });*/
 
</script>

 