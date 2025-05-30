<?php

include_once '../modelos/CL_ap_zonas.php';

$OB_ap_zonas=new CL_ap_zonas();

if($_POST["caso"]==='1'){
    $datos["region"]=$_POST["datosAEnviar"]["region"];
    echo json_encode($OB_ap_zonas->leer($datos, 1));
}

if($_POST["caso"]==='2'){
    $datos["id_zona"]=$_POST["datosAEnviar"]["id_zona"];
    $datos["nom_zona"]=$_POST["datosAEnviar"]["nom_zona"];
    $datos["estado"]=$_POST["datosAEnviar"]["estado"];
    $datos["region"]=$_POST["datosAEnviar"]["region"];
    echo json_encode($OB_ap_zonas->actualizar($datos, 1));
}

if($_POST["caso"]==='3'){
    $datos["id_zona"]=$_POST["datosAEnviar"]["id_zona"];    
    $datos["estado"]=$_POST["datosAEnviar"]["estado"];    
    echo json_encode($OB_ap_zonas->actualizar($datos, 2));
}

if($_POST["caso"]==='4'){
    $datos["id_zona"]=$_POST["datosAEnviar"]["id_zona"];
    $datos["nom_zona"]=$_POST["datosAEnviar"]["nom_zona"];    
    $datos["region"]=$_POST["datosAEnviar"]["region"];
    echo json_encode($OB_ap_zonas->crear($datos, 1));
}