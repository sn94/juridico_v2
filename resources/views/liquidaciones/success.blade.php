 
<div class="alert alert-success">

<h6>{{ $mensaje}}</h6>

<?php if( isset( $iddeman)  ): ?>
    <a  href="<?= url("nliquida/$iddeman") ?>" class="btn btn-info btn-sm">AGREGAR OTRA</a>
<?php   endif; ?>

</div>
 