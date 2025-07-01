<?php
session_start();

if (!isset($_SESSION["estado"])) {
    header("Location: ../index.php");
} else if ($_SESSION["estado"] === 'Activo') {
    include_once '../adicionales/varios.php';
    include_once '../cls/varios.php';

    $trm = lee_politrm();

?>
    <!DOCTYPE html>
    <html>

    <head>
        <?= retornarCabeceraInicial("Cubo") ?>

        <script src="../bower_components/inputmask/dist/jquery.inputmask.bundle.js" type="text/javascript"></script>
        <script src="../js/comunes.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        <script src="../js/modelos/ip_dtbasicos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        <script src="../js/modelos/nm_juridicas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        <script src="../js/modelos/nm_personas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        <script src="../js/modelos/im_items.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        <script src="../js/modelos/ir_operaciones.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        <script src="../js/modelos/ir_detalle_oper.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        <script src="../js/vistas/compras.js?ramdom=<?= time() ?>" type="text/javascript"></script>

        <!-- inicio librerias datatables -->
        <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

        <!-- fin librerias datatables -->

    </head>

    <body>
        <input type="hidden" id="codprog" name="codprog" value="compras" />
        <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
        <input type="hidden" id="iva" value="0" />
        <input type="hidden" id="mostrar_iva" value="1" />
        <input type="hidden" id="trm" value="<?= $trm ?>" />
        <input type="hidden" id="id_cargo" value="<?= $_SESSION["id_cargo"] ?>" />
        <div id="container">
            <div class="box-body">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <label>Generador de reporte para solicitar cotización a proveedores REQ</label>
                    </div>
                    <div class="box-body">
                        <div class="col-lg-12">
                            <div class="col-lg-3">
                                <label>Buscar por</label>
                                <div id="divListado1">
                                    <select id="criterioBusqueda1" name="criterioBusqueda1" class="form-control">
                                        <option value="-1">...</option>
                                        <option value="0">ENTIDAD</option>
                                        <option value="1">SOLICITANTE</option>
                                        <option value="2">PRODUCTO</option>
                                        <option value="3">SOC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <label id="lblCriterio">...</label>
                                <div id="divCriterio">
                                    <div id="divRazonSocial">

                                    </div>
                                    <div id="divComercial">

                                    </div>
                                    <div id="divProducto">

                                    </div>
                                    <div id="divCliente">

                                    </div>
                                    <div id="divSOC_REQ">

                                    </div>
                                </div>
                                <div id="divMsjCriterio"></div>
                            </div>
                            <div class="col-lg-4">
                                <div class="col-lg-6">
                                    <label>Fecha inicial</label> <input type="date" id="fechaInicial" name="fechaInicial" class="form-control" />
                                </div>
                                <div id="" class="col-lg-6">
                                    <label>Fecha final</label> <input type="date" id="fechaFinal" name="fechaFinal" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">

                        </div>
                        <div class="col-lg-12">
                            <br />
                            <div class="bg-light-blue-active color-palette">
                                <center><strong>Listado de requerimientos</strong></center>
                            </div>
                            <div id="divResultado" class="scrollable-div" >

                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-6">
                                <label>Estado requerimiento</label>
                                <div id="divEstadoRequerimiento">

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <br />
                                <input type="button" class="btn btn-primary" value="Consultar" id="consultar" />
                                <button class="btn btn-success" id="guardar" name="guardar" title="Guardar cambios"><span class="fa fa-save"></span></button>
                                <button class="btn btn-success" id="generarPDF" name="generarPDF" title="Ver PDF"><span class="fa fa-file-pdf-o"></span></button>
                                <button class="btn btn-info" id="enviarSolicitud" name="enviarSolicitud" title="Enviar cotización"><span class="fa fa-send-o"></span></button>
                                <input type="button" value="Limpiar" class="btn btn-info" onclick="location.reload()" />
                            </div>
                        </div>
                        <div class="col-lg-12" id="divMensajes">

                        </div>
                    </div>
                </div>
            </div>
    </body>

    </html>
<?php
} else {
    header("Location: ../index.php");
}
?>