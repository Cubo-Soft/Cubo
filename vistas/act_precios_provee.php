<?php
session_start();

header("Access-Control-Allow-Origin: https://titaninmochem.com/cubo/");

if (!isset($_SESSION["estado"])) {
    header("Location: ../index.php");
} else if ($_SESSION["estado"] === 'Activo') {
    include_once("../css/def.php");
    define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
    include_once(C."/cls/clsTablam.php");
    include_once(C."/cls/cls_ar_roles.php");
    if($motor=="my"){
        include_once(C."/cls/clsBdmy.php");
    }
    include_once '../adicionales/varios.php';
    $odb = new Bd($h,$pto,$u,$p,$d);
    $tparam = new Tabla($odb,"ap_param");
    $ttrm   = new Tabla($odb,"cm_trm");
    $aempre = $tparam->leec("valor"," WHERE variable='nomempre'"); 
    $tmarcas= new Tabla($odb,"ip_marcas");
    $a_marcas=$tmarcas->lee("",0,"A");
    $tmpprecio = new Tabla($odb,"tmp_precio_provee");
    date_default_timezone_set("America/Bogota");
    $titulo = "Actualización Precios de Proveedores";
    $hoy = date('Y-m-d');
    //$hoy = "2025-03-02";
    //echo "<pre>";print_r($a_tmpPrecio);echo "<pre>";
    //print_r($_SESSION);echo "<br>";
    ?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <?= retornarCabeceraInicial($titulo) ?>
    
            <script src="../bower_components/inputmask/dist/jquery.inputmask.bundle.js" type="text/javascript"></script>
            <script src="../js/comunes.js?ramdom=<?= time() ?>" type="text/javascript"></script>    
            <script src="../js/modelos/ip_lineas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_marcas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_grupos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/im_items.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/am_usuarios.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/vistas/act_precios_provee.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/ajax.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/formato_valor.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <link rel="stylesheet" href="../css/ppal.css">
            <style>
                .valor{
                    text-align:right;
                }
            </style>
            <!-- inicio librerias datatables -->
            <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
            <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

            <!-- fin librerias datatables -->
            <script >
                function inicio(){
                        document.location.href="<?php echo $_SERVER['PHP_SELF'] ?>";
                }
            </script>

        </head>
        <body style="background-color: #FFFDF2;">

            <div class="container marco_ppal" style="width:50%">
                <?php include("./adiciones/cabeza.php"); ?>
                <form id="formCargue" method="POST" enctype="multipart/form-data" style="display:block">
                    <input type="hidden" id="codprog" name="codprog" value="act_precio" />            
                    <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
                    <input type="hidden" id="coduser" name="coduser" value='<?= $_SESSION["codusr"] ?>' />
                    <input type="hidden" id="id_moneda" value="35" />
                    <input type="hidden" id="marcas2" value="0" />
                    <div class="row">
                        <div class='col-sm-2'></div>
                        <div class='col-sm-8'>
                            <H3>Ingrese los valores requeridos:</H3>
                        </div>
                        <div class='col-sm-2'>
                            <input type="text" id="fechaCarga" value="<?= $hoy ?>" size="7" readonly/> 
                        </div>    
                    </div>
                    <div id="imagen_carga" style="width:30%;margin:auto;display:none;">
                        <img src="../img/tenor.gif" alt="" width="50px">
                    </div>
                    <div class="container" style="border:solid 1px;width:65%;background-color:aliceblue;margin-bottom:20px;overflow-y:auto">

                        <div class="row">
                            <div  style="border:solid 1px;padding:2pt">
                                <label for="referencia">Archivo CSV a cargar:
                                Estructura:  Item;LP;descripción;Precio Proveedor</label>
                                <b>NOTA: recuerde que el ";" es separador de campos.</b>
                                <input type="file" name="file" id="file" style="width:99%">
                            </div>
                        </div>
                        <div>
                            <label for="id_marca" style="margin-left:80px">Marca:</label>
                            <select name="id_marca" id="id_marca" style="width:180px">
                                <?php
                                for($x=0; $x<count($a_marcas);$x++){
                                    echo '<option value="'.$a_marcas[$x]['id_marca'].'" title="'.$a_marcas[$x]['id_marca'].'">'.$a_marcas[$x]['nom_marca'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div style="width:30%;margin:auto;">
                        <input type="submit" class="btn btn-warning btn-sm" style="color:black" value="Cargar" title="Cargar archivo Plano CSV">
                    </div>      
                    <br>              
                </form>
                <div id="idCarguePlano"  style="width:40%;margin:auto;display:none">
                    <label for="btnProcesa">Procesar archivo CSV:</label>
                        <input type="button" id="btnProcesa" value="Procesar" title="Procesar CSV" class="btn btn-success btn-sm">
                </div>
                <div id="idMensaje">

                </div>
            </div>
        </body>
    </html>
    <?php
} else {
    header("Location: ../index.php");
}
?>