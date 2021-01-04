<style>
 
</style>
<div>
    <!-- DATOS DE INICIO DE SESION -->

<!-- DATOS DE DISPOSITIVO DESDE EL CUAL SE ACCEDER --> 
El usuario <span style="font-weight: bold; font-style: italic;">"{{$nick}}"</span> ha accedido al sistema.
<h4>DETALLES TÉCNICOS</h4>
{{$peticion['user-agent'] }} <br>
<span style="font-weight: bold; font-style: italic;">DIRECCIÓN IP: </span>  <br> {{$peticion["ip"]}} 

<br>
<h4>Fecha/Hora:</h4>
{{$timestamp}}
 

</div>