<?php

use App\Helpers\Helper;
 
?> 


<table id="plancuenta" class="table table-striped  table-bordered   table-dark">
      <thead  class="thead-dark" >
      <th class="pb-0"></th>
   
      <th class="pb-0"></th> 

      <th class="pb-0">Id.</th>  
        <th class="pb-0">Descripción</th>  
        <th class="pb-0 text-center"> N° Máximo de Usuarios</th>
        <th class="pb-0 text-center"> Precio</th>
        <th class="pb-0 text-center"> Duración</th>
        <th class="pb-0">CREADO</th> 
        </thead>
      <tbody>
        <?php  foreach( $lista as $it) :?>
        <tr> 
          <td>
            <a class="text-light" data-toggle="modal" data-target="#showform" onclick="mostrarFormulario(event)" href="<?=url("admin/planes-update/".$it->IDNRO)?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
           
          <td>
            <a class="text-light"   onclick="borrar(event)" href="<?=url("admin/planes/".$it->IDNRO)?>" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
        
          <td class="text-center"> {{ $it->IDNRO }}   </td>
           <td> {{ $it->DESCR }}   </td> 
           <td class="text-center">  {{ $it->MAX_USERS }} </td>
           <td class="text-center">  {{Helper::number_f( $it->PRECIO ) }} </td>
           <td class="text-center">  {{ $it->DURACION }} </td>
           <td> {{ Helper::beautyDate( $it->created_at )}}   </td>  
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>


    @if( $lista->count())

          {{$lista->links()}}

    @endif