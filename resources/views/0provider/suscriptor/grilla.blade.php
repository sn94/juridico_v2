 

<table class="table table-bordered table-dark">

<thead class="thead-dark">
<tr> <th  class="text-center">ID</th> <th>Razón Social</th> <th>Plan</th>  <th>Email</th> <th>Teléfono</th> <th></th>
<th style="width: 100px;">Habilitado</th>   <th>Re-generar credencial</th><th></th> <th></th></tr>
</thead>

<tbody>

@foreach( $clientes as $cli )


<tr>
<td class="text-center">{{$cli->IDNRO}}</td> <td>{{$cli->RAZON_SOCIAL}}</td> 

<td class="text-center"> {{$cli->PLAN_}}</td>

<td class="text-center"> {{$cli->EMAIL}}</td>

<td class="text-center"> {{$cli->TELEFONO}}</td>


<td class="text-center">  <a class="btn btn-danger btn-sm" href="<?=url("p/pagos/".$cli->IDNRO)?>">Pagos</a></td>

 <td style="width: 100px;"> 
  <div class="form-group p-0 m-0"> 
    <label class="switch switch-sm switch-to-primary p-0">
    <input onchange="actualizar_estado( event, '<?=$cli->IDNRO?>')"    <?= ( $cli->HABILITADO == "Si") ?"checked" : "" ?>    value="S" type="checkbox"/>
      <span class="switch-slider"></span>
    </label> 
  </div>
  </td>

  <td class="text-center">
    <a  style="color: white;"  onclick="regenerarCredenciales(event)"  href="<?=url("p/paso4_gen_credenciales/".$cli->IDNRO)?>"> <i class="fa fa-key fa-lg"></i> </a>
  </td>
  <td class="text-center" >
  <a  style="color: white;"    href="<?= url("p/suscripcion/edit/".$cli->IDNRO) ?>"><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>
  </td>


  <td class="text-center" >
  <a  style="color: white;" data-toggle="modal" data-target="#modal-eliminar"   href="<?= url("p/suscriptor/del/".$cli->IDNRO) ?>"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
  </td>
</tr>

@endforeach


</tbody>
 
</table>
@if(  sizeof($clientes) == 0 )
<p class="text-center" style="font-weight: 600;">Sin registros</p>
@endif 


{{ $clientes->links() }}