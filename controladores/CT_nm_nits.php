<?php

include_once '../modelos/CL_nm_nits.php';
include_once '../modelos/CL_nm_personas.php';
include_once '../modelos/CL_nm_juridicas.php';

$OB_nm_nits = new CL_nm_nits();
$OB_nm_personas = new CL_nm_personas();
$OB_nm_juridicas = new CL_nm_juridicas();

/*
 * proviene de nm_nits.js 
 * caso 1 
 */
if ($_POST["caso"] === '1') {

    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    $retorno["nm_nits"] = $OB_nm_nits->leer($datos, 1);

    if ($retorno["nm_nits"][0]["tipo_per"] === 23) {
        $retorno["nm_personas"] = $OB_nm_personas->leer($datos, 1);
    }

    echo json_encode($retorno);
}

if ($_POST["caso"] === '2') {
    $datos["id_contacto"] = $_POST["datosAEnviar"]["id_contacto"];
    echo json_encode($OB_nm_nits->leer($datos, 2));
}

/*
 * proviene de nm_nits.js
 * caso 3
 */
if ($_POST["caso"] === '3') {
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_nm_nits->leer($datos, 3));
}

/*
 * proviene de nm_nits.js
 * caso 4
 */
if ($_POST["caso"] === '4') {
    //consultar si existe el nit de llegada
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    $retorno["nm_nits"] = $OB_nm_nits->leer($datos, 4);

    //averiguar si es una empresa

    if (count($retorno["nm_nits"]) > 0) {
        if ($retorno["nm_nits"][0]["idclase"] === 31) {
            $datos["numid"] = $retorno["nm_nits"][0]["numid"];
            $retorno["nm_juridicas"] = $OB_nm_juridicas->leer($datos, 5);
        } else if ($retorno["nm_nits"][0]["idclase"] === 13) {
            $retorno["nm_personas"] = $OB_nm_personas->leer($datos, 1);
        }
    }

    //var_dump($retorno);

    echo json_encode($retorno);
}


/*
 * proviene de nm_nits.js 
 * function crearNMNits(data,opcion=1)
 * crea en nm_nits y nm_personas o nm_juridicas según el caso
 */

if ($_POST["caso"] === '5') {

    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    $datos["dv"] = $_POST["datosAEnviar"]["dv"];
    $datos["idclase"] = $_POST["datosAEnviar"]["idclase"];
    $datos["tipo_entidad"] = $_POST["datosAEnviar"]["tipo_entidad"];
    $datos["actividad"] = $_POST["datosAEnviar"]["actividad"];
    $datos["tipo_per"] = $_POST["datosAEnviar"]["tipo_per"];
    $datos["stdnit"] = $_POST["datosAEnviar"]["stdnit"];
    //$datos["nombre_empresa"] = $_POST["datosAEnviar"]["nombre_empresa"];

    if ($_POST["datosAEnviar"]["tipo_per"] === '23') {
        $datos["dv"] = 0;
    }

    $retorno["nm_nits"] = $OB_nm_nits->crear($datos, 1);

    echo json_encode($retorno);
}
/*
 * modifica los datos de nm_nits
 * proviene de nm_nits.js 
 * function actualizarNMNits(data,opcion)
 */
if ($_POST["caso"] === '6') {

    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    $datos["stdnit"] = $_POST["datosAEnviar"]["stdnit"];
    $datos["actividad"] = $_POST["datosAEnviar"]["actividad"];

    echo json_encode($OB_nm_nits->actualizar($datos, 1));
}

/*
 * retorna los datos de la persona juridica o natural con el id_contacto recibido
 * proviene de nm_nits.js
 * opcion=5
 * function actualizarNMNits(data,opcion)
 */
if ($_POST["caso"] === '7') {
    $datos["id_contacto"] = $_POST["datosAEnviar"]["id_contacto"];
    echo json_encode($OB_nm_nits->leer($datos, 5));
}


if($_POST["caso"]==='8'){
    $datos["nombre_persona"] = $_POST["datosAEnviar"]["nombre_persona"];
    echo json_encode($OB_nm_nits->leer($datos, 6));
}

if($_POST["caso"]==='9'){
    
    $datos["apelli_nom"]=$_POST["datosAEnviar"]["nombre_persona"];
    $retorno["nm_personas"]=$OB_nm_personas->leer($datos,6);

    $datos["razon_social"]=$_POST["datosAEnviar"]["nombre_persona"];
    $retorno["nm_juridicas"]=$OB_nm_juridicas->leer($datos,4);

    echo json_encode($retorno);
}