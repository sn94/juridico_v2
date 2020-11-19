 
<?php

use App\Helpers\Helper;

?>
 
    <table id="demandadostable" class="table table-bordered table-striped">
      <thead class="thead-dark pb-0 pt-0">
          <tr> 
            <th></th> 
            @if(   (session("tipo")=="S" || session("tipo")=="SA")  || session("tipo")=="O") <th></th> @endif
            @if (session("tipo")=="S" || session("tipo")=="SA")   <th></th>  @endif
           
          <th class="pb-0 pt-0">DEMANDANTE</th>  
          <th class="pb-0 pt-0">COD_EMP</th> 
          <th class="pb-0 pt-0">ORIGEN</th> 
          <th class="pb-0 pt-0">PRESENTADO</th> 
          <th class="pb-0 pt-0">SD.FINIQ.</th>
          <th class="pb-0 pt-0">FECHA FINIQ.</th>
          <th class="pb-0 pt-0">SALDO CAPITAL</th>
          <th class="pb-0 pt-0">SALDO LIQUID.</th>
          </tr>
      </thead>
      <tbody>
      <?php for($x=0; $x< sizeof($lista); $x++):
        $item= $lista[$x];    ?>
          <tr id="{{$item->IDNRO}}"> 

            <td><a href="<?= url("ficha-demanda/".$item->IDNRO)?>"><i  style="color:black;" class="fa fa-eye" aria-hidden="true"></i></a> </td> 
            
            @if(  (session("tipo")=="S" || session("tipo")=="SA")  || session("tipo")=="O")
            <td><a href="<?= url("demandas-editar/".$item->IDNRO)?>"><i   style="color:black;" class="fa fa-pencil" aria-hidden="true"></i></a> </td>
            @endif 
            @if (session("tipo")=="S" || session("tipo")=="SA") 
            <td >  <a onclick="procesar_borrar(event)" href="<?= url("demandas-borrar/".$item->IDNRO)?>"><i  style="color:black;" class="fa fa-trash" aria-hidden="true"></i></a> </td> 
           @endif

            <td >  <?= $item->DEMANDANTE?> </td>
            <td><?= $item->COD_EMP?></td>  
            <td > <?= $item->O_DEMANDA?></a> </td>
             <td>   {{ Helper::beautyDate(  $item->PRESENTADO)  }} </td>
             <td>{{$item->SD_FINIQUI}}</td>
             <td>{{ Helper::beautyDate($item->FEC_FINIQU) }}</td>
             <td class="text-right">{{Helper::number_f($saldos[$x]["saldo_capital"])}}</td>
             <td class="text-right" >{{Helper::number_f($saldos[$x]["saldo_liquida"])}}</td>
                </tr>
      <?php  endfor; ?>
      </tbody>
      </table> 
 