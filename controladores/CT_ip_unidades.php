<?php

include_once '../modelos/CL_ip_unidades.php';

$OB_ip_unidades=new CL_ip_unidades();

if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_unidades->leer(null, 1));
}