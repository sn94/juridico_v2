 
 <?php  use App\Helpers\Helper;  ?>
 
  <form  id="formExtrajudi"   method="post" action="<?= url("arreglo_extra")?>" onsubmit="enviarExtrajudi(event)">

  

   
    <div class="row">
    <?php if( $OPERACION != "V"): ?>
      <div class=" col-12 col-md-1">
      <button type="submit" class="btn btn-primary btn-sm" >Guardar</button>
      </div>
      
      <?php endif; ?>
     
    </div>
     
        <div class="toast" role="alert" aria-live="polite" aria-atomic="true" data-delay="1000">
        <div role="alert" aria-live="assertive" aria-atomic="true" id="extra-msg">GUARDADO</div>
        </div>
       




  {{csrf_field()}} 

<div id="extrajudicial-panel">
</div>

<input id="IDNRO4"  type="hidden" name="IDNRO" value="{{ isset($id_demanda) ? $id_demanda:''}}"> 

 


<div class="row">

<div class="col-12 col-md-3">
<div class="form-group">
          <label for="ctactecatas">Tipo de arreglo extrajudicial:</label>
          <input maxlength="20" name="TIPO"   value="{{ isset($ficha5)? $ficha5->TIPO : '' }}" type="text"  class="form-control form-control-sm"> 
</div>
</div>



<div class="col-12 col-md-3">
<div class="form-group">
          <label for="ctactecatas">Importe total del arreglo:</label>
          <input maxlength="10" oninput="formatear(event)" value="{{isset($ficha5)? $ficha5->IMPORTE_T : '' }}"   name="IMPORTE_T"  type="text"   class="form-control form-control-sm number-format"> 
</div>
</div>

<div class="col-12 col-md-3">
<div class="form-group">
          <label for="ctactecatas">Cantidad de cuotas:</label>
          <input maxlength="3" oninput="solo_numero(event)" value="{{ isset($ficha5)? $ficha5->CANT_CUOTAS : '' }}"  name="CANT_CUOTAS" type="text"   class="form-control form-control-sm"> 
</div>
</div>

@if($OPERACION=="A"  ||  $OPERACION=="A+" ||  $OPERACION=="M" )
<div class="col-12 col-md-3 d-flex align-items-center">
<button onclick="calcular_cuotas()" type="button" class="btn btn-sm btn-info">GENERAR CUOTAS</button>
</div>
@endif
</div>

@if( $OPERACION == "M" || $OPERACION == "V")
  <a  class="btn btn-sm btn-danger"   href="<?=url("ver-recibos/".(isset($id_demanda) ? $id_demanda:'') )?>">Recibos</a>
@endif 

<table id="arreglojudi" class="table table-bordered">
  <thead><th>CUOTA</th><th>VENCIMIENTO</th><th>IMPORTE</th><th>FECHA_PAGO</th></thead>
  <tbody>

  
 <?php
  if(isset($ficha5)):
 
  foreach( $ficha5->arreglo_extra_cuotas as $it):

    if($it->FECHA_PAGO ==""  ||  $it->FECHA_PAGO == '0000-00-00')
      echo "
      <tr><td style='text-align: center;'><input value='{$ficha5->IDNRO}' type='hidden' name='DETALLE[ARREGLO][]'>
      <input value='{$it->IDNRO}' type='hidden' name='DETALLE[IDNRO][]'>{$it->NUMERO}</td>
      <td><input class='form-control form-control-sm' value='{$it->VENCIMIENTO}' name='DETALLE[VENCIMIENTO][]' type='date' /></td>
      <td><input style='text-align:right;' name='DETALLE[IMPORTE][]' type='text' value='". Helper::number_f($it->IMPORTE)."' class='form-control form-control-sm number-format'  readonly value='{$it->IMPORTE}'> </td>
      <td><input class='form-control form-control-sm' value='{$it->FECHA_PAGO}' type='date' name='DETALLE[FECHA_PAGO][]' /></td>
      </tr>";
 
  endforeach;
  endif; 
  ?>
  </tbody>
