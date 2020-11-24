<h3> «  {{session("freeuser_")}} »</h3>

<div class="btn-group-vertical" role="group" aria-label="Basic example">

<button onclick="mostrar_form_recibo()" type="button" class="btn btn-success">Nuevo Recibo </button>
  <button onclick="listar()" type="button" class="btn btn-secondary">Resumen de recibos generados</button> 
  <a class="btn btn-danger" href="{{url('recibos-free/logout-freeuser')}}">Salir</a>
</div>

 <script>

   async  function  mostrar_form_recibo(){
           //Mostrar form de recibo
      let req_recibo = await fetch(($("#nuevo-recibo").val() ));
      let resp_recibo = await req_recibo.text();
      $("#content").html(resp_recibo);
     }

     async  function  listar(){
           //Mostrar form de recibo
      let req_recibo = await fetch(($("#listar-recibos").val() ));
      let resp_recibo = await req_recibo.text();
      $("#content").html(resp_recibo);
     }
 </script>