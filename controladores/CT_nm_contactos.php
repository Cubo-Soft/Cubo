<?php

include_once '../modelos/CL_nm_contactos.php';

$OB_nm_contactos = new CL_nm_contactos();

/*
 * retorna los posibles nombres de los clientes
 */
if ($_POST["caso"] === '1') {
    $datos["nom_contacto"] = $_POST["datosAEnviar"]["nom_contacto"];
    echo json_encode($OB_nm_contactos->leer($datos, 1));
}

/*
 * retorna los posibles numeros de cc_contacto
 */
if ($_POST["caso"] === '2') {
    $datos["cc_contacto"] = $_POST["datosAEnviar"]["cc_contacto"];
    echo json_encode($OB_nm_contactos->leer($datos, 2));
}

/*
 * retorna los datos del contacto
 */
if ($_POST["caso"] === '3') {
    $datos["nom_contacto"] = $_POST["datosAEnviar"]["nom_contacto"];
    echo json_encode($OB_nm_contactos->leer($datos, 3));
}

/*
 * actualizar datos de contacto provenientes de tomarequerimiento.php
 */
if ($_POST["caso"] === '4') {
    $datos["nom_contacto"] = $_POST["datosAEnviar"]["nom_contacto"];
    $datos["email"] = $_POST["datosAEnviar"]["email"];
    $datos["cc_contacto"] = $_POST["datosAEnviar"]["cc_contacto"];
    $datos["tel_contacto"] = $_POST["datosAEnviar"]["tel_contacto"];
    $datos["estado"] = $_POST["datosAEnviar"]["estado"];
    $datos["id_contacto"]=$_POST["datosAEnviar"]["id_contacto"];    
    echo json_encode($OB_nm_contactos->actualizar($datos, 1));
}

/*
 * retornar toda la lista de contactos de una sucursal
 */
if ($_POST["caso"] === '5') {
    $datos["id_sucursal"] = $_POST["datosAEnviar"]["id_sucursal"];
    echo json_encode($OB_nm_contactos->leer($datos, 4));
}

/*
 * proviene de retornarNMContatos(data,6) en nm_contactos.js
 * retorna los datos de un contacto de una sucursal
 */
if ($_POST["caso"] === '6') {
    $datos["id_contacto"] = $_POST["datosAEnviar"]["id_contacto"];
    echo json_encode($OB_nm_contactos->leer($datos, 5));
}

/*
 * proviene de nm_contactos.js function actualizarNMContactos(datos, 2) {
 * actualiza todos los datos de un contacto con el id_contacto
 */

if ($_POST["caso"] === '7') {
    $datos["nom_contacto"] = $_POST["datosAEnviar"]["nom_contacto"];
    $datos["email"] = $_POST["datosAEnviar"]["email"];
    $datos["cc_contacto"] = $_POST["datosAEnviar"]["cc_contacto"];
    $datos["tel_contacto"] = $_POST["datosAEnviar"]["tel_contacto"];
    $datos["cargo"] = $_POST["datosAEnviar"]["cargo"];
    $datos["id_contacto"] = $_POST["datosAEnviar"]["id_contacto"];
    $datos["estado"] = $_POST["datosAEnviar"]["estado"];
    echo json_encode($OB_nm_contactos->actualizar($datos, 1));
}

/*
 * crear un contacto 
 */

if ($_POST["caso"] === '8') {
    $datos["nom_contacto"] = $_POST["datosAEnviar"]["nom_contacto"];
    $datos["email"] = $_POST["datosAEnviar"]["email"];
    $datos["cc_contacto"] = $_POST["datosAEnviar"]["cc_contacto"];
    $datos["tel_contacto"] = $_POST["datosAEnviar"]["tel_contacto"];
    $datos["cargo"] = $_POST["datosAEnviar"]["cargo"];
    //$datos["id_contacto"] = $_POST["datosAEnviar"]["id_contacto"];
    $datos["id_sucursal"] = $_POST["datosAEnviar"]["id_sucursal"];
    //var_dump($datos);
    echo json_encode($OB_nm_contactos->crear($datos, 1));
}

if($_POST["caso"]==='9'){
    $datos["id_contacto"] = $_POST["datosAEnviar"]["id_contacto"];
    echo json_encode($OB_nm_contactos->crear($datos, 9));
}