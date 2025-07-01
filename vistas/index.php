<?php
session_start();

header("Access-Control-Allow-Origin: https://titaninmochem.com/cubo/");

if (!isset($_SESSION["estado"])) {
    header("Location: ../index.php");
} else if ($_SESSION["estado"] === 'Activo') {

    include_once '../adicionales/varios.php';
    include_once '../modelos/CL_ap_programs.php';

    $OB_ap_programs = new CL_ap_programs();

    //traer los programas a pintar el la barra del lado izquierdo
    $datos["id_rol"] = $_SESSION["id_rol"];
    $sub_menu_data_ap_programs = $OB_ap_programs->leer($datos, 1);
    $menu_data_ap_programs = $OB_ap_programs->leer($datos, 2);
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <?= retornarCabeceraInicial("Cubo") ?>
            <script src="../js/modelos/cm_trm.js?ramdom=<?= time() ?>" type="text/javascript"></script>

            <script src="../js/vistas/index.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/comunes.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        </head>

        <body class="hold-transition skin-blue sidebar-mini">
            <input type="hidden" name="codusr" id="codusr" value="<?= $_SESSION["codusr"] ?>" />
            <div class="wrapper">
                <header class="main-header">
                    <!-- Logo -->
                    <a href="index.php?mostrarValorTRM=1" class="logo">
                        <!-- mini logo for sidebar mini 50x50 pixels -->
                        <span class="logo-mini">CS</span>
                        <!-- logo for regular state and mobile devices -->
                        <span class="logo-lg">CUBO SOFT</span>
                    </a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                            <span class="sr-only">Reducir barra de navegación</span>
                        </a>

                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <!-- User Account: style can be found in dropdown.less -->
                                <li class="dropdown user user-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <img src="<?= $_SESSION["foto"] ?>" class="user-image" alt="<?= $_SESSION["nombre"] ?>">
                                        <span class="hidden-xs"><?= $_SESSION["nombre"] ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="user-footer">
                                            <a href="#" class="btn btn-sm btn-flat"><?= $_SESSION["descrip_rol"] ?></a>
                                            <a href="#" class="btn btn-sm btn-flat" data-toggle="modal" data-target="#modal-default" >Cambiar clave</a>
                                            <a href="../index.php" class="btn btn-sm btn-flat">Salir</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar">
                        <!-- Sidebar user panel -->
                        <div class="user-panel">
                            <img src="../imagenes/app/logo_alfrio_completo.png" class="img-responsive" alt="Alfrio">
                            <div class="pull-left image">

                            </div>
                            <!--<div class="pull-left info">
                                <p>Alexander Pierce</p>
                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>-->
                        </div>
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu" data-widget="tree" id="menuIzquierdo">
                            <?php
                            for ($index = 0; $index < count($menu_data_ap_programs); $index++) {
                                echo '<li class="treeview">
                                        <a href="#">
                                            <i class="fa fa-bars"></i> <span>' . $menu_data_ap_programs[$index]["descrip"] . '</span>
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                         </a>
                                      <ul class="treeview-menu">';
                                for ($index2 = 0; $index2 < count($sub_menu_data_ap_programs); $index2++) {
                                    if ($menu_data_ap_programs[$index]["descrip"] === $sub_menu_data_ap_programs[$index2]["descrip"]) {
                                        echo '<li><a href="#" id="' . $sub_menu_data_ap_programs[$index2]["codprog"] . '" name="' . $sub_menu_data_ap_programs[$index2]["path"] . '" onclick="insertarPagina(this.name, 1)" ><i class="fa fa-circle-o text-aqua" ></i> ' . $sub_menu_data_ap_programs[$index2]["nomprog"] . '</a></li>';
                                    }
                                }
                                echo '</ul>'
                                . '</li>';
                            }
                            ?>

                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-bars"></i> <span>En construcción</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="#" id="alertas.php" name="alertas.php" onclick="insertarPagina(this.name, 2)" ><i class="fa fa-circle-o text-aqua" ></i> Alertas</a></li>                                                                        
                                    <li><a href="#" id="listado.php" name="listado.php" onclick="insertarPagina(this.name, 2)" ><i class="fa fa-circle-o text-aqua" ></i> Listado Temp Entidades</a></li>                                                                                                                                                
                                </ul>
                            </li>

                        </ul>
                    </section>
                    <!-- /.sidebar -->
                </aside>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content">
                        <div class="row">
                            <!-- left column -->
                            <div class="col-md-12" id="divSeccionTrabajo">
                            <div class="col-md-6" id="divGraficas">
                                <div class="row">
                                    <div id="divPreciosDolar">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                <div id="divGraficaDolar">
                                    <!--aqui la grafica del dolar-->
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <footer class="main-footer">
                    <div class="pull-right hidden-xs">
                        <b>Version</b> 2.4.18
                    </div>
                    <strong>Copyright &copy; 2014-2023 <a href="https://adminlte.io">Grupo desarrollo de software personalizado</a>.</strong> Todos los derechos reservados
                </footer>

                <!-- Control Sidebar -->
                <aside class="control-sidebar control-sidebar-dark">
                    <!-- Create the tabs -->
                    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Home tab content -->
                        <div class="tab-pane" id="control-sidebar-home-tab">
                            <h3 class="control-sidebar-heading">Recent Activity</h3>
                            <ul class="control-sidebar-menu">
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                            <p>Will be 23 on April 24th</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="menu-icon fa fa-user bg-yellow"></i>

                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                            <p>New phone +1(800)555-1234</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                            <p>nora@example.com</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="menu-icon fa fa-file-code-o bg-green"></i>

                                        <div class="menu-info">
                                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                            <p>Execution time 5 seconds</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <!-- /.control-sidebar-menu -->

                            <h3 class="control-sidebar-heading">Tasks Progress</h3>
                            <ul class="control-sidebar-menu">
                                <li>
                                    <a href="javascript:void(0)">
                                        <h4 class="control-sidebar-subheading">
                                            Custom Template Design
                                            <span class="label label-danger pull-right">70%</span>
                                        </h4>

                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <h4 class="control-sidebar-subheading">
                                            Update Resume
                                            <span class="label label-success pull-right">95%</span>
                                        </h4>

                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <h4 class="control-sidebar-subheading">
                                            Laravel Integration
                                            <span class="label label-warning pull-right">50%</span>
                                        </h4>

                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <h4 class="control-sidebar-subheading">
                                            Back End Framework
                                            <span class="label label-primary pull-right">68%</span>
                                        </h4>

                                        <div class="progress progress-xxs">
                                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                            <!-- /.control-sidebar-menu -->

                        </div>
                        <!-- /.tab-pane -->
                        <!-- Stats tab content -->
                        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                        <!-- /.tab-pane -->
                        <!-- Settings tab content -->
                        <div class="tab-pane" id="control-sidebar-settings-tab">
                            <form method="post">
                                <h3 class="control-sidebar-heading">General Settings</h3>

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Report panel usage
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>

                                    <p>
                                        Some information about this general settings option
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Allow mail redirect
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>

                                    <p>
                                        Other sets of options are available
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Expose author name in posts
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>

                                    <p>
                                        Allow the user to show his name in blog posts
                                    </p>
                                </div>
                                <!-- /.form-group -->

                                <h3 class="control-sidebar-heading">Chat Settings</h3>

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Show me as online
                                        <input type="checkbox" class="pull-right" checked>
                                    </label>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Turn off notifications
                                        <input type="checkbox" class="pull-right">
                                    </label>
                                </div>
                                <!-- /.form-group -->

                                <div class="form-group">
                                    <label class="control-sidebar-subheading">
                                        Delete chat history
                                        <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                                    </label>
                                </div>
                                <!-- /.form-group -->
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                </aside>
                <!-- /.control-sidebar -->
                <!-- Add the sidebar's background. This div must be placed
                     immediately after the control sidebar -->
                <div class="control-sidebar-bg"></div>
            </div>

            <div class="modal fade" id="modal-default" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Por favor recuerde su contraseña.<br>El sistema lo redigira a la pantalla de inicio una vez presione el botón grabar.<br> Deberá ingresar con su nueva clave!</h4>
                        </div>
                        <div class="modal-body">
                            <p>Ingresela aquí, mínimo cuatro carácteres y máximo diez!</p>
                            <input type="text" name="paswd" id="paswd" class="form form-control" alt="Nueva clave" minlength="4" maxlength="10" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" onclick="grabarClaveNueva()">Grabar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <!-- ./wrapper -->
            <!-- jQuery UI 1.11.4 -->
            <script src="../bower_components/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

            <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
            <script>
                                $.widget.bridge('uibutton', $.ui.button);
            </script>
            <a href="../bower_components/Gruntfile.js" type="text/javascript"></a>
            <!-- Bootstrap 3.3.7 -->
            <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
            <!-- Morris.js charts -->
            <script src="../bower_components/raphael/raphael.min.js" type="text/javascript"></script>
            <script src="../bower_components/morris.js/morris.min.js" type="text/javascript"></script>
            <!-- Sparkline -->
            <script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js" type="text/javascript"></script>
            <!-- jvectormap -->
            <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
            <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
            <!-- jQuery Knob Chart -->
            <script src="../bower_components/jquery-knob/dist/jquery.knob.min.js" type="text/javascript"></script>
            <!-- daterangepicker -->
            <script src="../bower_components/moment/min/moment.min.js" type="text/javascript"></script>
            <script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
            <!-- datepicker -->
            <script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
            <!-- Bootstrap WYSIHTML5 -->
            <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
            <!-- Slimscroll -->
            <script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
            <!-- FastClick -->
            <script src="../bower_components/fastclick/lib/fastclick.js" type="text/javascript"></script>
            <!-- AdminLTE App -->
            <script src="../dist/js/adminlte.min.js" type="text/javascript"></script>
            <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
            <script src="../dist/js/pages/dashboard.js" type="text/javascript"></script>
            <!-- AdminLTE for demo purposes -->
            <script src="../dist/js/demo.js" type="text/javascript"></script>
        </body>
    </html>
    <?php
} else {
    header("Location: ../index.php");
}
?>
