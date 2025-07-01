<?php

include_once '../modelos/CL_ip_modelos.php';

$OB_ip_modelos=new CL_ip_modelos();

if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_modelos->leer(null, 1));
}