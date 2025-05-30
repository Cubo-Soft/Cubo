<?php

include_once '../modelos/CL_nm_juridicas.php';

$OB_nm_juridicas = new CL_nm_juridicas();

if ($_POST["caso"] === '1') {
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_nm_juridicas->leer($datos, 1));
}

if ($_POST["caso"] === '2') {
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_nm_juridicas->leer($datos, 2));
}

if ($_POST["caso"] === '3') {
    $datos["razon_social"] = $_POST["datosAEnviar"]["razon_social"];
    echo json_encode($OB_nm_juridicas->leer($datos, 3));    
}

if ($_POST["caso"] === '4') {
    $datos["razon_social"] = $_POST["datosAEnviar"]["razon_social"];
    echo json_encode($OB_nm_juridicas->leer($datos, 4));
}

if ($_POST["caso"] === '5') {
    $datos["razon_social"] = $_POST["datosAEnviar"]["razon_social"];
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_nm_juridicas->crear($datos, 1));
}

if ($_POST["caso"] === '6') {
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_nm_juridicas->leer($datos, 5));
}

if ($_POST["caso"] === '7') {
    $datos["razon_social"] = $_POST["datosAEnviar"]["razon_social"];
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_nm_juridicas->actualizar($datos, 1));
}

if ($_POST["caso"] === '8') {
    $datos["razon_social"] = $_POST["datosAEnviar"]["razon_social"];    
    echo json_encode($OB_nm_juridicas->leer($datos, 6));
}

if($_POST["caso"]==='9'){
    $datos["razon_social"] = $_POST["datosAEnviar"]["razon_social"];    
    echo json_encode($OB_nm_juridicas->leer($datos, 7));
}