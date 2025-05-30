<?php 

include_once '../modelos/CL_ir_detalle_oper.php';

$OB_ir_detalle_oper=new CL_ir_detalle_oper();

if($_POST["caso"]==='1'){
    $datos["cantidad"]=$_POST["datosAEnviar"]["cantidad"];
    $datos["id_detalle"]=$_POST["datosAEnviar"]["id_detalle"];
    echo json_encode($OB_ir_detalle_oper->actualizar($datos,1));
}