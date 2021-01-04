
 
<?php

use App\Helpers\Helper;
use App\Mobile_Detect;

$dete= new Mobile_Detect();
$iconsize=  $dete->isMobile() ? "": "fa-lg";
?>

<style>
  td p a:link,   td p a:visited{
    color:black;
  }
  tr{
    background: #fdc673 !important;
  }
</style>

<table id="gastos" class="table  table-sm table-bordered  table-striped">
        <thead class="thead-dark" >
            <tr>
              <th></th>
              
              @if( session("tipo")=="S" ) 
              <th></th>
              @endif

             <th >FECHA
             <a onclick="ordena_grilla('FECHA','A')" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
             <a onclick="ordena_grilla('FECHA','D')" href="#"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
            </th>

            <th >MOTIVO
             <a onclick="ordena_grilla('ID_DEMA','A')" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
             <a onclick="ordena_grilla('ID_DEMA','D')" href="#"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
            </th>

             <th>CODIGO
             <a onclick="ordena_grilla('CODIGO','A')" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
             <a onclick="ordena_grilla('CODIGO','D')" href="#"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
             </th>
             
             <th >NUMERO
             <a onclick="ordena_grilla('NUMERO','A')" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
             <a onclick="ordena_grilla('NUMERO','D')" href="#"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
             </th>
             
             <th>DETALLE 1</th>

             <th class="text-right">IMPORTE
             <a onclick="ordena_grilla('IMPORTE','A')" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
             <a onclick="ordena_grilla('IMPORTE','D')" href="#"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
             </th> 
             
             <th>REGISTRO</th></tr>
        </thead>
        <tbody>
          <!--CADA CTA TENDRA ALGUN DEPOSITO, EXTRACCION O EXTRACCION POR PROYECTO-->
          <?php  foreach( $movi as $it):?>
            <tr id="{{$it->IDNRO}}">
               
              <td><p class="pt-1 mr-1 ml-1 mb-0 text-center"><a onclick="mostrar_form(event)" data-toggle="modal" data-target="#showform"   href="<?= url("gasto/M/".$it->IDNRO) ?>"><i class="fa fa-pencil {{$iconsize}}" aria-hidden="true"></i></a></p></td>
              
              @if( session("tipo")=="S" )
              <td><p class="pt-1 mr-1 ml-1 mb-0 text-center"><a   onclick="borrar(event)" href="<?= url("dgasto/".$it->IDNRO) ?>"><i class="fa fa-trash {{$iconsize}}" aria-hidden="true"></i></a></p></td>
              @endif 

              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0"> {{  Helper::fecha_dma($it->FECHA) }} </p></td>

              <td  class="text-left"><p class="pt-1 mr-1 ml-1 mb-0">
                @if (is_null( $it->ID_DEMA) )
                VARIOS 
              @else
              <a style="text-decoration: underline;" href="<?=url("ficha-demanda/".$it->ID_DEMA)?>">DEMANDA ( {{$it->COD_EMP}})</a>
              @endif
                </p></td>

              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{ $it->COD_GASTO }}</p></td>
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->NUMERO}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->DETALLE1}}</p></td>
            
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0 text-right">{{ Helper::number_f( $it->IMPORTE ) }}</p></td>
              <td class="text-right"> <p class="pt-1 mr-1 ml-1 mb-0">{{ Helper::beautyDate($it->created_at) }}</p> </td>
            </tr>

          <?php  endforeach; ?>
        </tbody>
    </table> 
 
 @if( $movi->count())
 {{ $movi->links()}}
 @endif
 

    <script>
    /*
    window.onload= function(){
        $('#gastos').DataTable( {
          "ordering": true,
          "autoWidth": false,
          paging: false,
          "language": {   "url": "<?=url("assets/Spanish.json")?>"  }
        } );
    };
 */
   
 

</script>
