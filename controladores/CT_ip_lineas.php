<?php


include_once '../modelos/CL_ip_lineas.php';

$OB_ip_lineas=new CL_ip_lineas();

if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_lineas->leer(null, 1));
}