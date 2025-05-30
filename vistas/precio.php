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
    $aempre = $tparam->leec("valor"," WHERE variable='nomempre'"); 
    $ttrm   = new Tabla($odb,"cm_trm");
    $tmarcas= new Tabla($odb,"ip_marcas");
    $a_marcas=$tmarcas->lee("",0,"A");
    $trolpr = new Tabla($odb,"cp_rol_precio"); 
    date_default_timezone_set("America/Bogota");
    $titulo = "Precio/Costo de Productos";
    $sql = "SELECT t.*,mon.alf_codigo AS abr_moneda FROM cm_trm t, am_monedas mon WHERE mon.id = t.id_moneda AND t.trm != 0 ORDER BY fecha DESC LIMIT 1";
    $a_trm = $ttrm->ejec($sql,"S","A");
    //print_r($_SERVER['HTTP_HOST']);echo "<br>";
    //print_r($_SERVER['REQUEST_URI']);echo "<br>";
    $id_rol = $_SESSION['id_rol'];
    $titInterface = "Consultar ";
    if( $id_rol <= 3 ){
        $titInterface = "Consultar Precio Venta / Costo Ingenieria";
        $arolpr = ['salem','engco'];
    }else{
        $arolpr = $trolpr->lee(" WHERE id_rol=".$id_rol,0,"A");
        for($x=0; $x < count( $arolpr ); $x++){
            switch( $arolpr[$x]['fact_corto'] ){
                case 'salem': $titInterface .= " Precio de Venta"; break;
                case 'engco': $titInterface .= " Costo Ingeniería ";break;
            }
        }
    }
    //print_r($arolpr);
    
    //Consultar de Precios de Venta:
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <?= retornarCabeceraInicial($titulo) ?>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
            <script src="../bower_components/inputmask/dist/jquery.inputmask.bundle.js" type="text/javascript"></script>
            <script src="../js/comunes.js?ramdom=<?= time() ?>" type="text/javascript"></script>    
            <script src="../js/modelos/ip_lineas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_tipos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_marcas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_unidades.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_voltajes.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_dimen.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_presiones.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_modelos.js?ramdom=<?= time() ?>" type="text/javascript"></script>            
            <script src="../js/modelos/ip_grupos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ir_salinve.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/im_items.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/am_usuarios.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/vistas/precio.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/ajax.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/formato_valor.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <link rel="stylesheet" href="../css/ppal.css" type="text/css">
            <style>
                .valor{
                    text-align:right;
                }
                tr {
                    margin:0px;
                }
                #barraBotones{
                    width:240px;
                    height:40px;
                    margin:auto;
                    border-radius:5px;
                    padding-top:4px;
                    padding-left:5px;
                    background-color:#EEE;
                }
                #divSubePlano{
                    display:none;
                    width:460px;
                    background-color:rgb(150,201,252);
                    border-radius:5px;
                    padding-top:10px;
                    padding-left:10px;
                    margin-left:300px;
                }
                #divReferErradas{
                    display:none;
                    width:460px;
                    background-color:indianred;
                    border-radius:5px;
                    padding-top:10px;
                    padding-left:10px;
                    margin-left:300px;
                    margin-bottom:10px;
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
            <input type="hidden" id="codprog" name="codprog" value="precio" />            
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <input type="hidden" id="codusr" name="codusr" value='<?= $_SESSION["codusr"] ?>' />
            <input type="hidden" id="refProvee" value="true" />
            <input type="hidden" id="tipos2" value="0" />
            <input type="hidden" id="marcas2" value="0" />

            <div class="container marco_ppal" style="width:70%;">
                <?php include("./adiciones/cabeza.php"); ?>
                <div id="idMensajePpal">
                    &nbsp;
                </div>
                <div class="row">
                    <div class='col-sm-3'></div>
                    <div class='col-sm-6'>
                        <H3 id='idTituloInterface'><?php echo $titInterface ?></H3>
                    </div>
                    <div class='col-sm-3'></div>    
                </div>
                <div id="imagen_carga" style="width:30%;margin:auto;display:none;">
                   <!-- <img src="../img/loading.gif" alt="" width="80px"> -->
                    <img src="../img/tenor.gif" alt="" width="50px">
                </div>
                <!-- despliegue de los datos -->
                <div id="divDatos" >
                    <table style="background-color:darkseagreen;margin-bottom:10px;">
                        <thead>
                            <tr style="background-color:#256E8A;color:#FFFFFF;">
                                <th style="width:6%;text-align:center;">#</th>
                                <th style="width:21%;text-align:center;">Código Proveedor</th>
                                <th style="width:5%;text-align:center;">Cant</th>
                                <th style="width:12%;text-align:center;">Marca</th>
                                <th style="width:30%;text-align:center;">Descripción</th>
                                <th style="width:4%;text-align:center;">Divisa</th>
                                <th style="width:9%;text-align:center;">Vr.Unit</th>
                                <th style="width:12%;text-align:center;">Vr. Total</th>
                                <th style="width:1%;text-align:center;">B</th>
                            </tr>
                        </thead>
                        <tbody id="body_precios">
                            <tr style="height:0pt;padding:0pt;">
                                <td><input type="number" name='consec_1' id="consec_1" style="width:100%" min=1 step=1 value='1' class='valor' readonly></td>
                                <td><input type="text"   name='refProvee_1' id="refProvee_1" style="width:100%" maxlength='30' onchange="busca_precio(this);"></td>
                                <td><input type="number" name='cant_1' id="cant_1" style="width:100%" min=1 max=200 step=1 value='1' class='valor' onchange="cant(this);"></td>
                                <td><input type="text"   name='marca_1' id="marca_1"  style="width:100%" readonly></td>
                                <td><input type="text"   name='descrip_1' id="descrip_1" style="width:100%" readonly></td>
                                <td><input type="text"   name='divisa_1' id="divisa_1" style="width:100%" readonly></td>
                                <td><input type="text"   name='vrUnit_1' id="vrUnit_1"  style="width:100%" class='valor' readonly></td>
                                <td><input type="text"   name='vrTotal_1' id="vrTotal_1" style="width:100%" class='valor' readonly></td>
                                <td><input type='button' name='bor_1' id="bor_1" value='X' title='Borrar línea 1' onclick='borrar(this);'></td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="barraBotones">
                        <button type="button" class="btn btn-primary btn-sm" onclick="location.reload();" title="Nueva Búsqueda">Nueva</button>
                        <button type="button" id="idSubPlano" class="btn btn-warning btn-sm" title="Carga Plano csv" style="color:black" >Carga</button>
                        <button type="button" id="idGenPlano" class="btn btn-primary btn-sm" title="Genera Plano en pantalla" >Plano</button>
                        <button type="button" id="idExcel"    class="btn btn-success btn-sm" title="Generar Archivo Excel">Excel</button>
                    </div>
                </div>
                <div id="divTabla" style="display:none">

                </div>
            </div>         
            <br>         
            <div id="divSubePlano" >
                <h3>Cargue de Archivo CSV</h3>
                <form id="formCargue" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="coduser" name="coduser" value='<?= $_SESSION["codusr"] ?>' />
                    <label for="idCarguePlano">Seleccione el archivo CSV (debe contener referencia;cantidad):</label>
                    <input type="file" name="file" id="file" style="background-color:aliceblue" required>
                    <button type="submit" class="btn btn-warning btn-sm" style="color:black">Cargar</button>
                </form>
                <br>
                <div id="idMensaje">

                </div>
            </div>
            <div id="divReferErradas" >
                <H4>Referencias NO Existentes</H4>
                <ol start="1" id="ulReferErradas">
                    
                </ol>
                <br>
            </div>
            <br>
        </body>
    </html>
    <?php
} else {
    header("Location: ../index.php");
}
?>