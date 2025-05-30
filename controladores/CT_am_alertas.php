<?php

include_once '../modelos/CL_am_alertas.php';

$OB_am_alertas = new CL_am_alertas();

if ($_POST["caso"] === '1') {
    $datos["usuario_asignd"] = $_POST["datosAEnviar"]["usuario_asignd"];
    $datos["id_tipoalerta"] = $_POST["datosAEnviar"]["id_tipoalerta"];    
    echo json_encode($OB_am_alertas->leer($datos, 1));
}
