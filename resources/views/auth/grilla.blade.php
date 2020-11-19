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


<table class="table table-striped  table-dark text-light">

      <thead class="thead-dark ">
      <th class="pb-0 text-center"></th>
      <th class="pb-0 text-center"></th>
        <th class="pb-0 text-center">NICK</th>
        <th class="pb-0 text-center">TIPO</th> 
        <th  class="pb-0 text-center">CREACIÓN</th>
        <th  class="pb-0 text-center">ACTUALIZADO</th>

      <tbody>
        <?php  foreach( $users as $it) :?>
        <tr  style="background-color: rgba(0, 150, 166, 0.12);"> 
          <td class="text-center"><a  class="text-light" onclick="borrar_user(event)"  href="<?=url("del-user/".$it->IDNRO)?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
          <td class="text-center"><a  class="text-light" onclick="editar_user(event)" href="<?=url("edit-user/".$it->IDNRO)?>" ><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
          <td class="text-center">{{$it->nick}}</td>
           <td class="text-center">
             {{  $it->tipo }}
            </td>  
           <td class="text-center">{{ Helper::beautyDate( $it->created_at)}}</td>  
           <td class="text-center">{{  Helper::beautyDate($it->updated_at) }}</td>  
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>


    <script>
      


      //BORRA origen de demanda
function borrar_user( ev){//Objeto event   DIV tag selector to display   success handler
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
           if("ok" in r) alert( r.ok); 
            else alert( r.error) ;
            act_grilla();
       },
       error: function(){
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}/*****end ajax call* */

 
function editar_user( ev){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault();
let divname="#viewform2";  
$.ajax(
     {
       url:  ev.currentTarget.href,
       method: "get",
      beforeSend: function(){     $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: function(res){    $( divname).html( res);   },
       error: function(){ $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" );       }
     }
   );
}/*****end ajax call* */

    </script>