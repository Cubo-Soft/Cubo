<?php

include_once '../modelos/CL_cp_tipo_importacion.php';

$OB_cp_tipo_importacion=new CL_cp_tipo_importacion();

if($_POST["caso"]==='1'){
    echo json_encode($OB_cp_tipo_importacion->leer(null, 1));
}