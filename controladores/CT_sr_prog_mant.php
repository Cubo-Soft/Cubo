<?php

include_once '../modelos/CL_sr_prog_mant.php';
include_once '../modelos/CL_ip_grupos.php';

$OB_sr_prog_mant=new CL_sr_prog_mant();
$OB_ip_grupos=new CL_ip_grupos();

$retorno=array();

if($_POST["caso"]==='1'){

    $retorno["tipos_mantenimiento"]=$OB_ip_grupos->leer(null,4);

    $datos["suc_cliente"]=$_POST["datosAEnviar"]["suc_cliente"];
    $retorno["sr_prog_mant"]=$OB_sr_prog_mant->leer($datos,1);

    echo json_encode($retorno);

}