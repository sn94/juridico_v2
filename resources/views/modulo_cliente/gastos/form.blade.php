


<?php 
 
use App\Helpers\Helper; 
?>

 
<input type="hidden" id="OPERACION" value="{{$OPERACION}}">

<p style="text-align: center;font-weight: 600; background-color: #f9a84f; color: white;margin-bottom: 0px;">
NUEVO GASTO
</p>




<form style="background-color: #fdc673; padding:0px;margin-bottom:0px;  " id="gastosform" onsubmit="guardar(event)" action="{{$RUTA}}" method="post">

<div class="form-group m-0 p-2"  style="background-color: #fdc673; ">
<div class="form-check form-check-inline">
  <input {{ isset($dato) && !is_null($dato->ID_DEMA) ? 'checked' : ''}} class="form-check-input" id="GastDema" onchange="modo_gastos(event)" type="radio" name="modo"   value="gastdema">
  <label class="form-check-label" for="inlineRadio1">Por demanda</label>
</div>
<div class="form-check form-check-inline" >
  <input  {{ isset($dato) && is_null($dato->ID_DEMA) ? 'checked' : ''}} class="form-check-input" id="OtrosGast" onchange="modo_gastos(event)"  type="radio" name="modo"  value="gastotro">
  <label class="form-check-label" for="inlineRadio2">Otros</label>
</div>
</div>


@csrf
@if( isset($OPERACION) && $OPERACION == "M")
<input type="hidden" name="IDNRO" value="{{$dato->IDNRO}}" >
@endif

<input type="hidden" name="ID_DEMA" value="{{ isset($dato)? $dato->ID_DEMA : ''}}" >


<p id="mensaje" style="text-align: center; font-weight: bold; color: #05560c;"></p>






<div id="panel-demanda" class="row m-2 p-1 {{isset($demanda) ? '' : 'd-none'}}" style="border: 1px solid #fee6c5;">
    <div class="col-12 col-md-1">
    <label for="">CEDULA:</label>
    </div>
    <div class="col-12 col-md-3">

    <div class="input-group mb-3">
    <div class="input-group-prepend">
      <span class="input-group-text" id="basic-addon1"> <a  href="<?= url("demandas_n_gasto")?>"  onclick="mostrarBuscador(event)" style="color:black;" > <i class="mr-2 ml-2 fa fa-search fa-lg" aria-hidden="true"></i></a>
    </span>
    </div>
      <input id="CI" type="text" class="form-control form-control-sm" value="{{isset($demanda)? $demanda->CI: ''}}">
    </div>

</div> 
    

    <div class="col-12 col-md-1 mr-1">
    <label for="">TITULAR:</label>
    </div>
    <div class="col-12 col-md-5">
    {!! Form::text('', isset($demanda)? $demanda->TITULAR: "", [ 'style'=>'background-color: #c1c1c1 !important;', 'id'=>'TITULAR', 'class'=>'form-control form-control-sm', 'readonly'=>'true']  ) !!}
    </div>
    
    <div class="col-12">
        <p id="datos-extra">{{ isset($demanda)? ($demanda->COD_EMP." ". Helper::number_f($demanda->DEMANDA) ): "" }}</p>
    </div>
    
</div>
<div id="chooser-place" class="d-none">

</div>
<div class="row p-3">
<div class="col-12 col-md-4">
        <label >CÓD. DE GASTO:</label>
        @if ($OPERACION == "A")
        {!! Form::select('CODIGO', $CODGASTO, null, ['class'=>'form-control form-control-sm']  ) !!} 
       @endif
       @if ($OPERACION == "M")
        {!! Form::select('CODIGO', $CODGASTO, $dato->CODIGO, ['class'=>'form-control form-control-sm']  ) !!} 
       @endif
         
    </div>
    <div class="col-12 col-md-4">
        <label >FECHA:</label>
        <input   value="{{isset($dato->FECHA) ? $dato->FECHA : '' }}" name="FECHA"  type="date"  class="form-control form-control-sm">
    </div>
    <div class="col-12 col-md-4"> 
        <label >N° DE DOCUMENTO:</label>
        <input maxlength="10"  value="{{isset($dato->NUMERO)? $dato->NUMERO: ''}}" name="NUMERO"  type="text"  class="form-control form-control-sm">
     </div>
     <div class="col-12 col-md-4"> 
        <label >IMPORTE:</label>
        <input  oninput="solo_numero(event)" maxlength="10"  value="{{isset($dato->IMPORTE)? Helper::number_f($dato->IMPORTE) : ''}}" name="IMPORTE"  type="text"  class="form-control form-control-sm number-format">
     </div>
    <div class="col-12 col-md-4">
        <label >DESCRIPCIÓN:</label>
        <input maxlength="50" value="{{isset($dato->DETALLE1)?$dato->DETALLE1: ''}}" name="DETALLE1"  type="text"  class="form-control form-control-sm"> 
    </div>
    <div class="col-12 col-md-4">
    <label >DESCRIPCIÓN 2:</label>
    <input maxlength="46"   value="{{isset($dato->DETALLE2)?$dato->DETALLE2: ''}}" name="DETALLE2"  type="text"  class="form-control form-control-sm">
    </div>

    <div class="col-12 col-md-12 d-flex align-items-center mt-1">
    <button style="background-color: #fa640a;" class="btn btn-sm btn-info" type="submit">GUARDAR</button>
    </div>
</div> 

</form>


 
 

<script>
  



function mostrarBuscador(ev){
    ev.preventDefault();
    if( $("#CI").val()=="" ){ alert("Ingrese el CI, antes de seleccionar un juicio"); return;}
   let url_= ev.currentTarget.href+"/"+ $("#CI").val();
let divname= "#chooser-place";
  $.ajax(
       {
         url:  url_, 
         beforeSend: function(){
           $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
         },
         success: function(res){  $(divname).html(  res );
         },
         error: function(){
           $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
         }
       }
     );
}

    
    function modo_gastos( ev){
        if( ev.currentTarget.value == "gastdema")
        {
            $("#panel-demanda").removeClass("d-none");
            $("#chooser-place").removeClass("d-none");
        }else{
            $("#panel-demanda").addClass("d-none");
            $("#chooser-place").addClass("d-none");
            $("input[name=ID_DEMA]").val("");
            $("#TITULAR,#CI").val("");
            $("#chooser-place").html("");
            $("#datos-extra").text("");
        }
    }

  
    function setDefaultDate(){
        //fechas por defecto
        if( $("input[type=date]").val() == "" )
        {
            let FeCha= new Date();
            let mes= (FeCha.getMonth()+1) <10 ?  "0".concat(FeCha.getMonth()+1) :  (FeCha.getMonth()+1);
           let dia= FeCha.getDate()<10 ? "0".concat(FeCha.getDate()) : FeCha.getDate();
            $("input[type=date]").val( FeCha.getFullYear()+"-"+mes+"-"+dia);
        }
    }


    if( $("#OPERACION").val()=="A")
    setDefaultDate(); 

    

</script>
 
