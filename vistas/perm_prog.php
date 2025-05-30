<?php
session_start();

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

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
            <script src="../js/modelos/ap_programs.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/am_usuarios.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ap_opc_permi.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ap_permpro.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/vistas/permisosdeprograma.js?ramdom=<?= time() ?>" type="text/javascript"></script>            
        </head>
        <body class="hold-transition skin-blue sidebar-mini">
            
            <input type="hidden" id="codprog" name="codprog" value="perm_prog" />
            <div class="container">
                <h3>Permisos de programa</h3>
                <div class="box-body">
                    <div id="mensajes" class="col-lg-12"></div>
                    <div class="form-group">                    
                        <label>Código de Programa</label>                    
                        <div id="divListaAPPrograms"></div>
                    </div>
                    <div class="form-group">
                        <label>Permisos</label>            
                        <div id="divGrupoPermisos"></div>
                    </div>             
                    <div class="form-group">
                        <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-default">Crear permiso</button>
                    </div>                 
                </div>
                <!-- modal para llamar al programa carga.php?tabla=ap_opc_permi -->
                <div class="modal fade" id="modal-default" style="display: none;">                
                    <div class="modal-dialog">
                        <div class="modal-content">                        
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onclick="retornarPermisos(1)">
                                    <span aria-hidden="true">×</span>
                                </button>                            
                            </div>
                            <div class="modal-body">
                                <iframe width="700" height="350" style="width: 800px;float:left" scrolling="yes" frameborder="0" src="carga.php?tabla=ap_opc_permi"></iframe>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info pull-left" data-dismiss="modal" onclick="retornarPermisos(1)" >Recargar permisos</button>
                                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                            </div>
                        </div>
                        /.modal-content
                    </div>
                    /.modal-dialog 
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