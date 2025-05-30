<?php

include_once '../modelos/CL_ip_basicos.php';

$OB_ip_basicos=new CL_ip_basicos();


if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_basicos->leer(null, 1));
}