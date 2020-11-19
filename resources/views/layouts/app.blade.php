<?php

use Illuminate\Support\Facades\URL;
?>
<!DOCTYPE html> 

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="author" content="Marx JMoura">
    <meta name="description" content="Admin 4B. Open source and free admin template built on top of Bootstrap 4. Quickly customize with our Sass variables and mixins.">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Sistema de Control de Juicios</title>
    <link rel="icon" href="./favicon.ico">
    <link href="<?= url("app.css") ?>" rel="stylesheet">
    <!--
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
-->
    <!--Estilo print -->
    <link href="<?= url("print/print.min.css") ?>" rel="stylesheet">

    

     <style>
        .app .app-body .app-sidebar{
             background: #060a2d;
             
         }
         .app .app-body .app-sidebar .sidebar-nav > .sidebar-nav-link.collapsed, .app .app-body .app-sidebar .sidebar-nav > li > .sidebar-nav-link.collapsed, .app .app-body .app-sidebar .sidebar-nav > .sidebar-nav-group > .sidebar-nav-link.collapsed {
            background: #060a2d;
             
            }

        .card-header{
            background: #060a2d;
            
        }
        .sidebar-nav-link{
            font-weight: 600 !important;
        }
        .sidebar-nav-link:hover{
            background: #060a2d;
        }
         


        a.text-light:focus, a.text-light:hover{  background-color: black !important;}

        .btn-primary{
            background-color: #060a2d;
        }


<?php
use App\Http\Controllers\MessengerController;
use App\Mobile_Detect;
$adapta=new Mobile_Detect();
if( $adapta->isMobile()): ?>

        table, label, select{   font-size: 12px !important;  font-family:Verdana, Geneva, Tahoma, sans-serif;   }
        table.table td{ padding: 0px !important;}
        input{ font-size: 14px; }
      
<?php
else: ?>
        table{  font-size: 14px !important;   font-family:Verdana, Geneva, Tahoma, sans-serif;     }
        label, select{ font-size: 12.5px !important;  font-family:Verdana, Geneva, Tahoma, sans-serif;   }
        table.table td{ padding: 0px !important;}
        input{ font-size: 12px !important; font-weight: 600;  font-family:Verdana, Geneva, Tahoma, sans-serif; } 
<?php
endif;
?>
      
      .toast{
          color:#092804;
          font-weight: bold;
          font-size: 16px;
          text-align: center;
      }

        label{  font-weight: 600; text-transform: uppercase;  }
       

 
      
 
       .name-titular{
        font-size: 14px; text-transform: capitalize; font-weight: bold;
       }


    

.verde1 {
    background-color: #aaaaaa;
}

.verde2 {
    background-color: #BDBDBD;
}

.verde3 {
    background-color: #a6a6a6;
}

.verde4 {
    background-color: #b4b4b4;
}

.verde5 {
    background-color: #949494;
}

.verde6 {
    background-color: #549751;
}

.verde7 {
    background-color: #5B8959;
}
     </style>
</head>

