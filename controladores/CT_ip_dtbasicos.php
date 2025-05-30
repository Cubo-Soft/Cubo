<?php

include_once '../modelos/CL_ip_dtbasicos.php';

$OB_ip_dtbasicos = new CL_ip_dtbasicos();

if ($_POST["caso"] === '1') {
    $datos["id_basico"] = $_POST["datosAEnviar"]["id_basico"];
    echo json_encode($OB_ip_dtbasicos->leer($datos, 2));
}

if ($_POST["caso"] === '2') {

    $datos["estado"] = $_POST["datosAEnviar"]["estado"];
    $datos["sec_basico"] = $_POST["datosAEnviar"]["sec_basico"];
    
    $retonar[0] = 1;
    $retonar[1] = $OB_ip_dtbasicos->actualizar($datos, 1);

    echo json_encode($retonar);
}

/**
 * Proviene de  basicos_ipbasicos en el evento onclick 
 * del botón btnCrearDTBasico de la interfaz basicos_ipbasicos.php 
 */
if($_POST["caso"]==='3'){
    $datos["id_basico"]=$_POST["datosAEnviar"]["id_basico"];
    $datos["dt_basico"]=$_POST["datosAEnviar"]["dt_basico"];
    echo json_encode($OB_ip_dtbasicos->crear($datos,1));
}

if ($_POST["caso"] === '4') {
    $datos["id_basico"] = $_POST["datosAEnviar"]["id_basico"];
    echo json_encode($OB_ip_dtbasicos->leer($datos, 3));
}

if ($_POST["caso"] === '5') {
    $datos["sec_basico"] = $_POST["datosAEnviar"]["sec_basico"];
    $datos["dt_basico"] = $_POST["datosAEnviar"]["dt_basico"];
    echo json_encode($OB_ip_dtbasicos->actualizar($datos, 2));
}
