 
 <?php

use App\Helpers\Helper;


 ?>
    
    <table class="table table-bordered table-dark">

    <thead class="thead-dark"><tr> <th  class="text-center">ID</th>  <th>Fecha de pago</th> <th>N° de comprobante</th> <th>Válido hasta</th>   </tr></thead>

    <tbody>

    @foreach( $pagos as $cli )
    <tr>
    <td class="text-center">{{$cli->IDNRO}}</td> <td>{{ Helper::beautyDate($cli->FECHA)}}</td>  <td> {{$cli->COMPROBANTE}} </td> <td> {{ Helper::beautyDate($cli->VALIDEZ)}} </td>
    </tr>
    @endforeach
    </tbody>
    </table>
    {{ $pagos->links() }} 