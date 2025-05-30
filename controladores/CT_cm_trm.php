<?php

include_once '../modelos/CL_cm_trm.php';

$OB_cm_trm = new CL_cm_trm();

if ($_POST["caso"] === '1') {
    $datos["fecha"] = date("Y-m-d");
    echo json_encode($OB_cm_trm->leer($datos, 1));
}

if ($_POST["caso"] === '2') {
    // Obtener la fecha actual    
    $fecha=new DateTime('now');
    $fechaActual=$fecha->format('Y-m-d');

    // Restar 15 días
    $datos["fecha1"] = date("Y-m-d", strtotime($fechaActual . " - 8 days"));
    $datos["fecha2"] = $fechaActual;

    echo json_encode($OB_cm_trm->leer($datos, 2));
}
