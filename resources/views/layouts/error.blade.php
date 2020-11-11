
@if( isset($error))
<div style="position: fixed;  z-index: 10000;" class="mx-auto alert alert-danger alert-dismissible fade show" role="alert">
  <strong> {{ $error }} </strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif