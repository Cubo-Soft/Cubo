<?php

include_once '../modelos/CL_ap_regiones.php';

$OB_ap_regiones = new CL_ap_regiones();
$retorno = array();

if ($_POST["caso"] === '1') {
    echo json_encode($OB_ap_regiones->leer(null, 1));
}
