<?php

use App\Helpers\Helper;
use App\Mobile_Detect;

$dete= new Mobile_Detect();
$iconsize=  $dete->isMobile() ? "": "fa-lg";
?>

<style>
  thead{
    font-size: 12px;
  }
  td p a:link,   td p a:visited{
    color:black;
  }
  tr{
    background: #fdc673 !important;
  }
</style>

<table id="informes_arreglo" class="table  table-sm table-bordered  table-striped" >
        <thead class="thead-dark">
            <tr> <th>CI</th><th>TITULAR</th><th>DEMANDANTE</th><th>COD_EMP</th> <th class="text-right" >DEMANDA</th><th>CUENTA BANCO</th>
                  <th>DEPÓSITO</th>  <th>EXTRACCIÓN (C)</th> <th>EXTRACCIÓN (L)</th>
          </tr>
        </thead>
        <tbody>
          <!--CADA CTA TENDRA ALGUN DEPOSITO, EXTRACCION O EXTRACCION POR PROYECTO-->
          <?php 
          
          $totdepo=0; $totextr_c=0;  $totextr_l=0;
          
          foreach( $lista as $it):
            
          $totdepo+=  intval($it->DEPOSITO);
          $totextr_c+= intval( $it->{"EXT.CAPITAL"}  );
          $totextr_l+= intval( $it->{"EXT.LIQUIDACION"}  );

            ?>
            <tr style="font-size: 9pt;">
                
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">
                <a href="<?=url("ficha-demanda/".$it->ID_DEMANDA)?>">  {{ $it->CI }} </a> 
              </p></td>
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->TITULAR}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->DEMANDANTE}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->COD_EMP}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{ Helper::number_f($it->DEMANDA)}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">
              <a href="<?=url("ctajudicial/".$it->ID_DEMANDA)?>"> {{$it->CTA_BANCO}}</a>
              </p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{ Helper::number_f( $it->DEPOSITO)  }}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">  {{  Helper::number_f($it->{"EXT.CAPITAL"}) }}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">   {{ Helper::number_f($it->{"EXT.LIQUIDACION"}) }}</p></td>
            </tr>
            </tr>

          <?php  endforeach; ?>

          <tr  style="font-size: 9pt;">
          <td  class="text-right"></td><td  class="text-right"></td><td  class="text-right"></td>
          <td  class="text-right"></td><td  class="text-right"></td><td style="font-weight: 600;"  class="text-right">TOTALES</td>
          <td  class="text-right">{{ Helper::number_f($totdepo)}}</td>
          <td  class="text-right">{{ Helper::number_f( $totextr_c)}}</td>
          <td  class="text-right">{{ Helper::number_f($totextr_l)}}</td>
        </tr>
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