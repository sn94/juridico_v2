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

<table id="informes_arreglo" class="table  table-sm table-bordered  table-striped" >
        <thead class="thead-dark">
            <tr> <th>CI</th><th>TITULAR</th><th class="text-right" >DEMANDA</th><th>DEMANDANTE</th>
             <th >COD. EMP</th><th>TIPO ARREG.</th><th>TOTAL</th><th>CUOTAS</th><th>CUO.PAGADAS</th> </tr>
        </thead>
        <tbody>
          <!--CADA CTA TENDRA ALGUN DEPOSITO, EXTRACCION O EXTRACCION POR PROYECTO-->
          <?php  foreach( $lista as $it):?>
            <tr style="font-size: 9pt;">
                
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">
                <a href="<?=url("ficha-demanda/".$it->IDNRO."/6")?>">  {{ $it->CI }} </a> 
              </p></td>
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->TITULAR}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->DEMANDA}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->DEMANDANTE}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->COD_EMP}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->TIPO}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{ Helper::number_f($it->TOTAL)}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->CUOTAS}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{  $it->PAGADAS }}</p></td> 
            </tr>

          <?php  endforeach; ?>
        </tbody>
    </table> 
 
@if(  sizeof($lista)  == 0)
<p>No hay Registros</p>
 @endif 
 

    @if ( method_exists(  $lista, "links") )
    {{ $lista->links()}}
    @endif


    <script>
    /*
    window.onload= function(){
        $('#gastos').DataTable( {
          paging: false,
          "language": {   "url": "<?=url("assets/Spanish.json")?>"  }
        } );
    };
 */
    </script>