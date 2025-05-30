<?php

include_once '../modelos/CL_ap_subzonas.php';

$OB_ap_subzonas = new CL_ap_subzonas();

if ($_POST["caso"] === '1') {
    echo json_encode($OB_ap_subzonas->leer(null, 1));
}

if ($_POST["caso"] === '2') {
    $datos["id_zona"] = $_POST["datosAEnviar"]["id_zona"];
    echo json_encode($OB_ap_subzonas->leer($datos, 2));
}

if ($_POST["caso"] === '3') {
    $datos["id_subzona"] = $_POST["datosAEnviar"]["id_subzona"];
    echo json_encode($OB_ap_subzonas->leer($datos, 3));
}

if ($_POST["caso"] === '4') {
    echo json_encode($OB_ap_subzonas->leer(null, 4));
}

if ($_POST["caso"] === '5') {
    $datos["nom_subzona"] = $_POST["datosAEnviar"]["nom_subzona"];
    $datos["id_zona"] = $_POST["datosAEnviar"]["ap_zonas"];
    $datos["estado"] = 80;
    echo json_encode($OB_ap_subzonas->crear($datos, 1));
}

if ($_POST["caso"] === '6') {

    $datos["id_zona"] = $_POST["datosAEnviar"]["id_zona"];
    $datos["nom_subzona"] = $_POST["datosAEnviar"]["nom_subzona"];
    $datos["estado"] = $_POST["datosAEnviar"]["estado"];
    $datos["id_subzona"] = $_POST["datosAEnviar"]["id_subzona"];

    if (strlen($datos["nom_subzona"]) === 0) {
        echo json_encode($OB_ap_subzonas->actualizar($datos, 2));
    } else {
        echo json_encode($OB_ap_subzonas->actualizar($datos, 1));
    }
}