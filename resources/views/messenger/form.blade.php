<?php

use App\Helpers\Helper; 
?>





<h6 style="padding: 3px;background-color: #092804; color:white; text-align: center;">NUEVO &nbsp; <i class="fa fa-envelope-o" aria-hidden="true"></i>
</h6>


<div id="viewform2">

</div>
 

<form class="p-2" id="messengerform" action="<?= url("nuevo-msg") ?>" method="post" onsubmit="ajaxCall(event,'#viewform2')">

{{csrf_field()}}

@php
echo Form::hidden('REMITENTE', session("id") );
  @endphp


<div class="row">
<div class="col-12">
    <div class="form-group">
    <label >PARA:</label>

    
  <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
  </div>
  @php
    echo Form::select('DESTINATARIO',  $usuarios , null, ['class'=> 'form-control form-control-sm']);
    @endphp
</div> 
    </div>


  </div>
  <div class="col-12 ">
    <div class="form-group">
    <label >ASUNTO:</label>
    <input   maxlength="50" value="{{isset($DATO)?  $DATO->ASUNTO  : '' }}"   name="ASUNTO"  type="text"  class="form-control form-control-sm">
    </div>
  </div>
  <div class="col-12 ">
    <div class="form-group">
    <label >MENSAJE:</label>
    @php
    echo Form::textarea('MENSAJE', '', [ 'id'=>'editor', 'class'=> 'form-control form-control-sm','rows'=>5, 'maxlength'=>"500"]);
    @endphp   
    </div>
  </div>
    

  <div  class="col-12 d-flex align-items-center">
  <button type="submit" class="btn btn-sm btn-info">ENVIAR</button>
  </div>
</div>


</form>
  
 