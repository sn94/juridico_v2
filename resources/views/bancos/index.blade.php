@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">BANCOS</li> 
<li class="breadcrumb-item" aria-current="page">INICIO</li> 
@endsection

@section('content')

 
<a style="background-color: #a3c5fc;color:#01001c;" onclick="mostrar_form(event)" data-toggle="modal" data-target="#showform"  href="<?=url("nbank")?>"  class="btn btn-sm btn-success">NUEVA CTA.</a>
<div id="viewstatus"></div>
<div id="grilla">
@include("bancos.grilla")

</div>


<div id="showform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" id="viewform">
      
    </div>
  </div>
</div>


<!-- MODAL TIPO DE INFORME -->
<div id="show_opc_rep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
    <a  id="info-xls" onclick="callToXlsGen(event, 'MOVIMIENTOS DE CTAS DE BANCO')" class="btn btn-sm btn-info" href="#" ><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <h3>EXCEL</h3></a>
   
    <a  id="info-pdf"  class="btn btn-sm btn-info" href="#"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><h3>PDF</h3></a>
    <a  id="info-print" onclick="print_(event)" class="btn btn-sm btn-info" href="#"><i class="fa fa-print fa-2x" aria-hidden="true"></i><h3>Printer</h3></a>
    </div>
  </div>
</div>

 

    
@endsection


<script>

/**VALIDACIONES */
    
function solo_numero(ev){
   
   if(  ev.data == undefined  ||  ev.data == null)  return;
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

  function quitarSeparador( ele){ 
return ele.replaceAll(/\./g , "");
}


funxction mostrar_form(ev){
let divname= "#viewform";
  $.ajax(
       {
         url:  ev.currentTarget.href, 
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function(res){  $(divname).html(  res );
         },
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );
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

function borrar(ev){
    ev.preventDefault();
if( !confirm("SEGURO QUE DESEA BORRARLO?") ) return;
let divname= "#viewstatus";
  $.ajax(
       {
         url:  ev.currentTarget.href, 
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function(res){  
            let r= jsonReceiveHandler( res );
                      if( typeof r != "boolean"){
                          if( "error" in r) alert( r.error);
                          else{ 
                            alert("CUENTA BORRADA.");
                            $("#"+r.IDNRO).remove();
                            }
                      }/************* */
         },
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );
}


function actualizar_grill(){
  $.ajax({
    url: "<?=url("lbank")?>",
    beforeSend: function(){  $("#grilla").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" )},
    success: function(resu){ $("#grilla").html( resu)  ; },
    error: function(){$("#grilla").html( "<h6>Error al recuperar datos</h6>")  ;}
  })
}



function noempty_fields(){
  if($("input[name=TITULAR]").val() =="") alert("FALTA NOMBRE DEL TITULAR!");
  if($("input[name=CUENTA]").val() =="") alert("FALTA EL NUMERO DE CUENTA!");
  if($("input[name=BANCO]").val() =="") alert("FALTA EL BANCO!");
  return !($("input[name=TITULAR]").val()=="" || $("input[name=CUENTA]").val() =="" || $("input[name=BANCO]").val() =="" );
}


function ajaxCall( e, divnam, succes){

  let divname=divnam;
  $.ajax(
       {
         url:  e.target.action,
         method: "post",
         data: $("#"+e.target.id).serialize(),
         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: succes,
         error: function(){  $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" );   }
       }
     );
}
function guardar( ev ){//Objeto event   DIV tag selector to display   success handler
ev.preventDefault();
if ( ! noempty_fields( )) return;
 
 ajaxCall( ev, "#mensaje", function(res){
          let respuesta= JSON.parse(res);
          if ("ok" in respuesta)
           { $( "#mensaje").html( respuesta.ok );  $("#showform").modal("hide"); actualizar_grill(); }
         else{ $( "#mensaje").html( ""); alert( respuesta.error);}
            
         });
}/*****end ajax call* */

function depositar( ev ){//Objeto event   DIV tag selector to display   success handler
   
if( $("#formmovi input[name=IMPORTE]").val()==""){ alert("INGRESE EL IMPORTE!"); return;}
if( ! confirm("CONTINUAR?") ) return;
if ( ! noempty_fields( )) return;
if( ! confirm("CONTINUAR?") ) return;
$("#formmovi input[name=IMPORTE]").val(  quitarSeparador( $("#formmovi input[name=IMPORTE]").val()   )  );
 ajaxCall( ev, "#mensaje-movi", function(res){
            $( "#mensaje-movi").html(JSON.parse(res).ok ); 
           // $('#showform').modal('hide')
            actualizar_grill();
         });
}/*****end ajax call* */

function extraer( ev ){//Objeto event   DIV tag selector to display   success handler
  
if( $("#formmovi input[name=IMPORTE]").val()==""){ alert("INGRESE EL IMPORTE!"); return;}
 
if ( ! noempty_fields( )) return;
if( ! confirm("CONTINUAR?") ) return;
$("#formmovi input[name=IMPORTE]").val(  quitarSeparador( $("#formmovi input[name=IMPORTE]").val()   )  );
 ajaxCall( ev, "#mensaje-movi", function(res){
            $( "#mensaje-movi").html(JSON.parse(res).ok );  
            actualizar_grill();
         });
}/*****end ajax call* */


function movimiento(ev){
  ev.preventDefault();
  if( $("#formmovi input[name=IMPORTE]").val()==""){ alert("INGRESE EL IMPORTE!"); return;}
 
if ( ! noempty_fields( )) return;
if( ! confirm("CONTINUAR?") ) return;
$("#formmovi input[name=IMPORTE]").val(  quitarSeparador( $("#formmovi input[name=IMPORTE]").val()   )  );
 ajaxCall( ev, "#mensaje-movi", function(res){
            $( "#mensaje-movi").html(JSON.parse(res).ok ); 
           // $('#showform').modal('hide')
            actualizar_grill();
         });
}




function print_( e){
  e.preventDefault();
  $.ajax({
    url:  e.currentTarget.href,
    success: function(html){
      printDocument(html);
    }
  }) ;
}

function printDocument( html){
   
  
   //print
 let documentTitle="ARREGLOS EXTRAJUDICIALES";
 var ventana = window.open( "", 'PRINT', 'height=400,width=600,resizable=no');
 ventana.document.write("<style> @page   {  size:  auto;   margin: 0mm;  margin-left:10mm; }</style>");
 ventana.document.write( html);
 ventana.document.close(); 
   ventana.focus();
 ventana.print();
 ventana.close();
 return true;
 }



function mostrar_informe(ev){
    ev.preventDefault();
    let report_path= ev.currentTarget.href; 
    let id= (ev.currentTarget.parentNode.parentNode.id) ==undefined ? "" :  (ev.currentTarget.parentNode.parentNode.id) ;// TR ID 
     let xlsr= id == "" ?  report_path+"/xls" : report_path+"/"+id+"/xls";
     let pdfr= id == "" ?  report_path+"/pdf" : report_path+"/"+id+"/pdf";
     let printr= id == "" ?  report_path+"/PRINT" : report_path+"/"+id+"/PRINT";
     $("#info-xls").attr("href", xlsr );
     $("#info-pdf").attr("href", pdfr  );
     $("#info-print").attr("href", printr  );
 
 //   ev.currentTarget.href.concat( id ) ;
  }



</script>

