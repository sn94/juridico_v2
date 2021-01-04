<?php

use App\Helpers\Helper;

?>
<table id="demandatable" class="table table-bordered table-striped">

<thead class="thead-dark">
    <tr style="font-size: 9pt;"><th>TITULAR</th><th style="width: 80px;">DEMANDANTE</th> <th  class="">COD_EMP</th> <th>NOTIFICACIÓN</th> <th>VENCIMIENTO</th><th  class="">OBS</th></tr>
</thead>
<tbody>
<?php foreach( $lista as $item): ?>

    <tr class="{{ intval($item->VENCIDO)> 0 ? 'table-secondary' : 'table-danger' }}" >


    <td ><?= $item->TITULAR?></td>
    <td  style="width: 80px;" ><?= $item->DEMANDANTE?></td>
    <td  class=""><a href="<?=url("ficha-demanda/".$item->DEMANDA)?>"><?= $item->COD_EMP?></a></td> 
    <td>{{ Helper::beautyDate( $item->FECHA)}}</td>
    <td>{{  Helper::beautyDate($item->FECHAV) }}</td>
    <td  class="">
    <?= $item->VENCIDO<= 0? $item->OBS : ("FALTA ".$item->VENCIDO." DIAS")?>
    </td> </tr>
<?php  endforeach; ?>
</tbody>

</table>
 

@if( $lista->count() )
{{$lista->links()}}
@else 
Sin notificaciones
@endif