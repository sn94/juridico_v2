
@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">ARREGLO EXTRAJUDICIAL</li> 
<li class="breadcrumb-item active" aria-current="page">CUOTAS & RECIBOS</li> 
@endsection

@section('content')

<?php

use App\Helpers\Helper;

?>
 
 

 <a class="btn btn-sm btn-danger" href="<?= url("demandas-editar/$id_arreglo/6")?>"> Volver</a>

<div class="row">

    <div class="col-12 col-md-4">
        <h4>CUOTAS</h4>
        @if( sizeof( $CUOTAS) >0)
        <table class="table table-responsive">
            <thead>
                <tr><th class="text-center">N° Cuota</th><th>Importe</th><th>Vencimiento</th><th>Pagado</th></tr>
            </thead>
            <tbody>
            @foreach( $CUOTAS as $item)
            <tr><td class="text-center">{{$item->NUMERO}}</td> <td class="text-right">{{Helper::number_f($item->IMPORTE)}}</td> 
            <td class="text-right"><span class="mr-1">{{ Helper::beautyDate($item->VENCIMIENTO)}}</span></td> 
            <td class="text-right"> <span class="ml-1">{{Helper::beautyDate($item->FECHA_PAGO) }}</span></td> </tr>
            @endforeach
            </tbody>
        </table>
        @else 
        <h5>NO SE REGISTRAN CUOTAS</h5>
        @endif 
    </div>
    <div class="col-12 col-md-8">
        <h4>RECIBOS</h4>
    @if( sizeof( $RECIBOS) >0)
    <table class="table  table-responsive">
        <thead> <tr><th>FECHA</th><th>IMPORTE</th><th class="text-center">N° Recibo</th><th>CONCEPTO</th><th></th></tr></thead>
            <tbody>
        @foreach( $RECIBOS as $item)
            <tr>
            <td>{{ Helper::beautyDate($item->created_at) }}</td>
            <td class="text-right">{{ Helper::number_f($item->IMPORTE) }}</td>
            <td class="text-center">{{$item->IDNRO}}</td>
            <td>{{$item->CONCEPTO}}</td>
            <td > <a style="color: black;" class="ml-2" onclick="printBill(event)" href="<?=url("arregloextr-recibo/".$item->IDNRO)?>"><i class="fa fa-print fa-lg" aria-hidden="true"></i></a></td>
            </tr>
        @endforeach
            </tbody>
        </table>
        @else 
        <h5>NO SE REGISTRAN RECIBOS</h5>
        @endif 

    </div>

</div>



    <script>

async function getBillData( url_){

let urlBill= url_;
let respuesta= await fetch( urlBill);
let html="";
if( respuesta.ok)  html=  await respuesta.text();
return html;
}

async function printBill( ev){
    ev.preventDefault();
    let url=  ev.currentTarget.href;
let html= await getBillData( url);
  //print
let documentTitle="PAGOS"
var ventana = window.open( "", 'PRINT', 'height=400,width=600,resizable=no');
ventana.document.write( html);
ventana.document.close(); 
  ventana.focus();
ventana.print();
ventana.close();
return true;
}
 


</script>
 
  
@endsection