
<table class="table table-bordered table-dark">

<thead class="thead-dark">
<tr> <th  class="text-center">ID</th> <th>Razón Social</th> <th style="width: 100px;">Aprobar</th> <th></th></tr>
</thead>

<tbody>

@foreach( $clientes as $cli )


<tr>
<td class="text-center">{{$cli->IDNRO}}</td> <td>{{$cli->RAZON_SOCIAL}}</td> 
 <td style="width: 100px;"> 
  <a style="color: white; " onclick="aprobarCliente(event)"   href="<?=url("p/suscriptor/aprobar/".$cli->IDNRO)?>"> <i class="fa fa-check-circle fa-lg"></i></a>
  </td>

  <td class="text-center" >
  <a  style="color: white; " data-toggle="modal" data-target="#modal-eliminar"   href="<?= url("p/suscriptor/del/".$cli->IDNRO) ?>"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
  </td>
</tr>

@endforeach


</tbody>
 
</table>
@if(  sizeof($clientes) == 0 )
<p class="text-center" style="font-weight: 600;">Sin registros</p>
@endif 


{{ $clientes->links() }}