@extends('0provider.app')

 
@section('content')


<!--begin row-->
 

<div id="formstatus">
</div>

    <div class="mt-5 col-12 offset-md-4 col-md-4">
    <h4 class="text-center">Actualizar ficha de cliente</h4>
        <div id="stickyLayer" style="position:fixed;text-align:left;left:0px;top:50%;margin-top:39px;width:140px;height:63px;z-index:5;">
        </div>
        <form id="editForm" name="popupForm" method="post" action="<?=url("p/suscripcion/edit")?>"  onsubmit="editar(event)" >
        @csrf


        <input type="hidden" name="IDNRO"  value="{{isset($dato)?$dato->IDNRO: ''}}" >
        @include("0provider.suscriptor.form")
        </form>
    </div> <!--End col -->
 


<!--end row -->




<script>


function phone_input(ev){
     if( ev.data == null) return;
     
    if( (ev.data.charCodeAt() < 48 || ev.data.charCodeAt() > 57)  && ev.data.charCodeAt()!= 32   ){ 
      ev.target.value= 
      ev.target.value.substr( 0, ev.target.selectionStart-1) + " "
      ev.target.value.substr( ev.target.selectionStart );
    }  }

async function editar( ev){
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
        alert("ACTUALIZADO");
     
        }
    else   $("#formstatus").html(  respuesta1.error );
    
}


 


window.onload= function(){

 $("#btnGUARDAR").addClass("btn btn-primary");
  let childs = document.getElementById("editForm").elements;

  Array.prototype.forEach.call(  childs,  function(  arg){

      $(arg).addClass("form-control form-control-sm");
      $(arg).css( "font-weight", "600");
      $(arg).addClass( "mb-1");
  }  );
}

</script>
@endsection