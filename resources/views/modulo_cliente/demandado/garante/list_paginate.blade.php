@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">DEMANDAS</li> 
<li class="breadcrumb-item active" aria-current="page">CO-DEUDORES</li> 
@endsection

@section('content')

<style>
  .busqueda{
 background-position: left center;
  
 padding-left: 17px;
  
 width:183px;
  
 background-image: url(<?= url("assets/img/search18.png")?>);
  
 background-repeat: no-repeat;
border:none;
 }

</style>
<a href="<?=url("ldemandados")?>" class="btn btn-success btn-sm">BUSCAR DEUDORES</a>

<div class="input-group mb-2 mt-3">
  <div class="input-group-prepend">
    <button  onclick="buscar()" class="btn btn-success" type="button"><i class="fa fa-search" aria-hidden="true"></i>
</button>
  </div>
  <input id="argumento" onkeydown="buscarRegs(event)" type="text" class="form-control" placeholder="buscar" aria-label="" aria-describedby="basic-addon1">
</div>

 
<!--
<input style="width:100%;"  placeholder="buscar" class="busqueda col-12 col-md-3 form-control form-control-sm m-md-0 " type="text"  id="argumento" oninput="buscarRegs(this)">
-->
  
 
<div id="tabla-dinamica" class="table-responsive" style="width: 100%;">

@include("demandado.garante.list_paginate_ajax", ["lista"=>$lista]  )

</div> 


  <script> 

function buscar( ){
  $.ajax({
    url: "<?=url("lgarantes")?>/"+$("#argumento").val(),
       success: function(res){
         $("#tabla-dinamica").html(  res );
       }
     });
}
  function buscarRegs(ev){
 
if( ev.keyCode==13){
  let target=  ev.target;
  buscar();
}
  }/** */
 
  
 
function jsonReceiveHandler( data){// string JSON to convert     div Html Tag to display errors
  try{
             let res= JSON.parse( data);
             if( "error" in res){
               alert( res.error ); return false; 
             }else{   return res;  }
           }catch(err){
             alert(   err);  return false;
           } return false;
}/***End Json Receiver Handler */

       function procesar_borrar(ev, ci){
          ev.preventDefault();  
          let url_= ev.currentTarget.href; 
          let nro_juicio= $("#"+ci).children()[6].textContent;//nro de juicios
          if( nro_juicio=="0"){
            if ( confirm("Seguro que desear eliminar este registro?") ){
              $.ajax(  {
                  url: url_,
                  success: function(res){ 
                      let r= jsonReceiveHandler( res );
                      if( typeof r != "boolean"){
                          if( "error" in r) alert( r.error);
                          else {
                            alert("Datos personales del CI° "+r.ci+" fueron borrados.");
                            $("#"+r.ci).remove();
                            } 
                      }
                  }, 
                  error: function(xhr){    alert("Problemas de conexión . "+ xhr.responseText);  }
              })
          }
          }/**end verifi nro juicio */
          else alert("No se puede borrar. Registros de juicio existentes")
         
      }
   
  </script>
  
@endsection


