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

            <link href="../css/datatables.min.css" rel="stylesheet" type="text/css"/>
            <script src="../bower_components/datatables.net/js/datatables.min.js" type="text/javascript"></script>

            <script src="../js/comunes.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vr_requerim.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/am_usuarios.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_dtbasicos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vr_cotiza.js?ramdom=<?= time() ?>" type="text/javascript"></script>

            <script src="../js/vistas/listados.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        </head>
        <body class="hold-transition skin-blue sidebar-mini">
            <input type="hidden" id="codprog" name="codprog" value="listados" />
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <input type="hidden" id="codusr" name="codusr" value='<?= $_SESSION["codusr"] ?>' />
            <div id="container">
                <section class="content-header">
                    <h3 id="nombreReporte"></h3>
                </section>
                <div class="box-body">
                    <div class="box box-primary">

                    </div>
                    <div class="box-body">
                        <div class="col-lg-12" id="requerimientos" >
                            <div class="col-lg-12" id="filtrosRequerimientos">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <strong>Filtros de búsqueda</strong>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-lg-12">
                                            <div class="col-lg-2">
                                                <label>Fecha inicial</label>
                                                <div>
                                                    <input type="date" class="form form-control" id="dtRInicial" name="dtRInicial" />
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Fecha final</label>
                                                <div>
                                                    <input type="date" class="form form-control" id="dtRFinal" name="dtRFinal" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Usuarios</label>
                                                <div id="divUsuarios">

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Estados</label>
                                                <div id="estadosRequerimiento">

                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <label></label>
                                                <div>
                                                    <input type="button" value="Buscar" class="btn btn-primary" id="btnBuscarRequerimiento" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div id="divRequerimientos" class="col-lg-12">
                                    <div id="divTituloRequerimientos" class="bg-light-blue-active color-palette">
                                        <center><strong>Listado de requerimientos</strong></center>
                                    </div>
                                    <div id="divListadoRequerimientos">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id="cotizaciones" >
                            <div class="col-lg-12" id="filtrosCotizaciones">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <strong>Filtros de búsqueda</strong>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-lg-12">
                                            <div class="col-lg-2">
                                                <label>Fecha inicial</label>
                                                <div>
                                                    <input type="date" class="form form-control" id="fecha_ini1" name="fecha_ini1" />
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Fecha final</label>
                                                <div>
                                                    <input type="date" class="form form-control" id="fecha_fin1" name="fecha_fin1" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Usuarios</label>
                                                <div id="divUsuarios2">

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Estados</label>
                                                <div id="estadosCotizacion">

                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <label></label>
                                                <div>
                                                    <input type="button" value="Buscar" class="btn btn-primary" id="btnBuscarCotizacion" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div id="divCotizaciones" class="col-lg-12">
                                    <div id="divTituloCotizaciones" class="bg-light-blue-active color-palette">
                                        <center><strong>Listado de cotizaciones</strong></center>
                                    </div>
                                    <div id="divListadoCotizaciones">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id="mantenimientos" >
                            <div class="col-lg-12" id="filtrosMantenimientos">
                                <div class="box box-default">
                                    <div class="box-header with-border">
                                        <strong>Filtros de búsqueda</strong>
                                    </div>
                                    <div class="box-body">
                                        <div class="col-lg-12">
                                            <div class="col-lg-2">
                                                <label>Fecha inicial</label>
                                                <div>
                                                    <input type="date" class="form form-control" id="fecha_ini2" name="fecha_ini2" />
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <label>Fecha final</label>
                                                <div>
                                                    <input type="date" class="form form-control" id="fecha_fin2" name="fecha_fin2" />
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Usuarios</label>
                                                <div id="divUsuarios3">

                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <label>Estados</label>
                                                <div id="estadosMantenimientos">

                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <label></label>
                                                <div>
                                                    <input type="button" value="Buscar" class="btn btn-primary" id="btnBuscarMantenimiento" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div id="divMantenimientos" class="col-lg-12">
                                    <div id="divTituloMantenimientos" class="bg-light-blue-active color-palette">
                                        <center><strong>Listado de mantenimientos</strong></center>
                                    </div>
                                    <div id="divListadoMantenimientos">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>
    <?php
}
