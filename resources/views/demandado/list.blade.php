@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">DEMANDAS</li> 
<li class="breadcrumb-item active" aria-current="page">DEMANDADOS</li> 
@endsection

@section('content')

<h3>DEMANDADOS</h3>
  
<div class="btn-group mb-2" role="group" aria-label="Basic example">
  <a href="<?=url("demandas-agregar")?>" class="btn btn-success">NUEVO</a>
 
</div>

<div id="tabla-dinamica">
    <table id="demandadostable" class="table table-responsive table-bordered table-striped" style="width:100%">
      <thead class="thead-dark">
          <tr> <th></th> <th>CI</th>  <th >TITULAR</th> <th>DOMICILIO</th> <th>TELÉFONO</th> </tr>
      </thead>
      <tbody>
      <?php foreach( $lista as $item): ?>
          <tr> <td><a href="<?=url("demandas-by-ci/".$item->CI)?>" >VER</a></td>  <td > <a href="<?=url("vdemandado/".$item->CI)?>"><?=$item->CI?> </a> </td><td  > <p style="width: 150px;margin:0px;"><?= $item->TITULAR?></p></td> <td> <p style="width: 200px;margin:0px;"><?= $item->DOMICILIO?></p></td>  <td><?= $item->TELEFONO?></td>   </tr>
      <?php  endforeach; ?>
      </tbody>
      </table>

   
  </div>


  <script> 
document.onreadystatechange = () => {
  if (document.readyState === 'complete') {
    // document ready
    $('#demandadostable').DataTable(
      {  
         "columnDefs": [
    { "width": "20%", "targets": 0 }
  ],
        "ordering": false,
        "language": {
            "url": "<?=url("assets/Spanish.json")?>"
        },
        "autoWidth": false
      }
    );
  

  }
}; 
  </script>
  
@endsection


