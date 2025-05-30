<?php

include_once '../modelos/CL_ap_permpro.php';
include_once '../modelos/CL_ar_roles.php';

$OB_ap_permpro = new CL_ap_permpro();
$OB_ar_roles = new CL_ar_roles();

/*
 * proviene de /js/modelos/ap_permpro.js
 * function retornarAPPermpro(opcion)
 */
if ($_POST["caso"] === '1') {
    $datos["codprog"] = $_POST["codprog"];
    echo json_encode($OB_ap_permpro->leer($datos, 2));
}

/*
 * proviene de /js/modelos/ap_permpro.js
 * function cambiarAPPermpro(id,opcion)
 */
if ($_POST["caso"] === '2') {

    $retorno = array();

    $data["codprog"] = $_POST["datosAEnviar"]["codprog"];
    $data["permpro"] = $_POST["datosAEnviar"]["permpro"];
    if ($_POST["datosAEnviar"]["estado"] === 'true') {
        $estado = 1;
    } else {
        $estado = 0;
    }
    $data["estado"] = $estado;
    $data["id_permpro"] = $_POST["datosAEnviar"]["id_permpro"];

    //si el permiso no existe 
    if (!is_numeric($_POST["datosAEnviar"]["id_permpro"])) {

        if ($estado === 1) {
            $retorno[0] = 0;
            //crear el permiso
            $retorno[1] = $OB_ap_permpro->crear($data, 1);
        }
        
    } else {
        //si el permiso si existe
        $retorno[0] = 1;
        //actualizar el permiso
        $retorno[1] = $OB_ap_permpro->actualizar($data, 1);
    }

    echo json_encode($retorno);
}