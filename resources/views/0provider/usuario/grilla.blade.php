
<table class="table table-bordered table-dark">

<thead class="thead-dark">
<tr> <th  class="text-center">ID</th> <th>Nick</th> <th> </th>   <th></th></tr>
</thead>

<tbody>

@foreach( $usuarios as $cli )


<tr>
<td class="text-center">{{$cli->IDNRO}}</td> <td>{{$cli->NICK}}</td> 
 
<td class="text-center" >
  <a  style="color: white;"  onclick="mostrarForm(event)"    href="<?= url("p/provider/edit/".$cli->IDNRO) ?>"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
  </td>

  <td class="text-center" >
  <a  style="color: white;"  onclick="prepararBorrar(event)"    href="<?= url("p/provider/del/".$cli->IDNRO) ?>"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
  </td>
</tr>

@endforeach


</tbody>

</table>

{{ $usuarios->links() }}