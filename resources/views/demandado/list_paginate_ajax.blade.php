

@if( sizeof( $lista) <= 0 )
<p class="text-light"> Sin registros </p>

@else

 
        
      <table id="demandadostable" class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
              <th></th>
              @if(session("tipo")=="S"  ||  session("tipo")=="SA")
            <th></th>
            @endif
            <th>CI</th>  <th >TITULAR</th> <th>DOMICILIO</th> <th>TELÉFONO</th><th>Nro.Juicios</th> </tr>
        </thead>
        <tbody>
        <?php foreach( $lista as $item): ?>
            <tr  id="{{$item->IDNRO}}" > 
          <td >  <a href="<?=url("demandas-by-id/".$item->IDNRO)?>" ><i class="fa fa-eye" aria-hidden="true" style="color:black;"></i></a>   </td> 
          @if(session("tipo")=="S" ||  session("tipo")=="SA"  )
          <td > <p  > <a href="<?=url("ddemandado/".$item->IDNRO)?>" onclick="procesar_borrar(event,'{{$item->IDNRO}}')"><i class="fa fa-trash"  style="color:black;" aria-hidden="true"></i></a></p> </td> 
          @endif
          <td >  <?=$item->CI?> </td>
          <td >  <?= $item->TITULAR?> </td> 
          <td  > <?= $item->DOMICILIO?> </td>  
          <td  > <?= $item->TELEFONO?> </td>   
          <td style="text-align: center;">{{ isset($item->nro)? $item->nro : ""}}</td>
        </tr>
        <?php  endforeach; ?>
        </tbody>
        </table>
      
 
        
        {{ $lista->links() }}


@endif



