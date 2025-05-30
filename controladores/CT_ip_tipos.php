<?php

include_once '../modelos/CL_ip_tipos.php';

$OB_ip_tipos=new CL_ip_tipos();

if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_tipos->leer(null, 1));
}