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

            <!-- inicio librería mapa -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
            <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>   
            <!-- fin libreria mapa -->

            <script src="../bower_components/inputmask/dist/jquery.inputmask.bundle.js" type="text/javascript"></script>
            <script src="../js/comunes.js?ramdom=<?= time() ?>" type="text/javascript"></script>    
            <script src="../js/modelos/ip_dtbasicos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_contactos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
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
            <script src="../js/modelos/vp_asesor_zona.js?ramdom=<?= time() ?>" type="text/javascript"></script>            
            <script src="../js/modelos/im_items.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_compleme.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ap_regiones.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vr_requerimdet.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/im_bodeg.js?ramdom=<?= time() ?>" type="text/javascript"></script>

            <script src="../js/vistas/bode_repu.js?ramdom=<?= time() ?>" type="text/javascript"></script>

            <!-- inicio librerias datatables -->
            <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
            <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

            <!-- fin librerias datatables -->

        </head>
        <body style="background-color: #FFFFFF;">
            <input type="hidden" id="codprog" name="codprog" value="bode_repu" />            
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <input type="hidden" id="codusr" name="codusr" value='<?= $_SESSION["codusr"] ?>' />            
            <div id="container">

                <div class="box-body">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <strong>Administración de repuestos en bodegas</strong>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12">
                                <div class="col-lg-2">
                                    <label>Bodegas</label>
                                </div>
                                <div class="col-lg-4" id="divBodegas">

                                </div>
                                <div class="col-lg-2">
                                    <label>Código repuesto</label>
                                </div>
                                <div class="col-lg-3" id="divCodItem">

                                    <?php
                                          $datos['idDelCampo'] = 'cod_item';
                                          $datos['nombreLista'] = 'Cod_Item';
                                          $datos['idResultado'] = 'cod_item_2';
                                          $datos['nombreDataList'] = 'Repuestos';
                                          $datos['textoPlaceHolder'] = 'Código del repuesto';
                                          $datos['valorPorDefecto'] = '';
                                          echo retorarCodigoParaListaPHP($datos);
                                    ?>
                                    
                                </div>
                                <!--<div class="col-lg-1">
                                    <input type="button" class="btn btn-success" value="Consultar" id="btnConsultarBodegas" name="btnConsultarBodegas" />
                                </div>-->
                            </div>
                            <br/>
                            <br/>
                            <div class="col-lg-12" id="divTablaBodegas"></div>
                            <div class="col-lg-12" id="divTablaReservados"></div>
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