<?php

include_once '../modelos/CL_ap_camposx.php';

$OB_ap_camposx=new CL_ap_camposx();

if($_POST["caso"]==='1'){

    $datos["id_rol"]=$_POST["datosAEnviar"]["id_rol"];
    $datos["tabla"]=$_POST["datosAEnviar"]["tabla"];
    echo json_encode($OB_ap_camposx->leer($datos,1));

}