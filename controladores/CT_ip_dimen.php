<?php

include_once '../modelos/CL_ip_dimen.php';

$OB_ip_dimen=new CL_ip_dimen();

if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_dimen->leer(null, 1));
}