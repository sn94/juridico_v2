<h4 class="text-center">Detalle de pago</h4>

<form  onsubmit="pagar(event)" action="<?=url("p/pago")?>"  method="post"  style="padding: 3px;"  >

@csrf


<input type="hidden" name="FECHA"  value="{{date('Y-m-d')}}">
<input type="hidden" name="CLIENTE"  value="{{$IDCLIENTE}}">
<div class="input-group">
<input   class="form-control  form-control-sm"  maxlength="20" class="input--style-1" type="text" placeholder="N° comprobante" name="COMPROBANTE">
</div>
					  
              
<div class="p-t-20">
<button id="btnGUARDAR" class="btn btn-primary" type="submit">Aceptar</button>
</div>


</form>

<script>

async function pagar( ev){
  ev.preventDefault();

//***************************** */
//Creando cliente
//*************************** */
    $( "#formstatus").html(  "<div  style='z-index:10000; position: absolute; left: 45%;'   class='spinner mx-auto'><div class='spinner-bar'></div></div>" );
    let config= { method: 'POST',  body: $(ev.target).serialize(), headers: { 'Content-Type':'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }  } ;
    
    let peticion1= await fetch( ev.target.action,  config );
    let respuesta1= await peticion1.json();
    console.log(respuesta1);
    if( "idnro" in respuesta1 )
     {      
        $("#formstatus").html(    "" );
        if( "actualizarGrilla" in window)  actualizarGrilla();
        }
    else   $("#formstatus").html(  respuesta1.error );
    
}

</script>