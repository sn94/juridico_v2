@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">MENSAJES</li>  
@endsection

@section('content')
    

<input type="hidden" id="tipo"  value="{{$tipo}}">


<a onclick="mostrar_form(event)"  data-toggle="modal" data-target="#showform" href="{{ url('nuevo-msg')}}" class="btn btn-sm btn-info"><i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i>
Nuevo</a>

<div id="spinnershow"></div>
<div id="grilla">
@include("messenger.grilla" )
</div>
 


<!--MODAL FORMULARIO -->
<div id="showform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content p-0" id="viewform">
      
    </div>
  </div>
</div>
@endsection 

<script>

 /**mostrar formulario para nuevo mensaje */

 function mostrar_form(ev){
   ev.preventDefault();
let divname= "#viewform";
  $.ajax(
       {
         url:  ev.currentTarget.href, 
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function(res){  $(divname).html(  res ); CKEDITOR.replace( 'editor' );
         },
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );
}


function actualizar_grill(){
  $.ajax({
    url: "<?= $url_listado?>",
    beforeSend: function(){  $("#grilla").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" )},
    success: function(resu){ $("#grilla").html( resu)  ; },
    error: function(){$("#grilla").html( "<h6>Error al recuperar datos</h6>")  ;}
  })
}

 

//inserta, modifica registros de parametros y origen de demanda
function ajaxCall( ev, divname){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault();  
 
$("#editor").text( CKEDITOR.instances.editor.getData());
 $.ajax(
     {
       url:  ev.target.action,
       method: "post",
       data: $("#"+ev.target.id).serialize(),
       headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
       beforeSend: function(){
         $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: function(res){ 
           let r= JSON.parse(res);
           if("ok" in r)  
           $( divname).html("<div class='m-1 alert alert-success'><i class='fa fa-check-circle-o fa-lg' aria-hidden='true'></i>"+r.ok+"</div>");
          else   $( divname).html("<div class='alert alert-danger'>"+r.error+"</div>");
          //actualizar_grill();
          window.location="<?=url("list-msg/E")?>";
       },
       error: function(){
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}/*****end ajax call* */





function leer(ev){

ev.preventDefault();
let leermsg=ev.currentTarget.href;
let checkbox= ev.currentTarget.parentNode.parentNode.children[4].children[0];
 
let divname= "#viewform";
$.ajax(
       {
         url: leermsg,  
         beforeSend: function(){
           $( divname).html(  "<div style='z-index:8000;' class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function(r){    
           $( divname).html(r); 
           //checkbox.checked="checked"; 
           if( $("#tipo").val() == "R")
           actualizar_grill();
            },
         error: function(){  $( divname).html( "");   }
       }
     );
}
function borrar(ev){
    ev.preventDefault();
if( !confirm("SEGURO QUE DESEA BORRARLO?") ) return;
let divname= "#spinnershow";
  $.ajax(
       {
         url:  ev.currentTarget.href, 
         dataType: 'json',
         beforeSend: function(){
           $( divname).html(  "<div style='z-index:8000;' class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function(r){    
                          if( "error" in r) alert( r.error);
                          else{ 
                            alert("MENSAJE BORRADO.");
                            $("#"+r.IDNRO).remove();
                            }
                            $( divname).html( "");
         },
         error: function(){
          $( divname).html( "");
          alert(  "Problemas de conexión" ); 
         }
       }
     );
}


/***VALIDACIONES**
 */
function number_field(ev){
  if( ev.data == undefined ) return;
  if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart );
    }
}

function decimal_field(ev){
  if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
    if(  ev.data.charCodeAt() == 46) return;
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart );
    }
}


/**Forma una cadena numerica con separador de miles */
function formatear(ev){
    console.log( ev.target.selectionStart, ev);
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart );
    }
     
    let val_Act= ev.target.value;  
  val_Act= val_Act.replaceAll( new RegExp(/[\.]*[,]*/), ""); 
    let enpuntos= new Intl.NumberFormat("de-DE").format( val_Act);
		$( ev.target).val(  enpuntos);
	} 


</script>