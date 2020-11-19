@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">DEMANDAS</li> 
<li class="breadcrumb-item active" aria-current="page">DEMANDADOS / JUICIO</li> 
@endsection

@section('content')

<?php

use App\Mobile_Detect; 

$detect= new Mobile_Detect();
if ($detect->isMobile() == false):?>
 <h4>{{ isset($ci) ? $ci." - ". $nombre  : ""}}</h4>  
<?php else: ?>
  <p class="name-titular">{{ isset($ci) ? $ci." - ". $nombre  : ""}}</p>  
<?php endif; ?>



 <!--Enlaces  --->
 
<a class="btn btn-primary btn-sm mb-1 mt-1" href="<?=url("demandas-agregar/$ci")?>">NUEVO JUICIO</a> 

<?php

use App\Helpers\Helper;

?>
<div id="tabla-dinamica">
    <table id="demandadostable" class="table table-bordered table-striped">
      <thead class="thead-dark pb-0 pt-0">
          <tr> 
            <th></th> 
            @if(  (session("tipo")=="S" || session("tipo")=="SA") || session("tipo")=="O") <th></th> @endif
            @if(   (session("tipo")=="S" || session("tipo")=="SA")  )  <th></th>  @endif
           
          <th class="pb-0 pt-0">DEMANDANTE</th>  
          <th class="pb-0 pt-0">COD_EMP</th> 
          <th class="pb-0 pt-0">ORIGEN</th> 
          <th class="pb-0 pt-0">PRESENTADO</th> 
          <th class="pb-0 pt-0">SD.FINIQ.</th>
          <th class="pb-0 pt-0">FECHA FINIQ.</th>
          <th class="pb-0 pt-0">SALDO CAPITAL</th>
          <th class="pb-0 pt-0">SALDO LIQUID.</th>
          </tr>
      </thead>
      <tbody>
      <?php for($x=0; $x< sizeof($lista); $x++):
        $item= $lista[$x];    ?>
          <tr id="{{$item->IDNRO}}"> 

            <td><a href="<?= url("ficha-demanda/".$item->IDNRO)?>"><i  style="color:black;" class="fa fa-eye" aria-hidden="true"></i></a> </td> 
            
            @if(   (session("tipo")=="S" || session("tipo")=="SA")  || session("tipo")=="O")
            <td><a href="<?= url("demandas-editar/".$item->IDNRO)?>"><i   style="color:black;" class="fa fa-pencil" aria-hidden="true"></i></a> </td>
            @endif 
            @if(session("tipo")=="S" || session("tipo")=="SA") 
            <td >  <a onclick="procesar_borrar(event)" href="<?= url("demandas-borrar/".$item->IDNRO)?>"><i  style="color:black;" class="fa fa-trash" aria-hidden="true"></i></a> </td> 
           @endif

            <td >  <?= $item->DEMANDANTE?> </td>
            <td><?= $item->COD_EMP?></td>  
            <td > <?= $item->O_DEMANDA?></a> </td>
             <td>   {{ Helper::beautyDate(  $item->PRESENTADO)  }} </td>
             <td>{{$item->SD_FINIQUI}}</td>
             <td>{{ Helper::beautyDate($item->FEC_FINIQU) }}</td>
             <td class="text-right">{{Helper::number_f($saldos[$x]["saldo_capital"])}}</td>
             <td class="text-right" >{{Helper::number_f($saldos[$x]["saldo_liquida"])}}</td>
                </tr>
      <?php  endfor; ?>
      </tbody>
      </table>
  </div>


  <script>



var GrillaActualizada= false; 


function jsonReceiveHandler( data){// string JSON to convert     div Html Tag to display errors
  try{
             let res= JSON.parse( data);
             if( "error" in res){
               alert(  res.error ); return false; 
             }else{   return res;  }
}catch(err){
             return false;
           } return false;
}/***End Json Receiver Handler */


      function procesar_borrar(ev){
          ev.preventDefault();
          let url_= ev.currentTarget.href;
          if (confirm("Seguro que desear eliminar este registro?") ){
              $.ajax(  {
                  url: url_,
                  statusCode: {
                  302: function() {
                    alert( "Acceso no autorizado" );
                  }
                },

                  success: function(res, textstatus, xhr){
                 
                 

                   let r= jsonReceiveHandler( res );
                      if( typeof r != "boolean"){
                          if( "error" in r) alert( r.error);
                          else{ 
                            alert("Registros de juicio fueron borrados.");
                            $("#"+r.id_deman).remove();
                            }
                      }
                  }, 
                  error: function(xhr){    alert("Problemas de conexión . "+ xhr.responseText);  }
              })
          }
      }

      function actualizarGrill(){
  $.ajax( {
            url: "<?= url("demandas-by-id/$idnro")?>",
            success: function(res){  
               $("#tabla-dinamica").html( res);  
               },
            beforeSend: function(){  
                  $("#tabla-dinamica").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" );       
            }, 
            error: function(err){  $("#tabla-dinamica").html( "<h6 style='color:red;'>"+err+"</h6>" ); }
        });
}

window.onload= function(){

  window.onfocus= function(){
 
 if( !GrillaActualizada){
   actualizarGrill();
   GrillaActualizada=  true;
 }

};  
  window.onmouseenter= function(){
 
 if( !GrillaActualizada){
   actualizarGrill();
   GrillaActualizada=  true;
 }

};
  window.onmouseover= function(){
 
  if( !GrillaActualizada){
    actualizarGrill();
    GrillaActualizada=  true;
  }

};

window.onmouseleave= function(){
  console.log("leave");
  GrillaActualizada= false;
};

window.onblur= function(){

  GrillaActualizada= false;
};

window.onbeforeunload= function(){

GrillaActualizada= false;
};

};

  </script>
@endsection