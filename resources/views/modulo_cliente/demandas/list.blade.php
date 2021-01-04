@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">DEMANDAS</li>  
@endsection



@section('content')

<div class="btn-group mb-2" role="group" aria-label="Basic example">
  <a href="<?=url("demandas-agregar")?>" class="btn btn-success">Agregar</a>
  <a  href="#" class="btn btn-success">Modificar</a>
  <a href="#" class="btn btn-success">Eliminar</a>
  <a href="<?=url("demandas-liquidar")?>" class="btn btn-success">Liquidar</a>
</div>

<br>
<h5>Origen de demanda: </h5>
<select id="ODEMANDA" class="form-control mb-1" onchange="filtrar_por_origen(event)">
<?php foreach( $odemanda as $it): ?>
<option value="{{$it->CODIGO}}">{{$it->NOMBRES}}</option>
<?php endforeach;?>
</select>

  <div id="tabla-dinamica">
    <table id="demandatable" class="table table-bordered table-striped">
      <thead class="thead-dark">
          <tr> <th>COD_EMP</th><th>CI</th>  <th>TITULAR</th> <th>DEMANDANTE</th> <th>CTA_BANCO</th> </tr>
      </thead>
      <tbody>
      <?php foreach( $lista as $item): ?>
          <tr><td > <a href="<?=url("ficha-demanda/".$item->IDNRO)?>"><?= $item->COD_EMP?></a> </td> <td><?= $item->CI?></td>  <td><?= $item->TITULAR?></td><td><?= $item->DEMANDANTE?></td><td><?= $item->CTA_BANCO?></td>   </tr>
      <?php  endforeach; ?>
      </tbody>
      </table>

      <script>
        document.onreadystatechange = () => {
          if (document.readyState === 'complete') {
            // document ready
            $('#demandatable').DataTable( 
              {   
            "ordering": false,
            "language": {
              "url": "<?=url("assets/Spanish.json")?>"
            }
          }
            );
          }
        };
      </script>
  </div>
  
  
@endsection



<script>
function filtrar_por_origen(ev){
  let odemanda= ev.target.value ;
  $.ajax( {
    url:"<?= url("demandas-by-o")?>/"+odemanda,
    beforeSend: function(){
      $("#tabla-dinamica").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
    },
    success: function( res){
      $("#tabla-dinamica").html( res );
    },
    error( xhr){
      $("#tabla-dinamica").html( res );
    }
    }) ;
}

 

       
    </script>