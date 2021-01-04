<form style="background-color: #8ba3fe; border-radius: 20px;" class="p-2"  id="form-freeuser" action="<?= url("recibos-free/nuevo") ?>" method="POST" onsubmit="guardar_recibo(event)">


    @csrf
 
        <h5>Llena los datos del recibo</h5>
        <input type="hidden" name="FREEUSER" value="<?= session("freeuser") ?>">
        <label for="">Fecha</label>
        <input class="form-control" type="date" name="FECHA" id="FECHA"  value="{{date('Y-m-d')}}">

        <label for="">Nombre completo/Razón Social</label>
        <input maxlength="70" class="form-control" type="text" id="CLIENTE" name="CLIENTE">
      
        <label for="">Concepto</label>
        <textarea maxlength="250"  class="form-control" id="CONCEPTO" name="CONCEPTO"   cols="30" rows="5"></textarea>
       
        <label for="">Importe</label>
        <input maxlength="10" oninput="formatear(event)" id="IMPORTE" class="form-control" type="text" name="IMPORTE">

        <button type="submit"  class="btn btn-success">Generar recibo</button>
    

</form>
<script>
 

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
    async function guardar_recibo(ev) {

        ev.preventDefault();

        if( $("#FECHA").val()==""  ||$("#CLIENTE").val()==""  || $("#CONCEPTO").val()==""   || $("#IMPORTE").val()==""   ){
            alert("Por favor llene todos los campos"); return;
        }
        let dat = $("#form-freeuser").serialize();

        let req = await fetch(ev.target.action, {
            method: "POST",
            body: dat,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded', 'X-CSRF-TOKEN': $("#form-freeuser input[name=_token]").val()
            }
        });
        let resp = await req.json();
        if ("ok" in resp) {
           // $("#content").html("Recibo guardado, imprimiendo ..");
           //limpiar
           $("input[name=CLIENTE],textarea[name=CONCEPTO],input[name=IMPORTE]" ).val("");
            let id_recibo=   resp.ok;
            imprimir_recibo(  id_recibo);
           // let res= $("#print-recibo").val()+"/"+id_recibo;
            //window.open(   res  ,   "Imprimir recibo",   "width=800,height=350" );
        } else {
            alert(resp.error);
        }
    }
</script>