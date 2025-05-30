<?php

include_once '../modelos/CL_ir_salinve.php';
include_once '../modelos/CL_im_items.php';
include_once '../modelos/CL_ir_resinve.php';

$OB_ir_salinve = new CL_ir_salinve();
$OB_im_items=new CL_im_items();
$OB_ir_resinve=new CL_ir_resinve();

$retono=array();

if ($_POST["caso"] === '1') {
    
    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"][0];
    
    $retorno["ir_salinve"]=$OB_ir_salinve->leer($datos, 1);    
    $retorno["im_items"]=$OB_im_items->leer($datos, 8);    
    
    echo json_encode($retorno);
}

if($_POST["caso"]==='2'){

    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];

    echo json_encode($OB_ir_salinve->leer($datos, 2));
}

if($_POST["caso"]==='3'){

    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];

    echo json_encode($OB_ir_salinve->leer($datos, 3));
}

if($_POST["caso"]==='4'){

    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];
    $datos["codbodeg"]=$_POST["datosAEnviar"]["codbodeg"];

    if($datos["codbodeg"]==='-2'){
        $retorno["ir_salinve"]=$OB_ir_salinve->leer($datos, 4);        
    }else{
        $retorno["ir_salinve"]=$OB_ir_salinve->leer($datos, 5);        
    }

    $retorno["ir_resinve"]=$OB_ir_resinve->leer($datos,2);

    echo json_encode($retorno);
}

if($_POST["caso"]==='5'){

    $arregloDatos=explode('_',$_POST["datosAEnviar"]["id"]);

    $datos["codbodeg"]=$arregloDatos[0];
    $datos["cod_item"]=$arregloDatos[1];
    $datos["saldo"]=$arregloDatos[2];
    $datos["numid"]=$arregloDatos[3];
    $datos["fecha_arribo"]=$arregloDatos[4];

    echo json_encode($OB_ir_resinve->borrar($datos,1));
}