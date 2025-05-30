<?php

session_start();

include_once("../modelos/CL_vr_cotizcar.php");

$OB_vr_cotizcar=new CL_vr_cotizcar();

if($_POST["caso"] === '1') {

    $datos["vr_caract"]=$_POST["datosAEnviar"]["vr_caract"];
    $datos["id_cotcar"]=$_POST["datosAEnviar"]["id_cotcar"];
    
    echo json_encode($OB_vr_cotizcar->actualizar($datos,1));
}
