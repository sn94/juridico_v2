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
    <title>CONTROL DE SUSCRIPTORES</title>
    <link rel="icon" href="./favicon.ico">
    <link href="<?= url("app.css") ?>" rel="stylesheet">
    <link href="<?= url("assets/css/sb-admin-2.min.css") ?>" rel="stylesheet">

    <!--Estilo print -->
    <link href="<?= url("print/print.min.css") ?>" rel="stylesheet">



    <style>
        .app .app-body .app-sidebar {

            background-image: url(<?= url("assets/img/admin-bg.jpg") ?>);

        }

        .app .app-body .app-sidebar .sidebar-nav>.sidebar-nav-link.collapsed,
        .app .app-body .app-sidebar .sidebar-nav>li>.sidebar-nav-link.collapsed,
        .app .app-body .app-sidebar .sidebar-nav>.sidebar-nav-group>.sidebar-nav-link.collapsed {
            background: #060a2d;

        }


        .sidebar-nav-link {
            font-weight: 600 !important;
        }

        .sidebar-nav-link:hover {
            background: #060a2d;
        }


        <?php

        use App\Mobile_Detect;

        $adapta = new Mobile_Detect();
        if ($adapta->isMobile()) : ?>table,
        label,
        select {
            font-size: 12px !important;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        table.table td {
            padding: 0px !important;
        }

        input {
            font-size: 14px;
        }

        <?php
        else : ?>table {
            font-size: 14px !important;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        label,
        select {
            font-size: 12.5px !important;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        table.table td {
            padding: 0px !important;
        }

        input {
            font-size: 12px !important;
            font-weight: 600;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }

        <?php
        endif;
        ?>.toast {
            color: #092804;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
        }

        label {
            font-weight: 600;
            text-transform: uppercase;
        }





        .name-titular {
            font-size: 14px;
            text-transform: capitalize;
            font-weight: bold;
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

        @font-face {
            font-family: "mainfont";
            src: url("<?= url('fonts/Marvel-Regular.ttf') ?>");

        }
    </style>

</head>

<body>
    <div class="app">
        <div class="app-body">
            <div class="app-sidebar sidebar-slide-left">
                <div class="text-right">
                    <button type="button" class="btn btn-sidebar" data-dismiss="sidebar">
                        <span class="x"></span></button>
                </div>
                <div class="sidebar-header">
                    <a href="<?= url("/") ?>"><img src="<?= url("assets/img/config.png") ?>" class="user-photo"></a>
                    <p class="username">
                        {{session('nick').","}}<br><small>

                            {{ session('tipo')== "S" ? "SUPERVISOR": (session('tipo')=="U" ? "USUARIO" : "OPERADOR") }}

                        </small>
                    </p>
                </div>

                <ul id="sidebar-nav" class="sidebar-nav">

                    <li class="sidebar-nav-group">
                        <a href="<?= url("admin/clientes/index") ?>" class="sidebar-nav-link"><i class="fa fa-users" aria-hidden="true"></i>
                            CLIENTES</a>

                    </li>
                    <li class="sidebar-nav-group">
                        <a href="<?= url("admin/providers") ?>" class="sidebar-nav-link"><i class="fa fa-users" aria-hidden="true"></i>
                            ADMINISTRADORES</a>
                    </li>

                    <li class="sidebar-nav-group">
                        <a href="<?= url("admin/planes") ?>" class="sidebar-nav-link"><i class="fa fa-users" aria-hidden="true"></i>
                            PLANES</a>
                    </li>

                </ul>

                <div class="sidebar-footer">
                    <a href="#" data-toggle="tooltip" title="Mensajes"><i class="fa fa-comment"></i> </a>
                    <a href="<?= url("admin/sign-out") ?>" data-toggle="tooltip" title="Logout"><i class="fa fa-power-off"></i></a>
                </div>

            </div>
            <div class="app-content">
                <nav class="navbar navbar-expand navbar-light bg-white"><button type="button" class="btn btn-sidebar" data-toggle="sidebar"><i class="fa fa-bars"></i></button>
                    <div class="navbar-brand" style="font-family: mainfont;" >CONTROL ADMIN ( MÓDULO DE USO INTERNO) </div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="badge badge-pill"> 0
                                </span>
                                <i class="fa fa-bell-o"></i></a>

                            <div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item"><small class="dropdown-item-title"> Nuevo mensaje</small><br>


                                </a>
                                <div class="dropdown-divider"></div><a href="#" class="dropdown-item dropdown-link">Recibidos&nbsp; <span class="badge badge-pill badge-primary ">0</span></a>

                                <div class="dropdown-divider"></div><a href="./pages/content/notification.html" class="dropdown-item"><small class="text-secondary">0 MENSAJES NUEVOS</small><br>
                                    <div>..</div>
                                </a>

                                <div class="dropdown-divider"></div><a href="<?= url("list-msg/E") ?>" class="dropdown-item dropdown-link">Enviados&nbsp;<span class="badge badge-pill badge-primary ">0</span> </a>

                                <div class="dropdown-divider"></div><a href="./pages/content/notification.html" class="dropdown-item"><small class="text-secondary">0 MENSAJES NUEVOS</small><br>
                                    <div>..</div>
                                </a>

                            </div>
                        </li>
                    </ul>
                </nav>





                <!-- inicio CONTENT-->

                <div class="container-fluid" id="juridicosys-content">

                    @yield('content')


                </div>
                <!-- END CONTENT -->








            </div>
        </div>
    </div>

    <script src="<?= url("app.js") ?>"></script>
    <!-- librerias para generar archivos excel -->
    <script src="<?= url("xls.js") ?>"></script>
    <!-- inicializacion de las librerias anteriores.-->
    <script src="<?= url("xls_ini.js") ?>?v={{rand()}}"></script>
    <!--lib para imprimir -->
    <script src="<?= url("print/print.min.js") ?>"></script>
    <script src="<?= url("print/init.js") ?>"></script>
    <!-- - eDITOR WYSIWYG -->

    <script src="<?= url("ckeditor/ckeditor.js") ?>"></script>
    <script src="<?= url("ckeditor/styles.js") ?>"></script>

    <script src="<?= url("ckeditor/config.js") ?>"></script>


    <script>
        function procesarNotificaciones(ev) {
            ev.preventDefault();
            let divname = "#juridicosys-content";
            $.ajax({
                url: "<?= url("proce-noti-venc") ?>",
                method: "get",
                beforeSend: function() {
                    $(divname).html("<div class='spinner mx-auto'><div class='spinner-bar'></div></div><h3>PROCESANDO NOTIFICACIONES..</h3>");
                },
                success: function(res) {
                    $(divname).html(res);
                    //   window.location="<?= url("dema-noti-venc") ?>";  
                },
                error: function() {
                    $(divname).html("<h6 style='color:red;'>Problemas de conexión</h6>");
                }
            });
        }

        $("input[type=date]").each(function(index, elemento) {

            if ($(elemento).val() == "")
                $(elemento).css("color", "white");

            $(elemento).bind("change", function() {
                if (this.value == "" || this.value == undefined) {
                    console.log(this.value);
                    $(this).css("color", "white");
                    return;
                }
                $(this).css("color", "black");
            })
        });
    </script>
</body>

</html>