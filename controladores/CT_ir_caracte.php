<?php

include_once '../modelos/CL_ir_caracte.php';

$OB_ir_caracte=new CL_ir_caracte();

if($_POST["caso"]==='1'){
    
    $datos["codgrup"]=$_POST["datosAEnviar"]["codgrup"];
    echo json_encode($OB_ir_caracte->leer($datos, 1));
}