<body >
    <div class="app">
        <div class="app-body">
            <div class="app-sidebar sidebar-slide-left">
                <div class="text-right">
                    <button type="button" class="btn btn-sidebar" data-dismiss="sidebar">
                        <span class="x"></span></button>
                </div>
                <div class="sidebar-header">
                    <a href="<?= url("/") ?>"><img src="<?=url("assets/img/balanza.jpg")?>" class="user-photo"></a>
                    <p class="username">
                    Estudio Jurídico Sa.<br><small>
                        {{session('nick').","}}
                    {{ session('tipo')== "SA" ? "Superadmin" :  (session('tipo')== "S" ? "SUPERVISOR": (session('tipo')=="U" ? "USUARIO" : "OPERADOR")) }}

                    </small>
                    </p> 
                </div>
                <ul id="sidebar-nav" class="sidebar-nav">
                 
                    <li class="sidebar-nav-group">
                        <a href="<?=url("ldemandados")?>" class="sidebar-nav-link" ><i class="icon-doc"></i>
                            DEMANDAS</a>
                         
                    </li>
                    
                     
                    <li class="sidebar-nav-group">
                        <a href="#opcinformes" class="sidebar-nav-link" data-toggle="collapse"><i class="icon-pencil"></i> INFORMES</a>
                        <ul id="opcinformes" class="collapse" data-parent="#sidebar-nav"> 
                        <li><a href="<?=url("filtros")?>" class="sidebar-nav-link">Filtros</a></li> 
                        <li><a href="{{url('informes-cuentajudicial')}}" class="sidebar-nav-link">Estado Cta. Judicial</a></li>
                        <li><a href="{{url('informes-arregloextrajudicial')}}" class="sidebar-nav-link">Cobro extrajudicial</a></li>
                           
                        </ul>
                    </li>
                    <li class="sidebar-nav-group">
                    <a href="#banco-menu" class="sidebar-nav-link" data-toggle="collapse" ><i class="icon-note"></i> BANCOS</a>
                        <ul id="banco-menu" class="collapse" data-parent="#sidebar-nav">
                        <li><a href="<?=url("bank")?>" class="sidebar-nav-link">Cta.de Banco</a></li> 
                        <li><a href="<?=url("bank-informes")?>" class="sidebar-nav-link">Informes</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-nav-group"><a href="#layout" class="sidebar-nav-link" data-toggle="collapse"><i class="icon-layers"></i> GASTOS</a>
                        <ul id="layout" class="collapse" data-parent="#sidebar-nav">
                            <li><a href="<?=  url("gastos") ?>" class="sidebar-nav-link">Cargar</a></li>
                            <li><a href="<?=  url("plan-de-cuentas") ?>" class="sidebar-nav-link">Plan de cta.</a></li> 
                        </ul>
                    </li>
                    @if( session("tipo") == "S"  ||  session("tipo") == "SA")
                    <li class="sidebar-nav-group"><a href="#reference" class="sidebar-nav-link" data-toggle="collapse"><i class="icon-notebook"></i> AUXILIARES</a>
                        <ul id="reference" class="collapse" data-parent="#sidebar-nav">
                            <li><a href="<?= url("auxiliar")?>" class="sidebar-nav-link">Datos aux.</a></li>
                            <li><a href="<?= url("users")?>" class="sidebar-nav-link">Usuarios</a></li>
                            @if( session("tipo") == "SA")
                            <li><a href="<?= url("abogados")?>" class="sidebar-nav-link">Abogados</a></li> 
                            @endif 
                            
                            <li><a href="<?= url("params")?>" class="sidebar-nav-link">Parámetros</a></li> 

                        </ul>
                    </li>
                    @endif
                    <li class="sidebar-nav-group"><a href="#notifi" class="sidebar-nav-link" data-toggle="collapse"><i class="icon-notebook"></i> NOTIFICACIONES</a>
                        <ul id="notifi" class="collapse" data-parent="#sidebar-nav">
                            <li><a href="<?= url("dema-noti-venc")?>" class="sidebar-nav-link">LISTAR</a></li>
                            <li><a onclick="procesarNotificaciones(event)" href="#" class="sidebar-nav-link">PROCESAR</a></li> 

                        </ul>
                    </li>
                </ul>
                <div class="sidebar-footer"><a href="<?=url("messenger")?>" data-toggle="tooltip" title="Mensajes"><i class="fa fa-comment"></i> </a>
                
                <a   href="<?=url("signout")?>" data-toggle="tooltip" title="Logout"><i class="fa fa-power-off"></i></a></div>
            </div>
            <div class="app-content">
                <nav class="navbar navbar-expand navbar-light" style="background-color: #060a2d;"><button type="button" class="btn btn-sidebar" data-toggle="sidebar"><i class="fa fa-bars"></i></button>
                    <div id="abogado-view-info" class="navbar-brand text-light"> 

                        @php 
                        use \App\Abogados;
                        @endphp 

                        @if( session()->has("abogado") )
                        ABOGADO: {{session("abogado")}}
                        @php 
                        $abogado_d= Abogados::find(session("abogado") );
                        if( !is_null($abogado_d) ){
                            echo $abogado_d->NOMBRE." ".$abogado_d->APELLIDO;
                        }
                        @endphp
                        @else
                        <a style="color: yellow;font-size: 14px;" href="#" onclick="$('#modal-abogado').modal('show')">«Ingresar credenciales de abogado»</a>
                        <div id="abogado-view-error"></div>
                        @endif 

                    </div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-light" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="badge badge-pill  {{ MessengerController::numeroMensajesSinLeer() > 0 ? 'badge-danger' :'badge-primary'}}"> 
                        {{MessengerController::numeroMensajesSinLeer()}}</span> 
                        <i class="fa fa-bell-o"></i></a>

                            <div class="dropdown-menu dropdown-menu-right" style="background-color: #060a2d ;">
                                <a href="{{url('messenger')}}" class="dropdown-item dropdown-item-title text-light">Nuevo mensaje<br>     
                                </a>
                                <div class="dropdown-divider"></div><a href="<?= url("list-msg/R")?>" class="dropdown-item dropdown-link text-light">Recibidos&nbsp; <span class="badge badge-pill badge-primary ">{{MessengerController::numeroMensajesSinLeer()}}</span></a>
                                @if( MessengerController::mensajesRecibidosSinLeer() <= 0 )
                               
                                <div class="dropdown-divider"></div><a href="./pages/content/notification.html" class="dropdown-item"><small class="text-secondary">0 MENSAJES NUEVOS</small><br>
                                    <div>..</div>
                                </a>
                                @endif

                                <div class="dropdown-divider"></div><a href="<?= url("list-msg/E") ?>" class="dropdown-item dropdown-link text-light">Enviados&nbsp;<span class="badge badge-pill badge-primary ">{{MessengerController::numeroEnviados()}}</span>  </a>
                                @if(  MessengerController::mensajesEnviados() <= 0 )
                                 
                                <div class="dropdown-divider"></div><a href="./pages/content/notification.html" class="dropdown-item"><small class="text-secondary">0 MENSAJES NUEVOS</small><br>
                                    <div>..</div>
                                </a>
                                @endif

                                 
                                 

                            </div>
                        </li>
                    </ul>
                </nav>
                <nav aria-label="breadcrumb"   >
                    <ol class="breadcrumb text-light" style="background-color: {{ isset($breadcrumbcolor)  ?  $breadcrumbcolor : '#060a2d;' }}">
                    @yield('breadcrumb')

                       
                    </ol>
                </nav>





                <!-- inicio CONTENT-->

                <div class="container-fluid " id="juridicosys-content">
                    
                    @yield('content')
                         
                           
                </div>
                    <!-- END CONTENT -->

                
