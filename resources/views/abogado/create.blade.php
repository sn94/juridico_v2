@extends('layouts.app')
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">NUEVO ABOGADO</li>  
@endsection
@section('content')
  
<!-- Spinner place -->
<div id="viewform">
  
</div>

<div id="viewform2" class="mx-auto w-25">

@include("abogado.form" )
</div>
 
@endsection


<script> 
 

window.onload= function(){   $("body").addClass("bg-dark");  };
 




</script>