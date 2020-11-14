@extends('layouts.app')
@section('breadcrumb')
<li class="breadcrumb-item" aria-current="page">USUARIOS</li>  
@endsection
@section('content')
  
<div id="viewform">
  
</div>

<div id="viewform2">
@include("auth.form" )
</div>

<div id="list-user">
@include("auth.grilla" )
</div>
@endsection


<script> 
 




function act_grilla(){
  $.ajax(
     {
       url: "<?=url("users")?>",
       method: "get", 
       beforeSend: function(){ $( "#list-user").html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div>" ); 
       },
       success: function(res){    $(  "#list-user").html(res)  },
       error: function(){  $( "#list-user" ).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" ); 
       }
     }
   );
}




</script>