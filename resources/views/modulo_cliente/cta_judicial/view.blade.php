@extends('layouts.app')


@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">CTAS.JUDICIALES</li> 
<li class="breadcrumb-item active" aria-current="page">MOVIMIENTOS</li> 
@endsection

@section('content')

@include("cta_judicial.form")
 


@endsection 