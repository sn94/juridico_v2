@extends('layouts.app')
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">Visualizacion de Documentos</li>
@endsection
@section('content')
<style>
.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
</style>

@if( isset( $MENSAJE_ERROR ) )

<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> {{$MENSAJE_ERROR}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif


<div class="table-responsive">
  <table class="table">
    <thead>
      <tr id="CabeceraFilesTable">

        <th>Nombre de archivo</th>
        <th>Tamaño</th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>


    <tbody id="CUERPO">
      @foreach($documentos as $dc)
      <tr>
        <td> {{$dc->NOMBRE}} </td>
        <td> {{$dc->SIZE}} </td>
        <td><a onclick="verificar_tipo(event)"  srclocal="{{'docus/'.$dc->UBICACION}}"  href='{{url("documentos/download/".$dc->IDNRO."/".session("system") )}}' class='btn btn-dark btn-sm text-light'> <i class="fa fa-eye"></i></a> </td>
        <td> <a download="{{$dc->NOMBRE}}" href='{{url("documentos/download/".$dc->IDNRO )}}' class='btn btn-dark btn-sm text-light'> <i class="fa fa-download"></i></a></td>
        <td>
          <a href='{{url("documentos/delete/$dc->IDNRO")}}' class='btn btn-danger btn-sm text-light'> <i class="fa fa-minus"></i></a>
        </td>
      </tr>
      @endforeach

    </tbody>
  </table>
</div>
<div id="pdf-visualizador" class="d-none"></div>



<iframe id="visualizador" class="d-none" style="border: 1px solid #040028;width: 100%;" src='https://view.officeapps.live.com/op/embed.aspx?src=' width='1366px' height='623px' frameborder='0'>This is an embedded <a target='_blank' href='http://office.com'>Microsoft Office</a> document, powered by <a target='_blank' href='http://office.com/webapps'>Office Online</a>.</iframe>




       
@endsection


<script>


  window.onload= function(){
     PDFObject.embed('../storage/public/ABOGADO-5/FORMULARIOABCD.pdf', "#pdf-visualizador");
  //   PDFObject.embed('CONSTANCIA DE NO SER CONTRIBUYENTE.pdf', "#pdf-visualizador");
    
  };
  let iframeUrl = "https://view.officeapps.live.com/op/embed.aspx?src=";


  async function verificar_tipo(ev) {
    ev.preventDefault();
    let target= ev.currentTarget;
    let url= ev.currentTarget.href;
    let req = await fetch(   url  );

    let tipo = req.headers.get("content-type");
    if (tipo == "application/pdf") {
      //Obtener la ruta local
      let resour= $( target).attr("srclocal"); 
      visualizar_pdf(  resour );
    } else {
      visualizar_doc_xls(  url  );
    }
     
  }


  function visualizar_pdf(url) {
    $("#visualizador").addClass("d-none");
    $(  "#pdf-visualizador").removeClass("d-none");
    PDFObject.embed(  url, "#pdf-visualizador");
  }

  function visualizar_doc_xls(url) {
    $("#visualizador").removeClass("d-none");
    $(  "#pdf-visualizador").addClass("d-none");
    let res = iframeUrl + url;
    $("#visualizador").attr("src", res);
  }
</script>