</table>
 



  </form>
  <script> 
  if( document.getElementById("operacion").value=="A" || document.getElementById("operacion").value=="A+")
  habilitarCampos('formExtrajudi',false);

  if( document.getElementById("operacion").value=="M"  )
  habilitarCampos('formExtrajudi',true);

  if( document.getElementById("operacion").value=="V"  )
  habilitarCampos('formExtrajudi',false);



  function calcular_cuotas(){
    $("#arreglojudi tbody").empty();
    let importe=$("#formExtrajudi input[name=IMPORTE_T]").val();
    let cant_c= $("#formExtrajudi input[name=CANT_CUOTAS]").val();
    importe= numeroSinFormato( importe);
    cant_c= numeroSinFormato( cant_c);

    let importe_cuota= parseInt( importe) /parseInt( cant_c);
    importe_cuota=  Math.round( importe_cuota);
    importe_cuota= numero_con_puntuacion(importe_cuota);
    let idnro= $("#formExtrajudi input[name=IDNRO]").val();
    //Agregar filas
    for( let i=0; i< parseInt(cant_c) ; i++){
      
      let input_id_cuota="<input value='"+idnro+"' type='hidden' name='DETALLE[ARREGLO][]'><input type='hidden' name='DETALLE[IDNRO][]'>";
      let input_fec_venci="<input class='form-control form-control-sm' name='DETALLE[VENCIMIENTO][]' type='date' />";
      let input_importe="<input   style='text-align:right;'  name='DETALLE[IMPORTE][]' type='text'  class='form-control form-control-sm number-format'  readonly value='"+importe_cuota+"'>";
      let input_fec_pago="<input class='form-control form-control-sm' type='date' name='DETALLE[FECHA_PAGO][]' />";
      
      $("#arreglojudi tbody")
      .append("<tr><td style='text-align: center;'>"+input_id_cuota+" "+(i+1)+"</td><td>"+input_fec_venci+"</td><td>"+input_importe+"</td><td>"+input_fec_pago+"</td> </tr>");
    }
    
  }


function limpiarNumericos(){
  $("#formExtrajudi .number-format").each( function( indice, obj){    quitarSeparador( obj); } );
}

function rec_formato_numerico_extraju(){ 
  $("#formExtrajudi .number-format").each( function( indice, obj){    numero_con_puntuacion( obj); } );
}


function campos_vacios_extrajudi(){
  if( ( $("#formExtrajudi input[name=IMPORTE_T]").val()=="" || $("#formExtrajudi input[name=IMPORTE_T]").val()=="0") 
  && ($("#formExtrajudi input[name=CANT_CUOTAS]").val()=="" ||  $("#formExtrajudi input[name=CANT_CUOTAS]").val()=="0"  )  )
 { alert("COMPLETE LOS CAMPOS POR FAVOR"); return true;}
 else{
   if( document.querySelector("#arreglojudi tbody").children.length<=0  )
   {  alert("GENERE LAS CUOTAS"); return true;}
   else{
     return false;
   }
 }
}



async function getBillData( ID_RECIBO){

    let urlBill= "<?=url('arregloextr-recibo')?>/"+ID_RECIBO+"/E";
    let respuesta= await fetch( urlBill);
    let html="";
    if( respuesta.ok)  html=  await respuesta.text();
    return html;
}
 
async function printBill( ID_RECIBO){
    let html= await getBillData( ID_RECIBO);
      //print
    let documentTitle="PAGOS"
    var ventana = window.open( "", 'PRINT', 'height=400,width=600,resizable=no');
    ventana.document.write( html);
    ventana.document.close(); 
    /*  ventana.focus();
    ventana.print();
    ventana.close();*/
    return true;
}

function enviarExtrajudi( ev){ //ENVIO DE FORM OBSERVACION
  
  ev.preventDefault();  
  if( campos_vacios_extrajudi() ) return;
        limpiarNumericos();
        $.ajax(
        {
          url:  ev.target.action,
          method: "post",
          data: $("#"+ev.target.id).serialize(),
          dataType: "json",
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          beforeSend: function(){
            $("#extrajudicial-panel").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
          },
          success: function( res ){
              if( "error" in res){
                $("#extrajudicial-panel").html(  "" ); 
                alert(res.error);
              }else{ 

                //Mostrar mensaje 
                $("#extrajudicial-panel").html( "" ); //mensaje 
                $("#juri-msg").text( "GUARDADO!");
                  $(".toast").toast("show"); 
                  rec_formato_numerico_extraju();

                  if( "print" in res){//Se recibio ID de recibo
                    if(confirm("IMPRIMIR RECIBO?") )
                      printBill( res.print);
                  }
              }
              
          },
          error: function(){
            $("#extrajudicial-panel").html( "" ); 
            alert("Problemas de conexión");
          }
        }
      );
}/** */


  </script>