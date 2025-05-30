<?php

include_once '../modelos/CL_nm_compleme.php';

$OB_nm_compleme = new CL_nm_compleme();

if ($_POST["caso"] === '1') {
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_nm_compleme->leer($datos, 1));
}

if ($_POST["caso"] === '2') {
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    $datos["credito"] = $_POST["datosAEnviar"]["credito"];
    $datos["factu_despacho"] = $_POST["datosAEnviar"]["factu_despacho"];
    $datos["docs_pra_facturar"] = $_POST["datosAEnviar"]["docs_pra_facturar"];
    $datos["area_contacto"] = $_POST["datosAEnviar"]["area_contacto"];
    echo json_encode($OB_nm_compleme->crear($datos, 1));
}

if ($_POST["caso"] === '3') {
    $datos["id_comple"] = $_POST["datosAEnviar"]["id_comple"];
    echo json_encode($OB_nm_compleme->leer($datos, 2));
}

if ($_POST["caso"] === '4') {

    $datos["credito"] = $_POST["datosAEnviar"]["credito"];
    $datos["id_comple"] = $_POST["datosAEnviar"]["id_comple"];
    $datos["factu_despacho"] = $_POST["datosAEnviar"]["factu_despacho"];
    $datos["docs_pra_facturar"] = $_POST["datosAEnviar"]["docs_pra_facturar"];
    $datos["area_contacto"] = $_POST["datosAEnviar"]["area_contacto"];
    $datos["cierre_factu"] = $_POST["datosAEnviar"]["cierre_factu"];

    echo json_encode($OB_nm_compleme->actualizar($datos, 1));
}