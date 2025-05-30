<?php
session_start();
if (!isset($_SESSION['id_rol'])) {
    unset($_SESSION);
    session_destroy();
    header("location:index.php");
}
include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
include(C . "/cls/clsTablam.php");
include(C . "/cls/cls_ar_roles.php");
if ($motor == "my") {
    include(C . "/cls/clsBdmy.php");
}
if (isset($_REQUEST['op'])) {
    $op = $_REQUEST['op'];
    unset($_REQUEST['op']);
} else {
    $op = "";
}
if (isset($_REQUEST['btsav'])) {
    $btsav = $_REQUEST['btsav'];
    unset($_REQUEST['btsav']);
} else {
    $btsav = "";
}

/* Inicio */
if (isset($op) && $op > 4) {
    exit('Viene ' . $op);
}

$odb = new Bd($h, $pto, $u, $p, $d);
$tabla = new Tabla($odb, "nm_sucursal");
//$existe = $tabla->ejec("show tables LIKE '".$tabla->nomTabla."'","S");
$tparam = new Tabla($odb, "ap_param");
$aempre = $tparam->leec("valor", " WHERE variable='nomempre'");
$per_rol = new cls_ar_roles($odb, "ar_roles");
$nits = new Tabla($odb, "nm_nits");
$ciudades = new Tabla($odb, "np_ciudades");
$paises = new Tabla($odb, "np_paises");

