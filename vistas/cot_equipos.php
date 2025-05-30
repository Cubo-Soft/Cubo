<?php
session_start();

header("Access-Control-Allow-Origin: https://titaninmochem.com/cubo/");

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

            <!-- inicio librería mapa -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
            <!-- fin libreria mapa -->

            <script src="../bower_components/inputmask/dist/jquery.inputmask.bundle.js" type="text/javascript"></script>
            <script src="../js/comunes.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_dtbasicos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_contactos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ap_regiones.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/np_ciudades.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/np_paises.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_nits.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_juridicas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_lineas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_tipos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_marcas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_unidades.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_voltajes.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_dimen.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_presiones.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_modelos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_personas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_sucursal.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_grupos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ir_caracte.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ir_salinve.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vm_clientesprov.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/im_items.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_compleme.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/cm_trm.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vp_terminospago.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vp_vigencia.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vr_cotiza.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vr_cotizadet.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vr_cotizcar.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/vistas/cot_equipos.js?ramdom=<?= time() ?>" type="text/javascript"></script>

            <!-- inicio librerias datatables -->
            <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet"
                type="text/css" />
            <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
            <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

            <!-- fin librerias datatables -->

        </head>

        <body style="background-color: #FFF1F4;">
            <input type="hidden" id="codprog" name="cot_equipos" value="cot_equipos" />
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <input type="hidden" id="id_consecot" name="id_consecot" value='<?= $_GET["id_consecot"] ?>' />
            <input type="hidden" id="maximo" name="maximo" value='0' />
            <input type="hidden" id="personaNatural" value="0" />
            <input type="hidden" id="iva" value="0" />
            <input type="hidden" id="mostrar_iva" value="1" />
            <input type="hidden" id="id_cargo" value="<?= $_SESSION["id_cargo"] ?>" />
            <div id="container">

                <?php
                $datos["texto"] = "Cotización equipos";
                $datos["trm"] = $trm;
                retornarDivInicialRequerimiento($datos, 3);
                retornarDivDatosInicialesEmpresa(1);
                retornarDivJuridicas(2);
                retornarDivPersonasGeneral();
                retornarDivSucursalesGeneral();
                retornarDivContactosGeneral(2);
                retornarDivClientesProvisionales(1);
                ?>

                <div class="box-body">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <div>

                            </div>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <label>Terminos de pago</label>
                                    <div id="divTerminosDePago">

                                    </div>
                                </div>
                                <div class="col-lg-6" id="divMonedas">
                                    <label>Moneda</label>
                                    <div class="col-lg-12" id="divValorMonedas"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="col-lg-12" id="mensajesTerminosDePago">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            retornarDivParametrosIniciales(2);
            retornarDivRepuestos(1);
            retornarDivEquipos(1);
            retornarDivServiciosMantenimiento(1);
            retornarDivFinalRequerimientos(null, 3);
            ?>
        </body>

        </html>
    <?php
} else {
    header("Location: ../index.php");
}
?>