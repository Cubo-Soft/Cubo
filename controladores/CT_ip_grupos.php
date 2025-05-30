<?php

include_once '../modelos/CL_ip_grupos.php';

$OB_ip_grupos=new CL_ip_grupos();

if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_grupos->leer(null, 1));
}

if($_POST["caso"]==='2'){
    
    $datos["ip_lineas"]=$_POST["datosAEnviar"]["ip_lineas"];
    $datos["id_grupos"]=$_POST["datosAEnviar"]["id_grupos"];
        
    echo json_encode($OB_ip_grupos->leer($datos, 2));
}

if($_POST["caso"]==='3'){
    echo json_encode($OB_ip_grupos->leer(null, 5));
}