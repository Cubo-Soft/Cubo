<?php

include_once '../modelos/CL_nm_empleados.php';

$OB_nm_empleados=new CL_nm_empleados();

if($_POST["caso"]==='1'){
    $datos["numid"]=$_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_nm_empleados->leer($datos,1));
}