<?php

include_once '../modelos/CL_nm_sucursal.php';
include_once '../modelos/CL_np_ciudades.php';

$OB_nm_sucursal = new CL_nm_sucursal();
$OB_np_ciudades = new CL_np_ciudades();

if ($_POST["caso"] === '1') {
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_nm_sucursal->leer($datos, 1));
}

if ($_POST["caso"] === '2') {
    $datos["id_sucursal"] = $_POST["datosAEnviar"]["id_sucursal"];
    echo json_encode($OB_nm_sucursal->leer($datos, 2));
}

/*
 * modifica los datos de la sucursal. Viene de nm_sucursal.js
 * function modificarNMSucursal(null,1)
 */
if ($_POST["caso"] === '3') {
    $datos["id_sucursal"] = $_POST["datosAEnviar"]["id_sucursal"];
    $datos["nom_sucur"] = $_POST["datosAEnviar"]["nom_sucur"];
    $datos["ciudad"] = $_POST["datosAEnviar"]["np_ciudades"];
    $datos["id_ciudad"] = $_POST["datosAEnviar"]["np_ciudades"];
    $datos["direccion"] = $_POST["datosAEnviar"]["direccion"];
    $datos["telefono"] = $_POST["datosAEnviar"]["telefono"];
    $datos["suc_lng_gps"] = $_POST["datosAEnviar"]["suc_lng_gps"];
    $datos["suc_lat_gps"] = $_POST["datosAEnviar"]["suc_lat_gps"];
    $datos["suc_lat_gps"] = $_POST["datosAEnviar"]["suc_lat_gps"];
    $datos["estado"] = $_POST["datosAEnviar"]["estado"];
    $datos["cod_clie_helisa"] = $_POST["datosAEnviar"]["codigo_helisa"];
    $datos["id_region"] = $_POST["datosAEnviar"]["id_region"];
    
    $datosNPCiudades = $OB_np_ciudades->leer($datos, 4);
    $datos["pais"] = $datosNPCiudades[0]["id_pais"];

    echo json_encode($OB_nm_sucursal->actualizar($datos, 1));
}

/*
 * crea los datos de la sucursal. Viene de nm_sucursal.js
 * function crearNMSucursal(null, 1) {
 */

if ($_POST["caso"] === '4') {

    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    $datosNMSucursal = $OB_nm_sucursal->leer($datos, 1);

    if (count($datosNMSucursal) === 0) {
        $datos["orden"] = 0;
    } else {
        $datos["orden"] = intval($datosNMSucursal[0]["orden"]) + 1;
    }

    if (is_string($_POST["datosAEnviar"]["tipo_entidad"]) && $_POST["datosAEnviar"]["tipo_entidad"] === '74') {
        $datos["cod_clie_helisa"] = $_POST["datosAEnviar"]["codigo_helisa"];
        $datos["cod_prv_helisa"] = '0';
    } else {
        $datos["cod_clie_helisa"] = '0';
        $datos["cod_prv_helisa"] = $_POST["datosAEnviar"]["codigo_helisa"];
    }

    $datos["id_sucursal"] = $_POST["datosAEnviar"]["id_sucursal"];
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    $datos["nom_sucur"] = $_POST["datosAEnviar"]["nom_sucur"];
    $datos["ciudad"] = $_POST["datosAEnviar"]["np_ciudades"];
    $datos["id_ciudad"] = $_POST["datosAEnviar"]["np_ciudades"];
    $datos["direccion"] = $_POST["datosAEnviar"]["direccion"];
    $datos["telefono"] = $_POST["datosAEnviar"]["telefono"];
    $datos["telefono2"] = $_POST["datosAEnviar"]["telefono2"];
    $datos["fax"] = $_POST["datosAEnviar"]["fax"];
    $datos["suc_lng_gps"] = $_POST["datosAEnviar"]["suc_lng_gps"];
    $datos["suc_lat_gps"] = $_POST["datosAEnviar"]["suc_lat_gps"];
    $datos["id_region"] = $_POST["datosAEnviar"]["id_region"];

    $datosNPCiudades = $OB_np_ciudades->leer($datos, 4);
    $datos["pais"] = $datosNPCiudades[0]["id_pais"];

    echo json_encode($OB_nm_sucursal->crear($datos, 1));
}
