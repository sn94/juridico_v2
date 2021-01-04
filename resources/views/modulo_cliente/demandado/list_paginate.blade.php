@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">DEMANDAS</li>
<li class="breadcrumb-item active" aria-current="page">DEMANDADOS</li>
@endsection

@section('content')

<style>
  .busqueda {
    background-position: left center;

    padding-left: 17px;

    width: 183px;

    background-image: url(<?= url("assets/img/search18.png") ?>);

    background-repeat: no-repeat;
    border: none;
  }

  #argumento::placeholder{
    color: #141414;
    font-weight: 600;
  }
</style>
<a href="<?= url("demandas-agregar") ?>" class="btn btn-primary btn-sm">NUEVO</a>


<div class="form-check">
  <input id="flag-codeudor" class="form-check-input" type="checkbox" value="option1" onchange="busqueda_selectiva( event) ">
  <label class="form-check-label" for="inlineCheckbox1">BUSCAR CO-DEUDORES</label>
</div>

<div class="input-group mb-2 mt-3">
  <div class="input-group-prepend">
    <button onclick="buscar()" class="btn btn-success btn-sm" type="button"><i class="fa fa-search" aria-hidden="true"></i>
    </button>
  </div>
  <input id="argumento" onkeydown="buscarRegs(event)" type="text" class="form-control" placeholder="Buscar por cédula o nombre/apellido" aria-label="" aria-describedby="basic-addon1">
</div>


<!--
<input style="width:100%;"  placeholder="buscar" class="busqueda col-12 col-md-3 form-control form-control-sm m-md-0 " type="text"  id="argumento" oninput="buscarRegs(this)">
-->




<div id="tabla-dinamica" class="table-responsive" style="width: 100%;">

  @include("demandado.list_paginate_ajax", ["lista"=>$lista] )

</div>






<script>
  function busqueda_selectiva(ev) {
    if (ev.currentTarget.checked)
      buscar(true);
    else {
      $("#argumento").val("");
      buscar();
    }
  }


  function buscar(codeudor) {
    let codeudor_v = codeudor == undefined ? false : true;

    let url__ = "<?= url("ldemandados") ?>/" + $("#argumento").val();
    if (codeudor_v || $("#flag-codeudor").prop("checked")) {
      url__ = "<?= url("lgarantes") ?>/" + $("#argumento").val();
    }

    $.ajax({
        url: url__,

        beforeSend: function() {
          $("#tabla-dinamica").html("<div class='spinner mx-auto'><div class='spinner-bar'></div></div>");
        },

        success: function(res) {
          $("#tabla-dinamica").html(res);
        },
        error: function() {
          $("#tabla-dinamica").html("Error de servidor. Consulte con el administrador");
        }
      }

    );
  }



  function buscarRegs(ev) {

    if (ev.keyCode == 13) {
      let target = ev.target;
      if ($("#flag-codeudor").prop("checked"))
        buscar(true);
      else buscar();
    }
  } /** */



  function jsonReceiveHandler(data) { // string JSON to convert     div Html Tag to display errors
    try {
      let res = JSON.parse(data);
      if ("error" in res) {
        alert(res.error);
        return false;
      } else {
        return res;
      }
    } catch (err) {
      alert(err);
      return false;
    }
    return false;
  } /***End Json Receiver Handler */

  function procesar_borrar(ev, ci) {
    ev.preventDefault();
    let url_ = ev.currentTarget.href;
    let nro_juicio = $("#" + ci).children()[6].textContent; //nro de juicios
    if (nro_juicio == "0") {
      if (confirm("Seguro que desear eliminar este registro?")) {
        $.ajax({
          url: url_,
          success: function(res) {
            let r = jsonReceiveHandler(res);
            if (typeof r != "boolean") {
              if ("error" in r) alert(r.error);
              else {
                alert("Datos personales del CI° " + r.ci + " fueron borrados.");
                $("#" + r.ci).remove();
              }
            }
          },
          error: function(xhr) {
            alert("Problemas de conexión . " + xhr.responseText);
          }
        })
      }
    } /**end verifi nro juicio */
    else alert("No se puede borrar. Registros de juicio existentes")

  }
</script>

@endsection