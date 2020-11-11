@php
//require_once "libs/Mobile_Detect.php";

use App\Mobile_Detect;

$detect= new Mobile_Detect();
@endphp



 

@if( sizeof( $lista) <= 0 )
<p class="text-light"> Sin registros </p>

@else:


        @if ($detect->isMobile() == false)
        
      <table id="demandadostable" class="table table-responsive table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
              <th></th>
              @if(session("tipo")=="S")
            <th></th>
            @endif
            <th>CI</th>  <th >TITULAR</th> <th>DOMICILIO</th> <th>TELÉFONO</th><th>Nro.Juicios</th> </tr>
        </thead>
        <tbody>
        <?php foreach( $lista as $item): ?>
            <tr  id="{{$item->IDNRO}}" > 
          <td >  <a href="<?=url("demandas-by-id/".$item->IDNRO)?>" ><i class="fa fa-eye" aria-hidden="true" style="color:black;"></i></a>   </td> 
          @if(session("tipo")=="S")
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
      

      @else

      <table id="demandadostable" class="table table-responsive table-bordered table-striped">
        <thead class="thead-dark">
            <tr> <th></th> <th></th><th>CI</th>  <th >TITULAR</th><th>Nro.Juicios</th> </tr>
        </thead>
        <tbody>
        <?php foreach( $lista as $item): ?>
            <tr id="{{$item->IDNRO}}">  

            @if( strlen(trim($item->CI))>0   )
          <td> <p  class="p-0 m-0" ><a style="color:black;"  href="<?=url("demandas-by-ci/".$item->CI)?>" ><i class="fa fa-eye" aria-hidden="true"></i></a></p>  </td> 
            @else 
            <td> <p  class="p-0 m-0" ><a style="color:black;"  href="<?=url("demandas-by-id/".$item->IDNRO)?>" ><i class="fa fa-eye" aria-hidden="true"></i></a></p>  </td> 
            @endif
          <td> <p  class="p-0 m-0"  > <a style="color:black;"  href="<?=url("ddemandado/".$item->IDNRO)?>" onclick="procesar_borrar(event, <?=$item->IDNRO?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></p> </td> 
          <td> <p  class="p-0 m-0"  > <?=$item->CI?> </p> </td>
          <td> <p  class="p-0 m-0"  style="width: 150px;" ><?= $item->TITULAR?></p></td>  
          <td  style="text-align: center;"> <p class="p-0  m-0" >{{ isset($item->nro)? $item->nro : ""}}</p></td>
        </tr>
        <?php  endforeach; ?>
        </tbody>
        </table>
      @endif
        
        {{ $lista->links() }}


@endif



