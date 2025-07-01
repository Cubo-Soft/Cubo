<?php

session_start();

global $trm;

include_once '../modelos/CL_am_usuarios.php';
include_once '../modelos/CL_cm_trm.php';
include_once '../adicionales/varios.php';
include_once '../cls/varios.php';

$OB_am_usuarios = new CL_am_usuarios();
$OB_cm_trm = new CL_cm_trm();

//valida el usuario
//proviene de index.php
if ($_POST["caso"] === '1') {
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php");
    } else {
        $data_am_usuarios = $OB_am_usuarios->leer($_POST, 1);
        //var_dump($data_am_usuarios); exit();
        //trabajar con el usuario de la tabla de am_usuarios    
        if ($data_am_usuarios === NULL) {
            header("Location: ../index.php");
        } else if (count($data_am_usuarios) > 0) {

             if ($data_am_usuarios[0]["dt_basico"] === 'Activo') {
                $_SESSION["codusr"] = $data_am_usuarios[0]["codusr"];
                $_SESSION["estado"] = $data_am_usuarios[0]["dt_basico"];
                $_SESSION["nombre"] = $data_am_usuarios[0]["nombre"];
                $_SESSION["foto"] = $data_am_usuarios[0]["foto"];
                $_SESSION["id_rol"] = $data_am_usuarios[0]["id_rol"];
                $_SESSION["descrip_rol"] = $data_am_usuarios[0]["descrip_rol"];
                $_SESSION["numid"] = $data_am_usuarios[0]["numid"];
                $_SESSION["id_cargo"] = $data_am_usuarios[0]["id_cargo"];
                $trm = lee_politrm();
                $_SESSION["trmHoy"]=precioDolarHoy();

                $datos["fecha"] = date("Y-m-d");
                $data_cm_trm = $OB_cm_trm->leer($datos, 1);
                if (count($data_cm_trm) === 0) {
                    $datos["id_moneda"] = 35;
                    $datos["trm"] = precioDolarHoy();
                    $datos["fecha"] = date("Y-m-d");
                    $OB_cm_trm->crear($datos, 1);
                }

                 header("Location: ../vistas/index.php?mostrarValorTRM=1");

             } else {
                 header("Location: ../index.php");
             }
        } else {
            header("Location: ../index.php");
        }
    }
}

//cambia clave de usuario
//proviene de index.php
if ($_POST["caso"] === '2') {
    echo json_encode($OB_am_usuarios->actualizar($_POST["arregloEnvio"], 1));
}

/*
 * retorna la lista de usuarios completa a la función 
 * 
 */
if ($_POST["caso"] === '3') {
    echo json_encode($OB_am_usuarios->leer(null, 2));
}

/*
 * retornar la lista de solo asesores
 */

if ($_POST["caso"] === '4') {

    $datos["id_rol"] = $_POST["datosAEnviar"]["id_rol"];
    $datos["codusr"] = $_POST["datosAEnviar"]["codusr"];

    if (intval($datos["id_rol"]) <= 4) {
        echo json_encode($OB_am_usuarios->leer(null, 3));
    } else {
        echo json_encode($OB_am_usuarios->leer($datos, 4));
    }
}

if ($_POST["caso"] === "5") {
    echo json_encode($OB_am_usuarios->leer(null, 3));
}

//retorna la foto del usuario
if ($_POST["caso"] === "6") {
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    echo json_encode($OB_am_usuarios->leer($datos, 5));
}

//actualiza la foto del usuario
if($_POST["caso"]==="7"){
        
    $datos["numid"] = $_POST["numid"];
    $data_am_usuarios=$OB_am_usuarios->leer($datos,5);

    $rutaFoto = "../imagenes/avatar/";         
    $nombreArchivo = $rutaFoto . $data_am_usuarios[0]["codusr"].'.jpg';
    $datos["foto"]=$nombreArchivo;                
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $nombreArchivo)) {        
        echo json_encode($OB_am_usuarios->actualizar($datos,2));
    } else {
        echo json_encode(0);
    }

}