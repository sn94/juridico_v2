@extends('layouts.app')
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">Documentos</li>
@endsection
@section('content')


<div id="status-result">

</div>

<h5>Tipos de Archivos Permitidos</h5>
<div class="row mb-2">
  <div class="col-12 col-md-4">

    <img src="{{url('assets/img/word.png')}}" alt="">
  </div>
  <div class="col-12 col-md-4">
    <img src="{{url('assets/img/excel.png')}}" alt=""></div>
  <div class="col-12 col-md-4">

    <img src="{{url('assets/img/pdf.png')}}" alt="">
  </div>
</div>

<div class="table-responsive">
<form action="{{url('documentos/cargar')}}"   method="post"  enctype="multipart/form-data">
@csrf
<table class="table">
    <thead>
      <tr id="CabeceraFilesTable">
        <th></th>
        <th>Nombre de archivo</th>
        <th>Tamaño</th>
        <th></th>

      </tr>
    </thead>


    <tbody id="CUERPO">

    </tbody>
  </table>
  <button type="submit"  class="btn btn-primary">Guardar</button>
</form>
</div>
 

@endsection


<script>
  var idSelectedFile = 1;


  window.onload = function() {
    agregar_fila();
  };

  function validarTipo() {
    let tipos = [
      '.doc',
      '.docx',
      'application/msword',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      '.xls',
      '.xlsx',
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      'application/pdf'

    ]

    let todo = tipos.join(",");
    return todo;
  }


  function agregar_fila() {
    let accept = validarTipo();
    let filanueva = `
    <tr id="file-data-${idSelectedFile}"  >

      <td>
      <input type="file" name="document[]" onchange="archivoSeleccionado( event)" accept="${accept}"  >
      </td>

      <td class="align-middle">
        <img id="file-preview-${idSelectedFile}" class="rounded d-none" width="64">
        <span id="file-name-${idSelectedFile}"> </span>
      
      </td>
      <td class="align-middle">
        <span id="file-size-${idSelectedFile}"></span>
      </td>

      <td>
      <a  onclick='deleteme(${idSelectedFile})' href='#' class='btn btn-danger btn-sm text-light'   > <i class="fa fa-minus"></i></a>
      </td>
      
     
    </tr>
    `;

    $("#CUERPO").append(filanueva);
  }

  function archivoSeleccionado(ev) {
    let listfiles = ev.target.files;
    let ultimof = listfiles[listfiles.length - 1];

    //actualizar FILA
    $("#file-name-" + idSelectedFile).text(ultimof.name);
    $("#file-size-" + idSelectedFile).text((ultimof.size / 1024).toFixed(2) + ' KB');


    //Imagen
    /* if (ultimof.type.startsWith('image')) {
       $('#file-preview-' + idSelectedFile).attr('src', ultimof.dataURL).removeClass('d-none');
     } else {
       $('#file-preview-' + idSelectedFile).removeAttr('src').addClass('d-none');
     }*/

    idSelectedFile++;
    agregar_fila();

  }



  function deleteme(id) {
    if (parseInt(id) == 1) return;
    $("#file-data-" + id).remove();
    if (idSelectedFile > 1) idSelectedFile--;
  }
</script>