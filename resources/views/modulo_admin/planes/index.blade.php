@extends('modulo_admin.layouts.app')




@section('content')



<h1  style="font-family: mainfont;">Planes de Servicios</h1>

<input type="hidden" id="ruta_listado" value="{{url('admin/planes')}}">


<!--BOTON INFORMES -->
<a class="btn btn-primary btn-sm" href='{{url("admin/planes-create")}}' onclick="mostrarFormulario(event)" data-toggle="modal" data-target="#showform">NUEVO</a>


<div id="statusform">

</div>

<div id="grilla">
  @include("modulo_admin.planes.grilla" )
</div>


<!-- modal -->
<div id="showform" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" id="viewform">

    </div>
  </div>
</div>
<!-- modal -->




<div id="modal-eliminar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content p-2 bg-dark text-light">
      <span style="font-weight: 600;"> Seguro que desea borrar este Plan?</span>


      <div class="modal-footer">
        <a id="enlace-eliminar" class="btn btn-danger" href="#" onclick="borrar(event)">Si</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>




@endsection

<script>
  function mostrarFormulario(ev) {
    ev.preventDefault();
    $.ajax({
      url: ev.currentTarget.href,
      success: function(res) {
        $("#viewform").html(res);
      },
      beforeSend: function() {
        $("#viewform").html("<div class='spinner mx-auto'><div class='spinner-bar'></div></div>");
      }
    });

  }


  //inserta, modifica registros de parametros y origen de demanda
  async function enviarForm(ev) { //Objeto event   DIV tag selector to display   success handler
    ev.preventDefault();
    let req=   await fetch( ev.target.action, 
    {  method: "POST",
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      body: $(ev.target).serialize()
    });
  
    let r= await  req.json();
    if ("ok" in r) {
          { 
            $("#showform").modal("hide");
            act_grilla();
          }
        } else alert(r.error);
  } /*****end ajax call* */




  /** actualiza grilla de origenes de demanda */
  function act_grilla() {
    $.ajax({
      url: $("#ruta_listado").val(),
      method: "get",
      beforeSend: function() {
        $("#grilla").html("<div class='spinner mx-auto'><div class='spinner-bar'></div></div>");
      },
      success: function(res) {
        $("#grilla").html(res)
      },
      error: function() {
        $("#grilla").html("<h6 style='color:red;'>Problemas de conexión</h6>");
      }
    });
  }


  //inserta, modifica registros de parametros y origen de demanda
  function editar(ev) { //Objeto event   DIV tag selector to display   success handler
    ev.preventDefault();
    let divname = "#viewform";
    $.ajax({
      url: ev.currentTarget.href,
      method: "get",
      beforeSend: function() {
        $(divname).html("<div class='spinner mx-auto'><div class='spinner-bar'></div></div>");
      },
      success: function(res) {
        $(divname).html(res);
      },
      error: function() {
        $(divname).html("<h6 style='color:red;'>Problemas de conexión</h6>");
      }
    });
  } /*****end ajax call* */








  //BORRA origen de demanda
  async function borrar(ev) { //Objeto event   DIV tag selector to display   success handler
    ev.preventDefault();
    let url__= ev.currentTarget.href;
    if(   ! confirm("Seguro?") ) return;
    let loader = "<img style='z-index: 400000;position: absolute;top: 50%;left: 50%;'  src='<?= url("assets/img/loader.gif") ?>'   />";
    let divname = "#viewform2";
    $(divname).html(loader);
    let form = await fetch(  url__, {
      method: "POST",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      body:  "_method=DELETE&_token="+$('meta[name="csrf-token"]').attr('content')
    }); 
    let r = await form.json();
    if (!("ok" in r))(r.error);
    act_grilla();

  } /*****end ajax call* */
</script>