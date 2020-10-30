
<div class="card  bg-success m-0"  >
  <div class="card-header" style="background-color: #94fcb6;"> <span  style="font-weight: 600;">De: {{$remitente}}</span>  

<span style="font-size: 9pt;"> ({{$dato->created_at}})</span>
</div>
  <div class="card-body" style="background-color: #a5efa0;">
    <h5 class="card-title"> <span  style="font-weight: 600;">Asunto:</span> {{$dato->ASUNTO}}</h5>
    <p class="card-text">
    <textarea  id="editor" cols="30" rows="10"> {{$dato->MENSAJE}} </textarea>
    </p>
  </div>
</div>
 

<script>
   CKEDITOR.replace( 'editor' );

</script>