<?php

include_once '../modelos/CL_vp_asesor_zona.php';
include_once '../modelos/CL_nm_sucursal.php';

$OB_vp_asesor_zona = new CL_vp_asesor_zona();
$OB_nm_sucursal = new CL_nm_sucursal();


if ($_POST["caso"] === '1') {

    $datos["id_sucursal"] = $_POST["datosAEnviar"]["id_sucursal"];
    $data_nm_sucursal = $OB_nm_sucursal->leer($datos, 2);

    $datos["region"] = $data_nm_sucursal[0]["id_region"];
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    $datos["grupo"] = $_POST["datosAEnviar"]["grupo"];

    echo json_encode($OB_vp_asesor_zona->leer($datos,1));
}

if($_POST["caso"]==='2'){

    $datos["linea"] = $_POST["datosAEnviar"]["linea"];

    echo json_encode($OB_vp_asesor_zona->leer($datos,2));
}