@extends('layouts.app')

@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">BANCOS</li> 
<li class="breadcrumb-item" aria-current="page">INFORMES</li> 
@endsection

@section('content')

 
<form id="bancos-search" action="<?=url("bank-informes")?>" method="post"  onsubmit="actualizar_grill_parametros(event)">
@csrf  
 
<!--Parametros de fecha --> 
<div class="row">
<div class="col-12 col-sm-4 col-md-4  col-lg-2">
<span style="font-size: 10pt; font-weight: 600; "> NÚMERO CUENTA </span> 
    <input type="text" name="CUENTA"   class="form-control form-control-sm" >
  </div>

<div class="col-12 col-sm-4 col-md-4  col-lg-3 no-gutters">
<span style="font-size: 10pt; font-weight: 600; ">Desde:</span> 
<input class="form-control form-control-sm" type="date" id="Desde" name="Desde"> 
</div>
   
<div class="col-12 col-sm-4 col-md-4 col-lg-3">
<span style="font-size: 10pt; font-weight: 600;">Hasta: </span>
 <input class="form-control form-control-sm"  type="date" id="Hasta" name="Hasta" >
  </div>
  <div class="col-12 col-sm-2 col-md-2 col-lg-1 d-flex">
 <button   type="submit" class="btn btn-sm btn-primary mt-1">BUSCAR</button>
  </div>
</div>
</form>

<a  id="info-print"  data-target="#show_opc_rep" data-toggle="modal" style="color: black;" href="#">
<i class="fa fa-print fa-2x" aria-hidden="true"></i></a>
 
 <div id="viewstatus"></div>
<div id="grilla">
@include("bancos.grilla_plain")

</div>
 
<!-- MODAL TIPO DE INFORME -->
<div id="show_opc_rep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
    <a  id="info-xls" onclick="download_excel(event)" class="btn btn-sm btn-info" href="<?=url("bank-informes/json")?>" ><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <h3>EXCEL</h3></a>
   
    <a  id="info-pdf" onclick="download_pdf(event)"  class="btn btn-sm btn-info" href="#"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><h3>PDF</h3></a>
    <a  id="info-print" onclick="printDocument()" class="btn btn-sm btn-info" href="#"><i class="fa fa-print fa-2x" aria-hidden="true"></i><h3>Printer</h3></a>
    </div>
  </div>
</div>

 
@endsection


<script>


function quitarSeparador( ele){ 
return ele.replaceAll(/\./g , "");
}


function  totalizar(){
  let depo= 0; let extr= 0;
  let saldo=0;
 let tabla= document.querySelector("#grilla table tbody").children;

 Array.prototype.forEach.call(   tabla,  function(FILA){

  let columnas= FILA.children;
  let depos= quitarSeparador( columnas[3].textContent );
  let extra= quitarSeparador(  columnas[4].textContent );
  depo+= parseInt( depos);
  extr+= parseInt( extra);
 });
 console.log(  depo, extr );

}
function printDocument( datajson, cssStyle){

  let rowconstr= function( reg, th){
    let thMode=  ( th == undefined) ? false :  th;
    let cols= Object.keys(reg);
    let nrocols=  cols.length;
    let html_row= "<tr>";
    let tds= cols.map(function(arg){
      let valor= reg[arg];
      let cssname=  arg.toLowerCase();
     if( !thMode)
      return "<td class='"+cssname+"'>"+valor+"</td>";
      else
      return "<th class='"+cssname+"'>"+arg+"</th>";
    });
    html_row+=  tds.join("");
    html_row+="</tr>";
    return html_row;
  };/******* */

  let style= cssStyle==undefined  ? '<style type="text/css" media="print"> @media print {  tr{ color: black;}  } </style>' : cssStyle;
      let elemento= document.getElementById("grilla");
      var ventana = window.open('', 'PRINT', 'height=400,width=600');
      ventana.document.write( style); //Aquí agregué la hoja de estilo
      ventana.document.write('<html><head><title>' + document.title + '</title>');
      ventana.document.write('</head><body >');

  if(  datajson== undefined){
      ventana.document.write(elemento.innerHTML);
  }//end json undefined case  
  else{
    ventana.document.write('<table><thead>');
    //Formar cabeceras
    let header_names=  Object.keys(  datajson[0]  );
    ventana.document.write(    rowconstr(  datajson[0] , true ));
    ventana.document.write( "</thead><tbody>");
//TABLE BODY
    let windowObjectProxi= ventana.document;
    datajson.forEach( function(registro){
        let tr= rowconstr( registro );
        windowObjectProxi.write( tr);
    });
 
    ventana.document.write('</tbody></table >');
  }

  ventana.document.write('</body></html>');
  ventana.document.close();
  ventana.focus();
  ventana.print();
  ventana.close();
  return true;

}
 
function download_excel( e){
  e.preventDefault();
  let formu=document.getElementById("bancos-search");

  ajaxCall("<?=url("bank-informes")?>/json", "#status", function(res){
    $( "#status").html("");
    callToXlsGen_with_data("MOVIMIENTOS DE CTAS.BANCARIAS", res)
  },   $(formu).serialize())
}


function download_pdf( e){
  e.preventDefault();
  let formu=document.getElementById("bancos-search");
  let respath=   "<?=url("bank-informes")?>"
  formu.target="_blank";
  formu.action=  "<?=url("bank-informes/pdf")?>"
  formu.submit();
  formu.action= respath;
  let divname="#status";
}

function jsonDownload( e){
  if( e != undefined)
  e.preventDefault();

  let formu=document.getElementById("bancos-search");
  $.ajax({
    url: "<?=url('bank-informes/pdf')?>",
  headers: {"Content-type": "application/pdf"},
   method: "post", 
   responseType: "arraybuffer",
    data: $(formu).serialize(),
    success: function( data){
      var pdffile= new Blob( [data] , { type: "application/pdf"} );
      var pdfUrl= URL.createObjectURL( pdffile );
      printJS(  pdfUrl);
   /*   printJS( 
         {printable: data,   type: 'json', 
         properties:[  'TITULAR','BANCO','CUENTA','DEPÓSITO','EXTRACCIÓN','FECHA' ],
         gridStyle: 'padding:0px;'  });*/
/*
let nl=  data.filter(function(w, inde){
  return inde   <=  1000;
})
      printJS( 
         {printable: nl,   type: 'json', 
         properties:[  'CI','NOMBRES','DEPARTAMENTO' ],
         gridStyle: 'padding:0px;'  });*/
    }
  }
  );
   
}


function ajaxCall( e, divnam, succes){

let urL= e;
if( typeof e == "object")  urL= e.target.action;

let divname=divnam;
$.ajax(
     {
       url:  urL,
       method: "post",
       data: $("#bancos-search" ).serialize(),
       headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
       beforeSend: function(){
         $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: succes,
       error: function(){
         $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}



function actualizar_grill_parametros(e){ 
  e.preventDefault(); 
  //if( $("#Desde").val()  != "" && $("#Hasta").val()  != "")
  ajaxCall(e, "#grilla", function(resu){ $("#grilla").html( resu)  ; } );
  //else
  //alert("Proporcione las fechas")
}

</script>

