@extends('modulo_admin.layouts.app')

 
@section('content')



<form name="popupForm" method="post" action="<?=url("admin/update/$IDNRO")?>"  onsubmit="crear_usuario(event)" >
<input type="hidden" name="IDNRO"  value="{{isset($DATO)? $DATO->IDNRO: ''}}">
  @include("modulo_admin.usuario.form")
</form>
@endsection