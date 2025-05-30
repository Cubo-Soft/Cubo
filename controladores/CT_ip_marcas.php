<?php

include_once '../modelos/CL_ip_marcas.php';

$OB_ip_marcas=new CL_ip_marcas();

if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_marcas->leer(null, 1));
}