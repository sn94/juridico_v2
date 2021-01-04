<?php

use App\Helpers\Helper;


?>
<table class="table table-secondary table-striped table-hover">
  <thead>
    <th>N°</th>
    <th>Fecha</th>
    <th>IMPORTE</th>
    <th>Email</th>
  </thead>
  <tbody>

    @foreach( $recibos as $r)

    <tr>
      <td class="text-center">{{$r->IDNRO }}</td>
      <td class="text-center">{{Helper::beautyDate($r->FECHA)}}</td>
      <td class="text-center"> {{Helper::number_f($r->IMPORTE)}}</td>
      <td class="text-center"> <a onclick="enviar_por_mail(event)" href="<?= url('recibos-free/mailto/' . $r->IDNRO) ?>"> <i class="fa fa-envelope"></i></a> </td>

    </tr>
    @endforeach

  </tbody>
</table>

<script>
  async function enviar_por_mail(ev) {
    ev.preventDefault();

    let resour=  ev.currentTarget.href;
    let req=  await fetch(  resour);
    let resp=  await req.text();
    $("#viewform").html(  resp);
    $("#showform").modal("show");
  }
</script>
{{ $recibos->links()}}