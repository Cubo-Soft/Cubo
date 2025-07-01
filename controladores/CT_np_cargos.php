<?php

include_once '../modelos/CL_np_cargos.php';

$OB_np_cargos=new CL_np_cargos();

if($_POST["caso"]==='1'){
    echo json_encode($OB_np_cargos->leer(null,1));
}