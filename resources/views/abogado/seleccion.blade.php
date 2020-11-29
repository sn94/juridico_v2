@extends('layouts.login')

@section('Titulo')
Seleccione una opción de abogado
@endsection


@section('contenido')



<style>

.login100-form-title{
    background-color: #060a2d;
    background-image: none !important;
    padding: 10px 15px 10px 15px !important;
}

input::placeholder{
    color: black !important;
    
}
</style>
<form style="background-color: #363636;" submit="enviar_codigo_abogado(event)" method="post" class="login100-form validate-form" action="<?=url("session-abogados")?>">
	@csrf

    @if( sizeof($abogados)  == 0)
   <label class="text-white"> Aún no se le ha asignado un código de abogado. Consulte con el administrador</label>
    @endif

    <select  class="form-control" style="margin-bottom: 5px;border-radius: 20px;"  name="abogado_code" id="">
    @foreach( $abogados as $abo)
    <option value="{{$abo->IDNRO}}">{{ $abo->IDNRO.'-'.$abo->NOMBRES}}</option>
    @endforeach

    </select>
 
	 


	<button  type="submit" class="login100-form-btn">OK</button>
     
    @if(  session("tipo") == "SA") 
    <a  style="background-color: red;"  href="{{url('abogados')}}" class="login100-form-btn">Crear abogado</a>
    @endif
    

</form>



<script>
    async function enviar_codigo_abogado(ev) {
        ev.preventDefault();
        let lawyer = $("#abogado_code").val();
        let lawyer_pin = $("#abogado_pin").val();
        let url = ev.target.action;

        let body = {
            abogado_code: lawyer,
            abogado_pin: lawyer_pin
        };
        let setting = {
            "method": "POST",
            "body":  $(ev.target).serialize(),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded', 
                "X-Requested-With": "XMLHttpRequest",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        };
        let res = await fetch(url, setting);

        if (res.redirected) window.location = res.url;
        else {
            let res_j = await res.json();
           
            alert(res_j.error); 
        }

    }
</script>

@endsection