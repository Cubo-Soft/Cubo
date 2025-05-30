<?php

include_once '../modelos/CL_ip_articulos.php';

$OB_ip_articulos=new CL_ip_articulos();

if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_articulos->leer(null, 3));
}