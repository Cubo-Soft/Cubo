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
            <script src="../js/modelos/ap_alertas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vr_cotiza.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/vistas/alertas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <!-- inicio librerias datatables -->
            <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
            <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

            <!-- fin librerias datatables -->

        </head>
        <body class="hold-transition skin-blue sidebar-mini">
            <input type="hidden" id="codprog" name="codprog" value="alertas" />
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <input type="hidden" id="usuario_asignd" name="usuario_asignd" value="<?= $_SESSION["codusr"] ?>" />
            <input type="hidden" id="codusr" name="codusr" value="<?= $_SESSION["codusr"] ?>" />

            <div id="container">

                <section class="content-header">
                    <h3>Alertas</h3>
                </section>
                <div class="box-body">
                    <div class="box box-primary">

                    </div>
                    <div class="box-body">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-3 col-xs-6" id="divReqComercial">
                                    <!-- small box -->
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                                <h3 id="totalReqComercial"></h3>
                                                <p>Requerimientos comercial</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="listados.php?id_alerta=1" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xs-6" id="divCotComercial">
                                    <!-- small box -->
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                                <h3 id="totalCotComercial"></h3>
                                                <p>Cotizaciones comercial</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <a href="listados.php?id_alerta=2" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xs-6" id="divReqCompras">
                                    <!-- small box -->
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                                <h3 id="totalReqCompras">0</h3>
                                                <p>Requerimientos compras</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="listados.php?id_alerta=3" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xs-6" id="divReqProveedor">
                                    <!-- small box -->
                                    <div class="small-box bg-blue">
                                        <div class="inner">
                                                <h3 id="totalReqProveedor">0</h3>
                                                <p>Requerimientos proveedores</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-pricetag"></i>
                                        </div>
                                        <a href="compras.php" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xs-6" id="divMantenimientos">
                                    <!-- small box -->
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                                <h3 id="totalMantenimientos">0</h3>
                                                <p>Mantenimientos por revisar</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-hammer"></i>                                            
                                        </div>
                                        <a href="listados.php?id_alerta=4" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xs-6" id="divReqCompras">
                                    <!-- small box -->
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                                <h3 id="totalReqCompras">$<?= $_SESSION["trmHoy"] ?></h3>
                                                <p>Precio dolar</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-cash"></i>
                                        </div>
                                        <a href="#" onclick="window.top.location.href = 'index.php?motrarValorTRM=0'" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div id="mensajes" class="col-lg-12"></div>
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
