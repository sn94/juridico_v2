 
    <table id="demandatable" class="table table-bordered table-striped">
      <thead class="thead-dark">
          <tr> <th>COD_EMP</th><th>CI</th> <th>TITULAR</th> <th>DEMANDANTE</th> <th>CTA_BANCO</th> <th>BANCO</th> <th>GARANTE</th><th>CI.GTE.</th></tr>
      </thead>
      <tbody>
      <?php foreach( $lista as $item): ?>
          <tr> <td> <a href="<?=url("ficha-demanda/".$item->IDNRO)?>"><?= $item->COD_EMP?></a> </td>  <td><?= $item->CI?></td> <td><?= $item->TITULAR?></td><td><?= $item->DEMANDANTE?></td><td><?= $item->CTA_BANCO?></td><td><?= $item->BANCO?></td><td><?= $item->GARANTE?></td><td><?= $item->CI_GARANTE?></td></tr>
      <?php  endforeach; ?>
      </tbody>
      </table>
      <script>
         // document ready
            $('#demandatable').DataTable( 
                {   
            "ordering": false,
            "language": {
              "url": "<?=url("assets/Spanish.json")?>"
            }
          }
            );
           
      </script>
 