<style>

#formmovi{
background: #6f72ff;
margin: 0;
}

    #formmovi label{
        color: #000128;
    }

    #formmovi h6{
        background-color: #6266ff;
        color: wheat;
        margin: 0;
        text-align: center;
    }

    #buttonSave{
background-color: #373dff;
    }
</style>



<form  id="formmovi" action="{{$RUTA}}" method="post"    onsubmit="movimiento(event)" >

<h6 >
{{ $TIPO_MOV=="D" ? "DEPÓSITO" : "EXTRACCIÓN" }}
</h6>
<h6 >{{$TITULAR}}-{{$CUENTA}}</h6>

<p id="mensaje-movi" style="text-align: center; font-weight: bold; color: #05560c;"></p>



@csrf
<input type="hidden" name="IDNRO" value="{{isset($dato->IDNRO)? $dato->IDNRO:''}}">
<input type="hidden" name="CUENTA" value="{{$CUENTA}}">
<input type="hidden" name="BANCO" value="{{$BANCO}}">
<input type="hidden" name="TIPO_MOV" value="{{$TIPO_MOV}}">
<!-- Extraccion -->
<div class="row" style="margin: 2px;">
<div class="col-12 col-md-12">
        <label >FECHA DE OPERACIÓN:</label>
        <input  value="{{isset($dato->FECHA)? $dato->FECHA:''}}"  name="FECHA"  type="date"  class="form-control form-control-sm">
    </div>
    <?php  if( $TIPO_MOV == "E"):?>
        <div class="col-12 col-md-12">
        <label >COD. DE GASTO:</label>
        <input  value="{{isset($dato->CODIGO)? $dato->CODIGO:''}}" name="CODIGO"  type="text"  class="form-control form-control-sm">
    </div>
    <?php endif; ?>

  
    <div class="col-12 col-md-12"> 
        <label >{{ $TIPO_MOV=="E" ? "NRO.CHEQUE/EXTRACCIÓN:" : "NRO. DE DEPÓSITO"}}</label>
        <input value="{{isset($dato->NUMERO)? $dato->NUMERO:''}}"  name="NUMERO"  type="text"  class="form-control form-control-sm">
    </div>

    <div class="col-12 col-md-12">
        <label >IMPORTE:</label>
        <input oninput="solo_numero(event)"  name="IMPORTE" value="{{isset($dato->IMPORTE)? $dato->IMPORTE:''}}"  type="text"  class="form-control form-control-sm">
    </div>
    <div class="col-12 col-md-12">
        <label >CONCEPTO:</label>
        <input name="CONCEPTO"  value="{{isset($dato->CONCEPTO)? $dato->CONCEPTO:''}}" type="text"  class="form-control form-control-sm">
    </div>
    
    <div class="col-12 col-md-12 d-flex align-items-center">
    <button id="buttonSave" class="btn btn-sm btn-info mt-1" type="submit">GUARDAR</button>
    </div>

  
</div><!--End extraccion -->

</form>

<script>

function setDefaultDate(){
        //fechas por defecto
        if( $("input[type=date]").val() == "" )
        {
            let FeCha= new Date();
            let mes= (FeCha.getMonth()+1) <10 ?  "0".concat(FeCha.getMonth()+1) :  (FeCha.getMonth()+1);
            console.log( FeCha.getFullYear()+"-"+mes+"-"+FeCha.getDate());
            $("input[type=date]").val( FeCha.getFullYear()+"-"+mes+"-"+FeCha.getDate());
        }
    }

    setDefaultDate();
    
</script>