<?php

include_once '../modelos/CL_ap_opc_permi.php';

$OB_ap_opc_permi = new CL_ap_opc_permi();

/*
 * proviene de ../js/modelos/ap_opc_permi.js opcion 1
 * retorna la lista de permisos de ap_opc_permi
 */
if ($_POST["caso"] === '1') {
    echo json_encode($OB_ap_opc_permi->leer(null, 1));
}

/*
 * proviene de ../js/modelos/ap_opc_permi.js opcion 2
 * retorna un LEFT OUTER JOIN entre opc_permi,ap_permpro y ar_roles  
 */
if ($_POST["caso"] === '2') {    
    $datos["id_rol"] = $_POST["datosAEnviar"]["id_rol"];
    $datos["codprog"] = $_POST["datosAEnviar"]["codprog"];
    echo json_encode($OB_ap_opc_permi->leer($datos, 2));
}


if($_POST["caso"]==='3'){
    
}