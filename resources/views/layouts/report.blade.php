<!-- MODAL TIPO DE INFORME -->
<div id="show_opc_rep" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content" >
    <a  id="info-xls" onclick="callToXlsGen(event, '{{$TITULO}}')" class="btn btn-sm btn-info" href="#" ><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i> <h3>EXCEL</h3></a>
   
    <a  id="info-pdf"  class="btn btn-sm btn-info" href="#"><i class="fa fa-file-pdf-o fa-2x" aria-hidden="true"></i><h3>PDF</h3></a>
    <a  id="info-print" class="btn btn-sm btn-info" href="#"><i class="fa fa-print fa-2x" aria-hidden="true"></i><h3>Printer</h3></a>
    </div>
  </div>
</div>

<script type="text/javascript">
  function mostrar_informe(ev){
    ev.preventDefault();
    let report_path= ev.currentTarget.href; 
    let id= (ev.currentTarget.parentNode.parentNode.id) ==undefined ? "" :  (ev.currentTarget.parentNode.parentNode.id) ;// TR ID 
     let xlsr= id == "" ?  report_path+"/xls" : report_path+"/"+id+"/xls";
     let pdfr= id == "" ?  report_path+"/pdf" : report_path+"/"+id+"/pdf";
     $("#info-xls").attr("href", xlsr );
     $("#info-pdf").attr("href", pdfr  );

    $("#info-print").attr("href", $("#info-print").attr("href")+"/"+id );
    ev.currentTarget.href.concat( id ) ;
  }
</script>
