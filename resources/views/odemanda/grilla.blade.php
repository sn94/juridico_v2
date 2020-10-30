<table class="table table-striped table-bordered table-responsive">
      <thead class="thead-dark ">
      <th class="pb-0"></th>
      <th class="pb-0"></th>
        <th class="pb-0">CÓDIGO</th>
        <th class="pb-0">NOMBRES</th>
        <th class="pb-0">TELÉFONO</th>
        <th class="pb-0">OBS.</th></thead>
      <tbody>
        <?php  foreach( $lista as $it) :?>
        <tr> 
          <td><a onclick="editar_odemanda(event)" href="<?=url("eodema/".$it->IDNRO)?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
          <td><a onclick="borrar_odemanda(event)" href="<?=url("dodema/".$it->IDNRO)?>" ><i class="fa fa-trash" aria-hidden="true"></i></a></td>
          <td>{{$it->CODIGO}}</td> <td>{{$it->NOMBRES}}</td>  <td>{{$it->TELEFONO}}</td>  <td>{{$it->OBS}}</td> </tr>
        <?php endforeach; ?>
      </tbody>
    </table>