$per = $per_rol->permi($_SESSION['id_rol'], "sucursales");
echo "Permisos:";
print_r($per);
$campo = "";
?>
<!DOCTYPE html>
<html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Sucursales</title>
        <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
        <!-- <link rel='stylesheet' type='text/css' href='../css/ppal.css'> -->
        <!--<style>
         
        .fondo_gris{
          background-color:#CCC;
        }
    
        .fondo_negro{
          background-color:black;
        }
    
        .letras_blancas{
          color:#EEE;
        }
    
        .marco_ppal{
          width:50%;
          /* margin:auto; */
          background-color:rgb(150,201, 252);   /* rgb(171, 219, 37); */
          /* padding:1em; */
          border-radius:20px;
        }
      
        .titulo_empresa{
          background-color:#EEE;
          font-size:1.8em;
          text-align:center;
          border-radius:13px;
        }
    
        </style>-->
        <script >

            function mode(op) {
                //alert('Opcion: '+op);
                document.forms[0].op.value = op;
                ejec();
            }

            function ejec() {
                document.forms[0].submit();
            }

            function inicio() {
                document.location.href = '/alfrio/view/sucursal.php';
            }

            function sale() {
                document.location.href = 'index.php';
            }

            function anular(e) {
                tecla = (document.all) ? e.keyCode : e.which;
                return (tecla != 13);
            }
        </script>

    </head>
    <body  >        
        <!--   rgb(226, 231, 250) -->
        <!-- style='background-color:rgb(150,201, 252);width:50%;border-radius:20px;' -->
        <div class='container-fluid marco_ppal' >
            <div class='row' >
                <div class='col-sm-3'></div>  
                <div class='col-sm-6 titulo_empresa' >Alfrio S.A.S.</div>
                <div class='col-sm-3'></div>
            </div>
            <form name='Interface' method='post' onkeypress='return anular(event)'>
                <input type='hidden' name='tabla' value='nm_sucursal'>
                <input type='hidden' name='nomprg' value='nm_sucursal'>
                <div class='row' style='background-color:#000;'>
                    <div class='col-sm-5 letras_blancas' ><H3>Sucursales</H3></div>
                    <div class='col-sm-3 letras_blancas' id='accion'></div>
                    <div class='col-sm-4'></div>
                </div>

                <div class='row'>
                    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
                        <label for='numid' class='form-label'><B> numid :</B></label>
                    </div>
                    <div class='col-sm-8'>
                        <?php
                        $clase = " class='form form-select' ";
                        echo $nits->selecc($nits->Cam[0], $clase);
                        ?>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
                        <label for='orden' class='form-label'><B> orden :</B></label></div>
                    <div class='col-sm-8'>
                        <input type='int' id='orden' name='orden' class='form-control' value='0' 
                               maxlength='10'  tabindex='2' ></div></div>
                <div class='row'>
                    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
                        <label for='direccion' class='form-label'><B> direccion :</B></label></div>
                    <div class='col-sm-8'>
                        <input type='text' id='direccion' name='direccion' class='form-control' 
                               maxlength='200'  tabindex='3' ></div></div>
                <div class='row'>
                    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
                        <label for='telefono' class='form-label'><B> telefono :</B></label></div>
                    <div class='col-sm-8'>
                        <input type='text' id='telefono' name='telefono' class='form-control' 
                               maxlength='35'  tabindex='4' ></div></div>
                <div class='row'>
                    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
                        <label for='ciudad' class='form-label'><B> ciudad :</B></label></div>
                    <div class='col-sm-8'>
                        <?php
                        $clase = " class='form form-select'";
                        $opcion = "11001";
                        echo $ciudades->selecc($ciudades->Cam[0], $clase, $opcion);
                        ?>
                    </div></div>
                <div class='row'>
                    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
                        <label for='pais' class='form-label'><B> pais :</B></label></div>
                    <div class='col-sm-8'>
                        <?php
                        $clase = " class='form form-select'";
                        $opcion = "7";
                        echo $paises->selecc($paises->Cam[0], $clase, $opcion);
                        ?>

                    </div></div>
                <div class='row'>
                    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
                        <label for='nom_sucur' class='form-label'><B> nombre de sucursal :</B></label></div>
                    <div class='col-sm-8'>
                        <input type='text' id='nom_sucur' name='nom_sucur' class='form-control' 
                               maxlength='30'  tabindex='7' ></div></div>
                <div class='row'>
                    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
                        <label for='suc_lat_gps' class='form-label'><B> suc_lat_gps :</B></label></div>
                    <div class='col-sm-8'>
                        <input type='text' id='suc_lat_gps' name='suc_lat_gps' class='form-control' 
                               maxlength='10'  tabindex='8' ></div></div>
                <div class='row'>
                    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
                        <label for='suc_lng_gos' class='form-label'><B> suc_lng_gos :</B></label></div>
                    <div class='col-sm-8'>
                        <input type='int' id='suc_lng_gos' name='suc_lng_gos' class='form-control' 
                               maxlength='10'  tabindex='9' >
                    </div>
                </div>

                <div class='row'>
                    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
                        <label for='id_sucursal' class='form-label'><B> id_sucursal :</B></label>
                    </div>
                    <div class='col-sm-8'>
                        <input type='int' id='id_sucursal' name='id_sucursal' class='form-control' 
                               maxlength='10'  id='prim' pattern='[0-9]' placeholder='Numero' onblur='ejec();'  value='0' tabindex='0' >
                    </div>
                </div>

                <div class='btn-group'>
                    <button type='submit' name='btsav' class='btn btn-primary btn-sm' id='btsav'  disabled  >Guardar</button>
                    <button type='reset' name='btcan' class='btn btn-primary btn-sm' onclick='javascript:inicio()' >Cancelar</buton>
                        <button type='button' name='bteli' class='btn btn-danger btn-sm' onclick='javascript:mode(3)' id='bteli'  disabled  >Eliminar</buton>
                            <button type='button' name='btlis' class='btn btn-success btn-sm' onclick="javascript:mode(4);" id='btlis'  disabled  >Listar</buton>
                                <button type='button' name='btsal' class='btn btn-dark btn-sm' onclick='javascript:sale()' >Salir</buton>
                                    </div>
                                    <input type='text' name='op' value='0' size='1'>
                                    </form> 
                                    </div>
                                    <script src='js/bootstrap.bundle.min.js'></script>
                                    <script>

                                    var op = document.forms[0].op.value;
                                    var accion = document.getElementById('accion');
                                    var btsav = document.getElementById('btsav');
                                    var bteli = document.getElementById('bteli');
                                    var btlis = document.getElementById('btlis');
                                    const a_per = [];

                                    switch (op) {
                                        case '0':
                                            accion.innerHTML = '<H4>Consultar</H4>';
                                            if (a_per.includes('L')) {
                                                btlis.disabled = '';
                                            }
                                            break;
                                        case '1':
                                            accion.innerHTML = '<H4>Adicionar</H4>';
                                            btsav.innerHTML = 'Adicionar';
                                            if (a_per.includes('A')) {
                                                btsav.disabled = '';
                                            }
                                            break;
                                        case '2':
                                            accion.innerHTML = '<H4>Modificar</H4>';
                                            btsav.innerHTML = 'Modificar';
                                            if (a_per.includes('M')) {
                                                btsav.disabled = '';
                                            }
                                            if (a_per.includes('E')) {
                                                bteli.disabled = '';
                                            }
                                            break;
                                    }

                                    let campo = '';
                                    if (campo != '') {
                                        document.getElementById(campo).focus();
                                    }
                                    </script>
                                    </body>
                                    </html>
