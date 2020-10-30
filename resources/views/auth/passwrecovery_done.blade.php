@extends('layouts.app')
 
@section('content')



  <div class="alert alert-sucess">

  <h4>E-mail enviado</h4>

  <i class="fa fa-check-circle"></i>
  Se ha enviado un enlace a <span style="font-weight: 600; color: #040053;"> {{$EMAIL}}</span>

  </div>
@endsection

 