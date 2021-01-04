 
<div> 

 
<h4>HOLA!</h4>
Sus credenciales para acceder al sistema son:
<br>
<span style="font-weight: bold; font-style: italic;">Usuario: </span>  <br> {{$nick}} 
<br>
<span style="font-weight: bold; font-style: italic;">Password: </span>  <br> {{$password}} 
<br>
@if(  $pin != "")
<span style="font-weight: bold; font-style: italic;">Su pin: </span>  <br> {{$pin}} 
@endif 
<h4>Fecha/Hora:</h4>
{{$timestamp}}
 


<div style="border: 1px solid #f3bd18;">
    <p>Recuerde que puede modificar su usuario y contraseña cuando lo desee</p>
</div>


</div>