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
            <script src="../js/vistas/inventa.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        </head>
        <body class="hold-transition skin-blue sidebar-mini">
            <input type="hidden" id="codprog" name="codprog" value="inventa" />            
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <div id="container">
                <section class="content-header">
                    <h3>Administración inventario</h3>
                </section>                
                <div class="box-body">
                    <div class="box box-primary">
                        
                    </div>
                    <div class="box-body">
                                                                         
                    </div>                    
                </div>                
        </body>
    </html>
    <?php
} else {
    header("Location: ../index.php");
}
?>