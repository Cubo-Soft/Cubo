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
            <script src="../js/modelos/sr_prog_mant.js?ramdom=<?= time() ?>" type="text/javascript"></script>

            <script src="../js/vistas/toma_requer.js?ramdom=<?= time() ?>" type="text/javascript"></script>

            <!-- inicio librerias datatables -->
            <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
            <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
            <!-- fin librerias datatables -->

        </head>
        <body style="background-color: #DFF4FF;">
            <input type="hidden" id="codprog" name="codprog" value="toma_requer" />            
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <input type="hidden" id="codusr" name="codusr" value='<?= $_SESSION["codusr"] ?>' />            
            <input type="hidden" id="personaNatural" value="0" />            
            <input type="hidden" id="id_requerim" value="0" />
            <input type="hidden" id="repuesto_existe" value="1" />
            <input type="hidden" id="mostrar_iva" value="0" />

            <input type="hidden" id="grup_items2" value="0" />
            <input type="hidden" id="tipos2" value="0" />
            <input type="hidden" id="marcas2" value="0" />

            <input type="hidden" id="id_mantenimientos" value="0" />

            <div id="container">
                <?php
                $datos["texto"] = "Esta usted en el módulo de <strong>Toma del requerimiento</strong>";
                $datos["titulo"]="Existencias en otras bodegas";
                $textoApoyo='<div class="col-lg-12"><center><strong>Toma del requerimiento</strong></center></div>';
                retornarDivInicialRequerimiento($datos, 1);
                retornarDivDatosInicialesEmpresa(1);    
                retornarDivJuridicas(2);
                retornarDivPersonasGeneral();
                retornarDivSucursalesGeneral();               
                retornarDivContactosGeneral(2);            
                retornarDivClientesProvisionales(1);    
                retornarDivParametrosIniciales(1);             
                retornarDivRepuestos(1);         
                retornarDivModales($datos,1);     
                echo $textoApoyo;
                retornarDivEquipos(1);   
                retornarDivServiciosMantenimiento(1);   
                retornarDivFinalRequerimientos(null, 1);                
                echo $textoApoyo;                // voy aqui
                ?>
        </body>
    </html>
    <?php
} else {
    header("Location: ../index.php");
}
?>