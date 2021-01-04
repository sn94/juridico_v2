@extends('modulo_admin.layouts.app')

 
@section('content')


<form name="popupForm" method="post" action="<?=url("admin/create")?>"  onsubmit="crear_usuario(event)" >
        
  @include("modulo_admin.usuario.form")

</form>
@endsection