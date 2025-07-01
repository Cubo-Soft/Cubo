<?php

include_once '../modelos/CL_ip_voltajes.php';

$OB_ip_voltajes=new CL_ip_voltajes();

if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_voltajes->leer(null, 1));
}