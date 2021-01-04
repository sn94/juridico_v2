<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="<?= url("app.css") ?>" rel="stylesheet">

  <style>
    h5{
      font-weight: 600;
      
    }
  </style>
</head>

<body>



  <input type="hidden" id="nuevo-freeuser" value="{{url('recibos-free/freeuser')}}">
  <input type="hidden" id="nuevo-recibo" value="{{url('recibos-free/nuevo')}}">
  <input type="hidden" id="print-recibo" value="{{url('recibos-free/print')}}">
  <input type="hidden" id="login-recibo" value="{{url('recibos-free/login-freeuser')}}">
  <input type="hidden" id="menu-freeuser" value="{{url('recibos-free/menu-freeuser')}}">
  <input type="hidden" id="listar-recibos" value="{{url('recibos-free/list')}}">


  <div class="row">

    <div class="col-12 col-md-5">
      <div class="jumbotron">
        <h1 class="display-4">Recibos Free!</h1>
        <p class="lead"> Genera, imprime y envía por E-mail tus recibos GRATIS</p>
       
        <hr class="my-4">
        <p></p>
        <div id="enlaces">


          @if( session()->has("freeuser") )

          @include("recibos_free.menu_usuario")

          @else
          <a class="btn btn-primary btn-lg" href="#" role="button" onclick="form_nuevo_free_user()">Registrarme</a>
          <a class="btn btn-primary btn-lg" href="#" role="button" onclick="form_login_free_user()">Ingresar</a>
          <a style="font-size: 20px !important; font-weight: 600;display:block;" href="http://www.legalex.com.py">Volver a Legalex.com</a>
          @endif
        </div>

      </div>
    </div>

    <div class="col-12 col-md-4 mt-3" id="content">


    </div>
  </div>


<!-- modal -->
<div id="showform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"  id="viewform">

      </div>
      
    </div>
  </div>
</div>
<!-- modal -->


  <script src="<?= url("app.js") ?>"></script>
  <script>
    function form_login_free_user() {

      let url__ = document.getElementById("login-recibo").value;
      $.ajax({
        url: url__,
        success: function(resp_html) {

          $("#content").html(resp_html);
        }
      });
    }

    function form_nuevo_free_user() {

      let url__ = document.getElementById("nuevo-freeuser").value;
      $.ajax({
        url: url__,
        success: function(resp_html) {
          console.log(resp_html, typeof resp_html);
          let body = document.getElementById("content");
          let parseado = new DOMParser(resp_html, "text/html");
          // body.innerHTML=  resp_html;
          $("#content").html(resp_html);
        }
      });
    }


    function imprimir_recibo(  id_recibo ){
      let resour=  id_recibo;
      if(    typeof  id_recibo == "object")  resour=  ev.currentTarget.href;
      else resour= ("#print-recibo").val()+"/"+id_recibo;
      let res= resour;
       window.open(   res  ,   "Imprimir recibo",   "width=800,height=350" );
    }
  </script>


</body>

</html>