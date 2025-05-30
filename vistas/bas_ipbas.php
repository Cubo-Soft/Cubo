<?php
session_start();

header("Access-Control-Allow-Origin: https://titaninmochem.com/cubo/");

if (!isset($_SESSION["estado"])) {
    header("Location: ../index.php");
} else if ($_SESSION["estado"] === 'Activo') {
    include_once '../adicionales/varios.php';
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <?= retornarCabeceraInicial("Cubo") ?>
            <script src="../js/comunes.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_basicos.js?ramdom=<?= time() ?>" type="text/javascript"></script>            
            <script src="../js/modelos/ip_dtbasicos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/vistas/basicos_ipbasicos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        </head>
        <body class="hold-transition skin-blue sidebar-mini">
            <input type="hidden" id="codprog" name="codprog" value="bas_ipbas" />
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <input type="hidden" id="permisos" name="permisos" value="" />   
            <div id="container">  
                <h3>Básicos - IP Básicos</h3>
                <div class="box-body">                     
                    <div class="form-group">
                        <label>Básicos</label>
                        <div id="divListaBasicos"></div>
                    </div>            
                    <div class="form-group">                
                        <label>Valores en DT Básicos</label>
                        <div id="divIPDtbasicos"></div>
                    </div>
                    <div class="form-group" id="divNuevoDTBasico">                
                        <label>Nuevo valor para DT Básico</label>
                        <div>
                            <div class="col-lg-6">
                                <input type="text" class="form form-control" id="dt_basico" name="dt_basico" placeholder="Nuevo valor" />
                            </div>
                            <div class="col-lg-6">
                                <input type="button" class="btn btn-info" id="btnCrearDTBasico" name="btnCrearDTBasico" value="Crear" />
                            </div>                            
                        </div>
                    </div>
                    <div id="mensajes" class="col-lg-12"></div>
                </div>
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