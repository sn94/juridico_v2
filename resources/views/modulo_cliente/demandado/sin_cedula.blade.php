@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">DEMANDAS</li> 
<li class="breadcrumb-item active" aria-current="page">DEMANDADOS</li> 
@endsection

@section('content')


<a class="m-2 btn btn-sm btn-info" href="{{url('ldemandados')}}">VOLVER</a>

<div class="alert alert-danger m-2">

<h5>NO SE REGISTRA NÚMERO DE CI°</h5>
NO ES POSIBLE ASOCIAR A LOS REGISTROS DE DEMANDA EN AUSENCIA DEL NÚMERO DE CÉDULA. <br>
EL NOMBRE NO ES PARÁMETRO SUFICIENTE PARA PROCESAR ADECUADAMENTE LAS DEMANDAS.

</div>
@endsection