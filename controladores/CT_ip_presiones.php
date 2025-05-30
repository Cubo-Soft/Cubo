<?php

include_once '../modelos/CL_ip_presiones.php';

$OB_ip_presiones=new CL_ip_presiones();

if($_POST["caso"]==='1'){
    echo json_encode($OB_ip_presiones->leer(null, 1));
}