<?php
session_start();

header("Access-Control-Allow-Origin: https://titaninmochem.com/cubo/");

if (!isset($_SESSION["estado"])) {
    header("Location: ../index.php");
} else if ($_SESSION["estado"] === 'Activo') {

    //llama a la función para realizar la conversion del cliente Daniel2025
    require_once '../modelos/CL_vr_requerim.php';
    require_once '../modelos/CL_nm_nits.php';

    $id_requerim = $_GET['id_requerim'] ?? null;

    if ($id_requerim) {
        $requer = new CL_vr_requerim();
        $datos_requer = $requer->leer(["id_requerim" => $id_requerim], 2);

        // Validar si es cliente provisional sin convertir aún
        error_log("✅ DEBUG: Entrando a verificación de cliente provisional");

        if (
            isset($datos_requer['clien_provis']) &&
            intval($datos_requer['clien_provis']) === 1 &&
            empty($datos_requer['suc_cliente']) &&
            empty($datos_requer['id_contacto'])
        ) {
            error_log("✅ DEBUG: Se cumple condición, se va a convertir requerimiento: $id_requerim");
            $requer->convertirClienteProvisional($id_requerim); 
        }
    }


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
            <script src="../js/modelos/cp_tipo_importacion.js?ramdom=<?= time() ?>" type="text/javascript"></script>
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
            <script src="../js/modelos/vr_requerim.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vr_requerimdet.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vp_asesor_zona.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/am_usuarios.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/vistas/edit_requer.js?ramdom=<?= time() ?>" type="text/javascript"></script>

            <!-- inicio librerias datatables -->
            <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
            <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

            <!-- fin librerias datatables -->

        </head>
        <body style="background-color: #FFFDF2;">
            <input type="hidden" id="codprog" name="codprog" value="edit_requer" />            
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <input type="hidden" id="id_requerim" name="id_requerim" value='<?= $_GET["id_requerim"] ?>' />
            <input type="hidden" id="codusr" name="codusr" value='<?= $_SESSION["codusr"] ?>' />
            <input type="hidden" id="mostrar_iva" value="0" />
            <input type="hidden" id="personaNatural" value="0" />
            <input type="hidden" id="grup_items2" value="0" />
            <input type="hidden" id="tipos2" value="0" />
            <input type="hidden" id="marcas2" value="0" />

            <div id="container">

                <?php
                $datos["texto"] = "Editar requerimiento";
                $textoApoyo='<div class="col-lg-12"><center><strong>Esta usted en el módulo <strong>Edición del requerimiento</strong></strong></center></div><br/>';
                retornarDivInicialRequerimiento($datos, 2);
                retornarDivDatosInicialesEmpresa(1);                
                retornarDivJuridicas(2);
                retornarDivPersonasGeneral();
                retornarDivSucursalesGeneral();
                echo $textoApoyo;
                retornarDivContactosGeneral(2);
                retornarDivClientesProvisionales(1);

                if(intval($_SESSION["id_rol"])<=4){
                    retornarDivParametrosIniciales(1);
                }else{
                    retornarDivParametrosIniciales(2);
                }

                echo $textoApoyo;
                
                retornarDivRepuestos(1);
                retornarDivExistenciaMinima($datos,1);
                $datos["titulo"]="Existencias en otras bodegas";
                retornarDivModales($datos,1);      
                retornarDivEquipos(1);
                retornarDivServiciosMantenimiento(1);
                retornarDivFinalRequerimientos(null, 2);
                ?>                
        </body>
    </html>
    <?php
} else {
    header("Location: ../index.php");
}
?>