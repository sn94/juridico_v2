 
 
 
 <table id="demandadostable" class="table table-responsive table-bordered table-striped">
  <thead class="thead-dark">
      <tr>
         <th></th>
       
       <th>CI</th>  <th >NOMBRE COMPLETO</th> <th>DOMICILIO</th> <th>TELÉFONO</th> </tr>
  </thead>
  <tbody>
  <?php foreach( $lista as $item): ?>
      <tr  id="{{$item->IDNRO}}" > 
    <td >  <a href="<?=url("demandas-by-id/".$item->IDNRO)?>" ><i class="fa fa-eye" aria-hidden="true" style="color:black;"></i></a>   </td> 
    
    <td >  <?=$item->CI_GARANTE?> </td>
    <td >  <?= $item->GARANTE?> </td> 
    <td  > <?= $item->DOM_GARANT?> </td>  
    <td  > <?= $item->TEL_GARANT?> </td>   
     
  </tr>
  <?php  endforeach; ?>
  </tbody>
  </table>
 

  

   {{ $lista->links() }}