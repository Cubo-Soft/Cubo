<?php

include_once '../modelos/CL_np_tiponit.php';

$OB_np_tiponit=new CL_np_tiponit();

if($_POST["caso"]==='1'){
    echo json_encode($OB_np_tiponit->leer(null, 1));
}