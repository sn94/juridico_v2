
 
<?php
 
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



@if(  isset( $error ) )

<p class="ml-2"> {{$error}}</p>

@else
<input type="hidden" name="nombre" value="{{$TITULAR}}">
<button style="background-color: #fcae3a;" class="btn btn-sm btn-warning" onclick="selec_demanda()" type="button">Ok</button>
<table id="gastos" class="table  table-sm table-bordered   table-striped">
        <thead class="thead-dark">
            <tr><th></th><th>COD.EMP.</th> <th>DEMANDA</th><th >BANCO</th><th>CTA. BANCO</th>  </tr>
        </thead>
        <tbody>
          <!--CADA CTA TENDRA ALGUN DEPOSITO, EXTRACCION O EXTRACCION POR PROYECTO-->
          <?php  foreach( $demandas as $it):?>
            <tr id="{{$it->IDNRO}}">
              <td> <input onchange="selec_demanda(event)" type="radio" name="demanda" value="{{$it->IDNRO}}"> </td>
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{ $it->COD_EMP }}</p></td>
              <td  class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->DEMANDA}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->BANCO}}</p></td>
              <td class="text-right"><p class="pt-1 mr-1 ml-1 mb-0">{{$it->CTA_BANCO}}</p></td> 
            </tr>

          <?php  endforeach; ?>
        </tbody>
    </table> 
 @endif
    <script>


function numero_con_puntuacion( obj ) {
     
    let enpuntos= new Intl.NumberFormat("de-DE").format( obj);
return enpuntos;
   }


$("#TITULAR").val(  $("input[name=nombre]").val());

      function selec_demanda(ev){
       
        
        if( ev == undefined )
        //limpiar todo
       $("#chooser-place").html("");
       else{
        let idnro=  ev.currentTarget.value;// $("input[name=demanda]").val();
        $("input[name=ID_DEMA").val( idnro);
      let cod_emp= ev.currentTarget.parentNode.parentNode.children[1].textContent;
       let demand_monto= ev.currentTarget.parentNode.parentNode.children[2].textContent;
        $("#datos-extra").text( "Cod. Emp.: "+cod_emp+" ,Monto: "+ numero_con_puntuacion(demand_monto)  ); 
          }
      
      }
    </script>