<div id="modal-abogado" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content p-2 bg-dark text-light" >

    <div class="modal-header">
        <h5 class="modal-title"> Credenciales </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <label for="">Código de Abogado:</label>
      <input class="form-control" type="text" id="abogado_code" >
      @if( session("tipo") !=  "SA")
      <label for="">PIN:</label>
      <input class="form-control" type="password" id="abogado_pin" >
      @endif
    

      <div class="modal-footer">
      <a onclick="enviar_codigo_abogado(event)" href="<?=url("session-abogados")?>" class="btn btn-primary" >OK</a>
      </div>

    </div>
  </div>
</div>
<script>
  async  function enviar_codigo_abogado( ev){
        ev.preventDefault();
        let lawyer=  $("#abogado_code").val();
        let lawyer_pin= $("#abogado_pin").val();
        let url= ev.target.href;

        let body= { abogado_code: lawyer, abogado_pin:  lawyer_pin };
        let setting= { "method":"POST", "body":   JSON.stringify(body) ,headers: {"Content-Type": "application/json", "X-Requested-With": "XMLHttpRequest",  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} } ;
        let res=  await fetch(  url , setting);
       
        if( res.redirected) window.location=  res.url;
        else{
            let res_j=  await res.json();
            $("#modal-abogado").modal("hide");
            alert(  res_j.error );
            $//("#abogado-view-error").html(  res_html );
            console.log(  res_j);
        }
       
    }

</script>








            </div>
        </div>
    </div>
  
    <script src="<?=url("app.js")?>"></script>
    <!-- librerias para generar archivos excel -->
    <script src="<?=url("xls.js")?>"></script>
    <!-- inicializacion de las librerias anteriores.-->
    <script src="<?=url("xls_ini.js")?>?v={{rand()}}"></script>
    <!--lib para imprimir -->
    <script src="<?=url("print/print.min.js")?>"></script>
    <script src="<?=url("print/init.js")?>"></script>
    <!-- - eDITOR WYSIWYG --> 
    
    <script src="<?=url("ckeditor/ckeditor.js")?>"></script>
    <script src="<?=url("ckeditor/styles.js")?>"></script>
 
    <script src="<?=url("ckeditor/config.js")?>"></script> 
   

    <script>

function procesarNotificaciones(ev){
ev.preventDefault();
let divname="#juridicosys-content";
$.ajax(
     {
       url:  "<?=url("proce-noti-venc")?>",
       method: "get", 
       beforeSend: function(){ $( divname).html(  "<div class='spinner mx-auto'><div class='spinner-bar'></div></div><h3>PROCESANDO NOTIFICACIONES..</h3>" ); 
       },
       success: function(res){ 
           $(divname).html( res);
         //   window.location="<?=url("dema-noti-venc")?>";  
            },
       error: function(){  $( divname).html(  "<h6 style='color:red;'>Problemas de conexión</h6>" );   }
     }
   );
}

        $("input[type=date]").each(  function(index, elemento){

            if( $(elemento).val() == "")
            $(elemento).css("color", "white");
            
            $(elemento).bind("change", function(){
                if( this.value ==""  ||  this.value == undefined){
                    console.log( this.value );
                    $(  this  ).css("color", "white");
                    return;
                }
                $(  this  ).css("color", "black");
            })
        });
    </script>
</body>

</html>