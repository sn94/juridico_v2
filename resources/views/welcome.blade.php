@extends('layouts.app')


@section('content')

<?php  use App\Helpers\Helper; ?>



<?php  
//******SOLO SUPERVISOR********* */
if ($show == "S") {  ?>
     
<div class="row">

    <div class="col-12 col-md-5 col-lg-3">
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
        <div class="card-header bg-dark  text-center"> IMP.TOT.DEMANDAS</div>
        <div class="card-body">
            <h4 class="card-title text-center">{{ Helper::number_f($demanda)}}</h4> 
        </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-3">
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
        <div class="card-header bg-dark  text-center"> N° DEMANDAS</div>
        <div class="card-body">
            <h4 class="card-title text-center">  {{ Helper::number_f($total_demandas)}} </h4> 
        </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-3">
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
        <div class="card-header bg-dark  text-center">DEMANDADOS</div>
        <div class="card-body">
            <h4 class="card-title text-center">{{ Helper::number_f($demandados)}}</h4> 
        </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-3">
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
        <div class="card-header bg-dark  text-center">LIQUIDACIÓN</div>
        <div class="card-body">
            <h4 class="card-title text-center">{{ Helper::number_f($liquidacion)}}</h4> 
        </div>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-3">
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
        <div class="card-header  bg-dark text-center ">SALDO CAPITAL.</div>
        <div class="card-body">
            <h4 class="card-title text-center">{{ Helper::number_f($saldo_c)}}</h4>
        </div>
        </div>
    </div> 
    <div class="col-12 col-md-5 col-lg-3">
        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
        <div class="card-header bg-dark text-center ">SALDO LIQUIDACIÓN</div>
        <div class="card-body">
            <h4 class="card-title text-center">{{Helper::number_f($saldo_l)}}</h4>  </div>
        </div>
    </div>
   
    
</div>


<?php }
//solo SUPERVISOR
?>
  







@endsection 