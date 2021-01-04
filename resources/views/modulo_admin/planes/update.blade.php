@php
$IDNRO=  isset($DATO)? $DATO->IDNRO: '' ;
@endphp 

<p class="bg-dark text-center text-light" style="font-weight: 600; margin-bottom: 0px;">
PLANES
</p>

<form class="bg-dark text-light p-2" style=" padding:0px;margin-bottom:0px;  "   class="p-3"  onsubmit="enviarForm(event)" id="auxiform" action="<?=url("admin/planes")?>" >
<p class="p-2" id="MENSAJE" style="color:  #041402; font-weight: bold;"></p>
{{csrf_field()}}
  

<input type="hidden" name="IDNRO" value="{{$IDNRO}}">
<input type="hidden" name="_method" value="PUT">


<?= view("modulo_admin.planes.form", ['DATO'=>  $DATO])?>
 
</form>

<script>

function solo_numero_mas_formato(ev){
   
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


function solo_numero(ev){
   
   if(  ev.data == undefined  ||  ev.data == null)  return;
    if( ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + 
      ev.target.value.substr( ev.target.selectionStart ); 
    } 
    
	} 


  window.onload= function(){

    $("input[name=DESCRIPCION]").focus();
  }
</script>