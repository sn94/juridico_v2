<?php

use App\Mobile_Detect;
use App\Helpers\Helper;

$detect= new Mobile_Detect();
if( $detect->isMobile() == false){
  ?>
<style>
  table{
    font-size:16px !important;
  }
</style>

<?php
} 
?>


@php 
if( !isset( $abogados) ) return;
@endphp
<table class="table table-striped table-bordered table-hover text-light">
      <thead class="thead-dark ">
      <th class="pb-0"></th>
      <th class="pb-0"></th>
        <th class="pb-0">CÉDULA</th>
        <th class="pb-0">NOMBRES</th> 
        <th  class="pb-0">DOMICILIO</th>
        <th  class="pb-0">TELÉFONO</th>
        <th  class="pb-0">CELULAR</th>
        <th  class="pb-0">REGISTRO</th>
        <th  class="pb-0">MODIFICADO</th>
      <tbody>
        <?php  
      
        foreach( $abogados as $it) :?>
        <tr> 
          <td class="text-center"><a class="text-light"  onclick="borrarAbogado(event)"  href="<?=url("abogados/delete/".$it->IDNRO)?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
          <td class="text-center"><a  class="text-light" onclick="editarAbogado(event)" href="<?=url("abogados/edit/".$it->IDNRO)?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
          <td>{{  $it->CEDULA  }}</td> 
          <td>{{$it->NOMBRE." ".$it->APELLIDO}}</td>
           <td>{{  $it->DOMICILIO  }}</td>  
           <td>{{  $it->TELEFONO  }}</td>  
           <td>{{  $it->CELULAR  }}</td>  
           <td>{{ Helper::beautyDate( $it->created_at)}}</td>  
           <td>{{  Helper::beautyDate($it->updated_at) }}</td>  
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>


    @if(  sizeof($abogados) > 0)
    {{$abogados->links() }}
    @else 
          <p>Sin registros</p>
    @endif


    <script>
      


      //BORRA origen de demanda
function borrarAbogado( ev){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault();
let divname="#viewform"; 
if(  ! confirm("SEGURO QUE QUIERE BORRARLO?") ) return;
$.ajax(
     {
       url:  ev.currentTarget.href,
       method: "get", beforeSend: function(){
         $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: function(res){
        $( divname).html( "");
           let r= JSON.parse(res);
           if("error" in r)   alert( r.error) ;
            act_grilla();
       },
       error: function(){
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}/*****end ajax call* */

 
function editarAbogado( ev){//Objeto event   DIV tag selector to display   success handler
    ev.preventDefault();
    let divname="#viewform";  
    $.ajax(
        {
          url:  ev.currentTarget.href,
          method: "get",
          beforeSend: function(){
                 $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
                 $("#modal-form").modal("show");  
          },
          success: function(res){
                $( divname).html( res); 
                $("#modal-form").modal("show");  
          },
          error: function(){ 
            $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" );
            $("#modal-form").modal("show");        
             }
        }
      );
}/*****end ajax call* */

    </script>