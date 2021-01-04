@extends('modulo_admin.app')

 
@section('content')


<!--begin row-->
<div class="row">

    <div class="col-12 col-md-6">
        <div id="stickyLayer" style="position:fixed;text-align:left;left:0px;top:50%;margin-top:39px;width:140px;height:63px;z-index:5;">
        </div>
        <form name="popupForm" method="post" action="<?=url("p/paso1_suscriptor")?>"  onsubmit="crear_usuario(event)" >
        @csrf
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header"> 
        <h4 class="text-center">REGISTRAR CLIENTE</h4>
        </div>
        <div class="modal-body">
        <label for="" id="nameLabel" style="display:block;width:100%;z-index:0;">Razón Social:</label>
        <input type="text" id="name" class="form-control form-control-sm" name="RAZON_SOCIAL" value="" spellcheck="false">
        <label for="" id="emailLabel" style="display:block;width:100%;z-index:2;">Email:</label>
        <input type="text" id="email" class="form-control form-control-sm" style="display:block;width: 100%;height:28px;z-index:3;" name="EMAIL" value="" spellcheck="false">
        <input class="btn btn-primary" type="submit" id="submitButton" name="" value="Guardar"  >
        </div>
        </div>
        </div>
        </form>
    </div> <!--End col -->


    <div class="col-12 col-md-6 pt-4">
    <table class="table table-border table-dark">
    <thead class="thead-light"><th>Tarea</th><th>Estado</th><th></th></thead>
    <tbody id="operaciones">

        <tr><td>Registrar datos cliente</td><td id="estado-1">Pendiente</td><td id="tiempo-1">-</td></tr>
        <tr><td>Crear Base de datos</td><td id="estado-2">Pendiente</td> <td id="tiempo-2">-</td> </tr>
        <tr><td>Crear tablas</td><td id="estado-3">Pendiente</td> <td id="tiempo-3">-</td></tr>
        <tr><td>Generar credenciales</td><td id="estado-4">Pendiente</td> <td id="tiempo-4">-</td></tr>
       
    </tbody>
    </table>
    </div> <!--End col -->

</div>
<!--end row -->




<script>

async function crear_usuario( ev){
  ev.preventDefault();

//***************************** */
//Creando cliente
//*************************** */
    $( "#estado-1").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" );
    let config= {
         method: 'POST',  body: $(ev.target).serialize(),
         headers: { 'Content-Type':'application/x-www-form-urlencoded', 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }  } ;
    
    let startTime = new Date().getTime();
     

    let peticion1= await fetch( ev.target.action,  config );
    let respuesta1= await peticion1.json();
    console.log(respuesta1);
    if( "idnro" in respuesta1 )
     {      
        $("#estado-1").html(    "<span style='color: #5ffe73;'> Listo </span>" );
        let elapsed = ( (new Date().getTime()) - startTime ) / 1000; 
        $("#tiempo-1").html( elapsed+" seg.");
        crear_bd(  respuesta1.idnro);
        }
    else
            $("#estado-1").html(  "Error" );
    
}




async function crear_bd( idcliente ){ 

//***************************** */
//Creando Bd
//*************************** */
let url__=  "<?=url("/p/paso2_crearbd")?>/"+idcliente;
    $( "#estado-2").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
    let startTime = new Date().getTime();
     

    let peticion1= await fetch(  url__ );
    let respuesta1= await peticion1.json();
    console.log(respuesta1);
    if( "ok" in respuesta1 )
     {      
        $("#estado-2").html(  "<span style='color: #5ffe73;'> Listo </span>" );
        let elapsed = ( (new Date().getTime())  - startTime) / 1000; 
        $("#tiempo-2").html( elapsed+" seg.");
        crear_tablas(  idcliente);
        }
    else
            $("#estado-2").html(  "Error" );
    
}




async function crear_tablas( idcliente ){ 

//***************************** */
//Creando Tablas
//*************************** */
let url__=  "<?=url("/p/paso3_creartablas")?>/"+idcliente;
    $( "#estado-3").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
    let startTime = new Date().getTime();
     
    let peticion1= await fetch(  url__ );
    let respuesta1= await peticion1.json(); 
    if( "ok" in respuesta1 )
     {      
        $("#estado-3").html(  "<span style='color: #5ffe73;'> Listo </span>");
        let elapsed = (  (new Date().getTime()) - startTime) / 1000; 
        $("#tiempo-3").html( elapsed+" seg.");
        crear_credenciales( idcliente);
        }
    else
            $("#estado-3").html(  "Error" );
    
}



async function crear_credenciales( idcliente ){ 

//***************************** */
//Creando Tablas
//*************************** */
let url__=  "<?=url("/p/paso4_gen_credenciales")?>/"+idcliente;
    $( "#estado-4").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
    let startTime = new Date().getTime();
     
    let peticion1= await fetch(  url__ );
    let respuesta1= await peticion1.json();
    console.log(respuesta1);
    if( "ok" in respuesta1 )
     {      
        $("#estado-4").html( "<span style='color: #5ffe73;'> Listo </span>" );
        let elapsed = ( (new Date().getTime())  - startTime) / 1000; 
        $("#tiempo-4").html( elapsed+" seg.");
        }
    else
            $("#estado-4").html(  "Error" );
    
}



</script>
@endsection