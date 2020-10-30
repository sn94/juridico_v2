@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">CTAS.JUDICIALES</li> 
<li class="breadcrumb-item active" aria-current="page">MOVIMIENTOS</li> 
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



<button  onclick="verSaldos()" class="btn btn-danger btn-sm mb-2" data-toggle="modal" data-target="#showsaldo" >VER SALDO</button>

 <a href="<?= url("ncuentajudi/$id_demanda") ?>" class="btn btn-info btn-sm mb-2">AGREGAR</a>

 <div id="myform" style="background-color: #c2c9fe; "></div>

 
 <div class="table-responsive mt-2" id="tablamovi">
   @include("cta_judicial.grilla", ["movi"=> $movi])
     
 </div>

 



 <div id="showsaldo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" id="viewsaldo">
      
    </div>
  </div>
</div>


<script>

  var GrillaActualizada= false; 
 

    function borrar(ev){//form vista , edit

    ev.preventDefault();
    console.log( ev.target, ev.currentTarget);
      if(confirm("Seguro que desea borrarlo?")){
        $.ajax( {
            url: ev.currentTarget.href,
            success: function(res){ 
              let ob=JSON.parse( res );

               $("#myform").html( `
               <div class="alert alert-success">
              <h6>Movimiento borrado</h6>
              </div>
            ` ); 
              actualizarGrill();
               },
            beforeSend: function(){  
                  $("#myform").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" );       
            }, 
            error: function(err){  $("#myform").html( "<h6 style='color:red;'>"+err+"</h6>" ); }
        });
      }
    }




function actualizarGrill(){
  $.ajax( {
            url: "<?= url("lcuentajudi/$id_demanda")?>",
            success: function(res){  
               $("#tablamovi").html( res);  
               },
            beforeSend: function(){  
                  $("#tablamovi").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" );       
            }, 
            error: function(err){  $("#tablamovi").html( "<h6 style='color:red;'>"+err+"</h6>" ); }
        });
}

   
  /*
  Recibe una cadena de numeros
  Devuelve la cadena con separadores de puntos
  */
  function formatear_string(obj){
    let val_Act= String( obj);
    val_Act= val_Act.replaceAll( new RegExp(/[\.]*[,]*/), ""); 
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		return enpuntos;
	} 

  function jsonReceiveHandler( data, divname){// string JSON to convert     div Html Tag to display errors
  try{
             let res= JSON.parse( data);
             if( "error" in res){
               $( divname).html(  `<h6 style='color:red;'>${res.error}</h6>` ); return false; 
             }else{   return res;  }
           }catch(err){
             $(divname).html(  `<h6 style='color:red;'>${err}</h6>` );  return false;
           } return false;
}/***End Json Receiver Handler */


function verSaldos(){
let divname= "#viewsaldo";
  $.ajax(
       {
         url:  "<?=url("calcsaldo/$id_demanda/json")?>", 
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function(res){
           let r= jsonReceiveHandler( res);
           console.log( typeof  r.saldo);
           let formateado1= formatear_string( r.saldo_capital);
           let formateado2= formatear_string( r.saldo_liquida);
           if( typeof r != "boolean") $(divname).html(
             `
             <div style="background-color:red; padding: 30px;">
             <h3 class="text-white text-center" style="text-decoration:underline;">SALDO CAPITAL:</h3>
             <h3 class="text-white text-center">${ formateado1} Gs.</h3>
             <h3 class="text-white text-center" style="text-decoration:underline;">SALDO LIQUIDACION:</h3>
             <h3 class="text-white text-center">${ formateado2} Gs.</h3>
             </div>
             `
           );
           else $(divname).html(  "<h6 style='color:red;'>Error al obtener datos.</h6>" );
         },
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );
}
    


/**Verificar tabla vacia */


window.onload= function(){


  if( $("#tctajudicial tbody").children().length <= 0 )
  alert("NO SE REGISTRAN MOVIMIENTOS");

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