<?php

include_once '../modelos/CL_nm_personas.php';
include_once '../modelos/CL_nm_sucursal.php';

$OB_nm_personas = new CL_nm_personas();
$OB_nm_sucursal=new CL_nm_sucursal();

if ($_POST["caso"] === '1') {

    $datos["apellidos"] = $_POST["datosAEnviar"]["apellidos"];
    $datos["nombres"] = $_POST["datosAEnviar"]["nombres"];

    $datos["sexo"] = '0';
    if ($_POST["datosAEnviar"]["sexo"] !== '-1') {
        $datos["sexo"] = $_POST["datosAEnviar"]["sexo"];
    }

    $datos["est_civil"] = '0';
    if ($_POST["datosAEnviar"]["est_civil"] !== '-1') {
        $datos["est_civil"] = $_POST["datosAEnviar"]["est_civil"];
    }

    $datos["fecha_naci"] = '0000-00-00';
    if ($_POST["datosAEnviar"]["fecha_naci"] !== '') {
        $datos["fecha_naci"] = $_POST["datosAEnviar"]["fecha_naci"];
    }

    $datos["tipo_sangre"] = '0';
    if ($_POST["datosAEnviar"]["tipo_sangre"] !== '-1') {
        $datos["tipo_sangre"] = $_POST["datosAEnviar"]["tipo_sangre"];
    }

    $datos["apelli_nom"] = $datos["apellidos"] . ' ' . $datos["nombres"];
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];

    echo json_encode($OB_nm_personas->crear($datos, 1));
}

if ($_POST["caso"] === '2') {

    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_nm_personas->leer($datos, 1));
}

if ($_POST["caso"] === '3') {

    $datos["apellidos"] = $_POST["datosAEnviar"]["apellidos"];
    $datos["nombres"] = $_POST["datosAEnviar"]["nombres"];

    $datos["sexo"] = '0';
    if ($_POST["datosAEnviar"]["sexo"] !== '-1') {
        $datos["sexo"] = $_POST["datosAEnviar"]["sexo"];
    }

    $datos["est_civil"] = '0';
    if ($_POST["datosAEnviar"]["est_civil"] !== '-1') {
        $datos["est_civil"] = $_POST["datosAEnviar"]["est_civil"];
    }

    $datos["fecha_naci"] = '0000-00-00';
    if ($_POST["datosAEnviar"]["fecha_naci"] !== '') {
        $datos["fecha_naci"] = $_POST["datosAEnviar"]["fecha_naci"];
    }

    $datos["tipo_sangre"] = '0';
    if ($_POST["datosAEnviar"]["tipo_sangre"] !== '-1') {
        $datos["tipo_sangre"] = $_POST["datosAEnviar"]["tipo_sangre"];
    }
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    $datos["apelli_nom"] = $datos["apellidos"] . ' ' . $datos["nombres"];

    echo json_encode($OB_nm_personas->actualizar($datos, 1));
}

if($_POST["caso"] === '4'){
    $datos["nombre_comercial"]=$_POST["datosAEnviar"]["nombre_comercial"];
    echo json_encode($OB_nm_personas->leer($datos,3));
}

if($_POST["caso"] === '5'){
    $datos["nombre_comercial"]=$_POST["datosAEnviar"]["nombre_comercial"];
    echo json_encode($OB_nm_personas->leer($datos,4));
}

if($_POST["caso"]==='6'){
    $datos["apelli_nom"]=$_POST["datosAEnviar"]["apelli_nom"];
    echo json_encode($OB_nm_personas->leer($datos,5));
}

if($_POST["caso"]==='7'){
    $datos["apelli_nom"]=$_POST["datosAEnviar"]["apelli_nom"];
    $retorno["nm_personas"]=$OB_nm_personas->leer($datos,5);

    if(count($retorno["nm_personas"])===0){
        $retorno["nm_sucursal"]=array();
    }else{
        $datos["numid"]=$retorno["nm_personas"][0]["numid"];        
        $retorno["nm_sucursal"]=$OB_nm_sucursal->leer($datos,1);
    }

    

    echo json_encode($retorno);
}