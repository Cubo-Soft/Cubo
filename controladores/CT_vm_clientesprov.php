<?php

session_start();

include_once '../modelos/CL_vm_clientesprov.php';

$OB_vm_clientesprov = new CL_vm_clientesprov();

/*
 * retorna los posibles nombres de los clientes
 */
if ($_POST["caso"] === '1') {
    $datos["nombre"] = $_POST["datosAEnviar"]["nombre"];
    echo json_encode($OB_vm_clientesprov->leer($datos, 1));
}

/*
 * retorna el id_provis del nombre que llega
 */

if ($_POST["caso"] === '2') {
    $datos["nombre"] = $_POST["datosAEnviar"]["nombre"];
    echo json_encode($OB_vm_clientesprov->leer($datos, 2));
}

/*if ($_POST["caso"] === '3') {
    $datos["nombre"] = $_POST["datosAEnviar"]["nombre"];
    $datos["direccion"] = $_POST["datosAEnviar"]["direccion"];
    $datos["telefono"] = $_POST["datosAEnviar"]["telefono"];
    $datos["email"] = $_POST["datosAEnviar"]["email"];
    $datos["contacto"] = $_POST["datosAEnviar"]["contacto"];
    $datos["nit_cliente"] = $_POST["datosAEnviar"]["nit_cliente"];    
    $datos["grabador"] = $_SESSION["codusr"];
    $datos["fechora"] = date("Y-m-d H:m:s");
    echo json_encode($OB_vm_clientesprov->crear($datos, 1));
}*/


/* Nuevo if caso 3 Daniel2025*/
if ($_POST["caso"] === '3') {
    // Recibir los datos del cliente
    $datos["nombre"] = $_POST["datosAEnviar"]["nombre"];
    $datos["direccion"] = $_POST["datosAEnviar"]["direccion"];
    $datos["telefono"] = $_POST["datosAEnviar"]["telefono"];
    $datos["email"] = $_POST["datosAEnviar"]["email"];
    $datos["contacto"] = $_POST["datosAEnviar"]["contacto"];
    $datos["nit_cliente"] = $_POST["datosAEnviar"]["nit_cliente"];    
    $datos["grabador"] = $_SESSION["codusr"];
    $datos["fechora"] = date("Y-m-d H:i:s");

    // Llamamos al modelo para crear o actualizar el cliente provisional
    $resultado = $OB_vm_clientesprov->crear($datos, 1);
    
    // Responder con el mensaje adecuado
    echo json_encode(['success' => $resultado]);
}
