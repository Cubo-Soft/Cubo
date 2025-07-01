<?php

include_once '../modelos/CL_ir_operaciones.php';
include_once '../modelos/CL_nm_sucursal.php';

$OB_ir_operaciones=new CL_ir_operaciones();
$OB_nm_sucursal=new CL_nm_sucursal();

if($_POST["caso"]==='1'){

    //buscar los requerimientos para compras que tienen el estado=1 y cambiarlo a 120 
    //se deben actualizar los estados porque no se ha modificado el PA que se 
    //encarga de ello 
    $OB_ir_operaciones->actualizar(null, 1);
    echo json_encode($OB_ir_operaciones->leer(null,2));
}

if($_POST["caso"]==='2'){
    echo json_encode($OB_ir_operaciones->leer(null,3));
}

if($_POST["caso"]==='3'){
    echo json_encode($OB_ir_operaciones->leer(null,4));
}

if($_POST["caso"]==='4'){
    echo json_encode($OB_ir_operaciones->leer(null,5));
}

if($_POST["caso"]==='5'){

    $datos["fechaInicial"]=$_POST["datosAEnviar"]["fechaInicial"];
    $datos["fechaFinal"]=$_POST["datosAEnviar"]["fechaFinal"];
    $datos["estado"]=$_POST["datosAEnviar"]["estado"];

    $retorno=array();

    if(!empty($_POST["datosAEnviar"]["id_suc_cliente"])){     
        $datos["id_suc_cliente"]=$_POST["datosAEnviar"]["id_suc_cliente"];
        $retorno["ir_operaciones"]=$OB_ir_operaciones->leer($datos,6);        
    }    

    if(!empty($_POST["datosAEnviar"]["codemple"])){
        $datos["codemple"]=$_POST["datosAEnviar"]["codemple"];
        $retorno["ir_operaciones"]=$OB_ir_operaciones->leer($datos,7);    
    }

    if(!empty($_POST["datosAEnviar"]["cod_item"])){
        $datos["cod_item"]=$_POST["datosAEnviar"]["cod_item"];
        $retorno["ir_operaciones"]=$OB_ir_operaciones->leer($datos,8);    
    }

    if(!empty($_POST["datosAEnviar"]["id_operacion"])){
        $datos["id_operacion"]=$_POST["datosAEnviar"]["id_operacion"];
        $retorno["ir_operaciones"]=$OB_ir_operaciones->leer($datos,9);    
    }

    echo json_encode($retorno);
    

}